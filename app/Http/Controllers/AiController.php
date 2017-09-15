<?php

namespace App\Http\Controllers;

use App\Http\Util\Curl;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        Log::debug(__METHOD__ . $file->getRealPath());
//        return (file_get_contents($file->getRealPath()));
//        dd(file_get_contents("php://temp"));
//        dd($request->getContent());
//        dd(file_get_contents($request->file('file')));
        $url = 'http://192.168.1.116:3000/cut';
        $upload_file = new CURLFile($file->getRealPath());
        $post_data = [
            'file' => $upload_file
        ];
        try {
            $result = Curl::request($url, $post_data, 'post');
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        file_put_contents('dump', $result);
        return $result;
    }

    function toStr($bytes)
    {
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }
}
