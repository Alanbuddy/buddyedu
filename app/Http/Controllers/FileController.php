<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();
        return ['success' => true];
    }

    public function download(File $file)
    {
        $content = Storage::disk('local')->get('public' . substr($file->path, 8));
        return (new Response($content, 200))
            ->header('Content-Type', $file->mime);
    }
}
