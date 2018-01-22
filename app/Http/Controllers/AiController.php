<?php

namespace App\Http\Controllers;

use App\Http\Util\Curl;
use App\Models\File;
use App\Models\Record;
use CURLFile;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class AiController extends Controller
{
    use FileTrait;

    public function __construct()
    {
        $this->middleware('va');
    }

    public function cut(Request $request)
    {
        Log::debug(json_encode($request->headers));
        Log::debug(__METHOD__ . __LINE__ . "\n" . $request->get('api_token'));
        $url = env('AI_CUT_URL');
        $file = $request->file('file');
        $upload_file = new CURLFile($file->getRealPath());//eg.  /tmp/phpeU0gU6
        $post_data = [
            'file' => $upload_file
        ];
        try {
            list($result, $timeCost) = timedProxy(
                function () use ($url, $post_data, $request) {
                    return Curl::request($url, $post_data, 'post');
                });
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
        $target = $this->move($file);
        $entry = $this->store2DB($file, $target);
        $entry->fill($request->only(['merchant_id', 'student_id', 'point_id', 'schedule_id', 'ordinal_no', 'uuid']));
        $entry->save();
//        dd($file,$target);
        $merchant_id = 1;
        $student_id = 1;
        $schedule_id = 1;
        $this->recordApiCall($request->route()->getName(), $entry->path, $timeCost, $merchant_id, $schedule_id, $student_id, $result);

        return $result;
    }


    public function store2DB(UploadedFile $file, $target)
    {
        $item = new File();
        $item->path = substr($target->getPathname(), strlen(public_path()));
//        $item->user_id = 1;
        $item->user_id = auth()->user()->id;
        $item->fill($this->getFileMeta($file));
        $item->save();
        return $item;
    }

    public function recordApiCall($api, $file, $time_cost = 0, $merchant_id = null, $schedule_id, $student_id = null, $result = null)
    {
        $record = new Record();
        $record->api = $api;
        $record->file = $file;
        $record->time_cost = $time_cost;
        $record->merchant_id = $merchant_id;
        $record->schedule_id = $schedule_id;
        $record->user_id = 1;
//        $record->user_id = auth()->user()->id;
        $record->student_id = $student_id;
        $record->result = $result;
        $record->save();
        return $record;
    }

    public function bone(Request $request)
    {
        $url = env('AI_BONE_URL');
        $file = $request->file('file');
        $animal = $request->get('animal');
        $upload_file = new CURLFile($file->getRealPath());
        $post_data = [
            'file' => $upload_file,
            'animal' => $animal,
        ];
        list($result, $timeCost) = timedProxy(function () use ($url, $post_data, $request) {
            return Curl::request($url, $post_data, 'post');
        });
        $target = $this->move($file);
        $entry = $this->store2DB($file, $target);
        $entry->save();
        $merchant_id = 1;
        $student_id = 1;
        $schedule_id = 1;
        $this->recordApiCall($request->route()->getName(), $entry->path, $timeCost, $merchant_id, $schedule_id, $student_id, $result);
        Log::debug(strlen($result));
        return $result;
    }

    public function form()
    {
        return view('form');
    }

    public function store(Request $request)
    {
        Log::debug(json_encode(auth()->user()));
        $file = $request->file('file');
//        Log::debug($request->getContent(true));
        Log::debug(__METHOD__ . __LINE__ . "\n" . $request->get('api_token'));
//        return (file_get_contents($file->getRealPath()));
//        dd(file_get_contents("php://temp"));
//        dd($request->getContent());
//        Log::debug(file_get_contents($request->file('file')));
        $url = 'http://192.168.1.107:3000/cut';
        $upload_file = new CURLFile($file->getRealPath());
        $post_data = [
            'file' => $upload_file
        ];
        try {
            $result = Curl::request($url, $post_data, 'post');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
