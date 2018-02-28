<?php

namespace App\Http\Controllers\Notice;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminNoticeController extends AbstractNoticeController
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index(Request $request)
    {
        list($query, $key) = $this->indexQuery($request);
        $items = $query->paginate(4);
        if ($key)
            $items->withPath(route('notices.index') . '?' . http_build_query(['key' => $key,]));
        return view('admin.notice.index', compact('items', 'key'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content' => 'required'
        ]);
        $item = Notice::create($request->only([
            'title', 'content'
        ]));
        return ['success' => true, 'data' => $item];
    }

    public function show(Notice $notice)
    {
        return view('admin.notice.show', compact('notice'));
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return ['success' => true];
    }
}
