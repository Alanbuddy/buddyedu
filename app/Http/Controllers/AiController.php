<?php

namespace App\Http\Controllers;

use App\Http\Util\Curl;
use CURLFile;
use Illuminate\Http\Request;

class AiController extends Controller
{
    public function cut(Request $request)
    {
        $url = "http://192.168.1.116:3000/cut";
        $request->getContent();
        $response = Curl::request($url);
        dd($response);
    }

    public function form()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        $file = $request->file('file');
//        dd(file_get_contents($file->getRealPath()));
//        dd(file_get_contents("php://temp"));
//        dd($request->getContent());
//        dd(file_get_contents($request->file('file')));
        $url = 'http://192.168.1.116:3000/cut';
        $upload_file = new CURLFile($file->getRealPath());
        $post_data = array(
            'file' => $upload_file
        );
        $result = Curl::request($url, $post_data, 'post');
        dd($result);
    }
}
