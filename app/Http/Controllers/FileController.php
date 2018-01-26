<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    use FileTrait;

    public function __construct()
    {
//        $this->middleware('role:amdin')->only(['index']);
//        $this->middleware('role:amdin|merchant')->only(['download']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = File::orderBy('id', 'desc')->paginate(10);
//        return $items;
        return view('files', compact('items'));
    }

    public function store(Request $request)
    {
        if ($request->has('chunks')) {
            return $this->chunkUpload($request);
        }
        Log::debug($request->all());
        $file = $request->file('file');
        $target = $this->move($file);
        if ($request->has('file_id')) {
            $entry = File::find($request->file_id);
            $entry->fill($this->getFileMeta($file));
            $entry->path = $this->getRelativePath($target);
            $entry->save();
        } else {
            $entry = $this->store2DB($file, $target);
            $entry->fill($request->only('schedule_id', 'merchant_id', 'point_id', 'student_id', 'ordinal_no', 'uuid'));
            DB::transaction(function () use ($entry, $request) {
                File::where('uuid', $request->uuid)->update(['student_id', $request->student_id]);
                $entry->save();
            });
        }
        if ($request->has('editor'))
            return ['errno' => 0, 'data' => [$entry->path]];
        return ['success' => true, 'data' => $entry];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        dd(redirect()->intended()->getTargetUrl());
        dd(func_get_args());
        session(['a' => 3333]);
        return (session('a'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        Storage::delete('public' . substr($file->path, 8));
        $file->delete();
        return ['success' => true];
    }

    public function download(File $file)
    {
        $content = Storage::disk('local')->get('public' . substr($file->path, 8));
        return (new Response($content, 200))
            ->header('Content-Type', $file->mime);
    }

    public function initChunkUpload(Request $request)
    {
        $this->validate($request, []);
        $file = new File(['merchant_id' => $request->merchant_id]);
        auth()->user()->files()->save($file);
        Redis::set('file' . $file->id, $this->defaultDirectory());
//        Log::info(Redis::get('file' . $request->file_id));
        return ['success' => true, 'data' => $file];
    }

    public function chunkUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
            'chunk' => 'required',
            'file_id' => 'required',
        ]);
        if ($request->chunk == 0) {
            $file = File::find($request->file_id);
            $file->description = $request->chunks;
            $attr = $this->getFileBaseInfo($request->file('file'));
            $file->fill($attr);
            if ($request->has('mime')) $file->mime = $request->mime;
            if ($request->has('merchant_id')) $file->merchant_id = $request->merchant_id;
            $file->save();
        }
        return $this->moveChunk($request);
    }

    public function moveChunk(Request $request)
    {
        $index = $request->get('chunk');
        $name = $request->get('name');
        $file = $request->file('file');
        $size = $file->getSize();
        $filename = $name . $index;
        $this->move($file, Redis::get('file' . $request->file_id), $filename);
//        $this->move($file, session('file' . $request->file_id), $filename);
        $pid = posix_getpid();
        Log::info("process: $pid chunk-$index size:" . $size . ' file_id:' . $request->file_id);
//        Log::info('session'.session('file' . $request->file_id));
        return ['success' => true];
    }

    public function mergeFile(Request $request)
    {
        $this->validate($request, ['file_id' => 'required']);
        $file = File::find($request->file_id);
        $ret = $this->merge($request, $file->description);
        $file->path = substr($ret['path'], strlen(public_path()));
        $file->save();
        return $ret;
    }

    public function merge(Request $request, $chunksCount)
    {
        $this->validate($request, [
            'name' => 'required',
        ]);
        $fileName = $request->get('name');
        $targetPath = Redis::get('file' . $request->file_id) . DIRECTORY_SEPARATOR . $fileName;
        $dst = fopen($targetPath, 'wb');
        Log::info('about to merge ' . $chunksCount . 'chunks');
        $size = 0;
        for ($i = 0; $i < $chunksCount; $i++) {
            $chunk = $targetPath . $i;
            $src = fopen($chunk, 'rb');
            $size += stream_copy_to_stream($src, $dst);
            fclose($src);
            unlink($chunk);
            Log::info('merged chunk' . $chunk);
        }
        Log::info('merged total size:' . $size);
        File::find($request->file_id)->update(compact('size'));
        Redis::del('file' . $request->file_id);
        return ['success' => true, 'path' => $targetPath, 'fileName' => $fileName];
    }

    public function getFileBaseInfo($file)
    {
        $item['name'] = $file->getClientOriginalName();
        $item['mime'] = $file->getClientMimeType();
        $item['extension'] = $file->getClientOriginalExtension();
        $item['size'] = $file->getClientSize();
        return $item;
    }
}
