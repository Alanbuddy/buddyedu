<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $items = Notice::orderByDesc('id');
        if ($key = $request->key) {
            $items->join('courses', 'courses.id', '=', 'schedules.course_id')
                ->where('courses.name', 'like', "%$key%");
        }
        $items = $items->paginate(10);
        if ($key)
            $items->withPath(route('notice.index') . '?' . http_build_query(['key' => $key,]));
        return view('admin.notice.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required'
        ]);
        $item = Notice::create($request->only([
            'title', 'body'
        ]));
        return ['success' => true, 'data' => $item];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notice $notice
     * @return \Illuminate\Http\Response
     */
    public function show(Notice $notice)
    {
        return view('admin.notice.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notice $notice
     * @return \Illuminate\Http\Response
     */
    public function edit(Notice $notice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Notice $notice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notice $notice)
    {
        //
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return ['success' => true];
    }
}
