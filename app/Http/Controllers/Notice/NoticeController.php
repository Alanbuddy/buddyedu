<?php

namespace App\Http\Controllers\Notice;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends AbstractNoticeController
{
    public function index(Request $request, Notice $notice)
    {
        list($query, $key) = $this->indexQuery($request);
        $items = $query->paginate();
        if ($key)
            $items->withPath(route('notices.index') . '?' . http_build_query(['key' => $key,]));
        return view('mobile.notice-list', compact('items', 'key'));
    }

    public function show(Notice $notice)
    {
        return view('mobile.notice-show', compact('notice'));
    }

}
