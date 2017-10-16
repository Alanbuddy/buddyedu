<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(Request $request)
    {
//        dd($request->route()->computedMiddleware);
//        throw new \Exception();
        return 33333;
    }

    public function apiIndex(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        return 2;
    }
}
