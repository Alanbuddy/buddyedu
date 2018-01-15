<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    use FileTrait;

    public function __construct()
    {
        $this->middleware('role:amdin')->only(['index']);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('chunks')) {
            return $this->chunkUpload($request);
        }
        $file = $request->file('file');
        $target = $this->move($file);
        $entry = $this->store2DB($file, $target);
        $entry->fill($request->only('schedule_id', 'merchant_id', 'point_id', 'student_id'));
        $entry->save();
        if ($request->has('editor'))
            return ['errno' => 0, 'data' => [env('APP_URL') . $entry->path]];
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
//        dd($file['id']);
//        dd((new static));
//        dd(File::kk());
        dd(Str::random(32));
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
        $file = new File();
        auth()->user()->files()->save($file);
        return ['success' => true, 'data' => $file];
    }

    public function chunkUpload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
            'chunk' => 'required',
            'file_id' => 'required',
        ]);
//        Log::info('-----' . $request->chunk);
        Redis::setnx('file' . $request->file_id, $this->defaultDirectory());
//        Log::info(Redis::get('file' . $request->file_id));
        if ($request->chunk == 0) {
            $file = File::find($request->file_id);
            $file->description = $request->chunks;
            $attr = $this->getFileBaseInfo($request->file('file'));
            $file->fill($attr);
            if ($request->has('mime')) $file->mime = $request->mime;
            if ($request->has('merchant_id')) $file->merchant_id = $request->merchant_id;
            $file->save();
//            session(['file' . $file->id => $this->defaultDirectory()]);
//            Log::info(__FILE__.__LINE__.session('file' . $file->id));
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
