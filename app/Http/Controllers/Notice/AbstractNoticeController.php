<?php

namespace App\Http\Controllers\Notice;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

abstract class AbstractNoticeController extends Controller
{
    public function indexQuery(Request $request)
    {
        $items = Notice::orderByDesc('id');
        if ($key = $request->key) {
            $items->where(function ($query) use ($key) {
                $query->where('title', 'like', '%' . $key . '%')
                    ->orWhere('content', 'like', '%' . $key . '%');
            });
        }
        return array($items, $key);
    }
}
