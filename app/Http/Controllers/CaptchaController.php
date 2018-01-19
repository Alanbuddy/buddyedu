<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CaptchaController extends Controller
{
    public function generate(Request $request)
    {
        captcha();
    }

    public function verify(Request $request)
    {
//        dd(session()->all());
        $rules = ['captcha' => 'required|captcha'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
//            echo '<p style="color: #ff0000;">Incorrect!</p>';
            return ['success' => false];
        } else {
//            echo '<p style="color: #00ff30;">Matched :)</p>';
            return ['success' => true];
        }

    }
}
