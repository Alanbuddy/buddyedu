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
//        $this->middleware('va')->except('getAppUpdate');
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
        try {
            $this->recordApiCall($request->route()->getName(), $entry->path, $timeCost, $merchant_id, $schedule_id, $student_id, $result);
        } catch (\Exception $e) {
        }
        if (strpos($result, 'ERROR') === 0)
            return ['success' => 'false', 'message' => $result];
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

    public function getAppUpdate(Request $request)
    {
        Log::debug($request->all());
        $descriptor = array(
            0 => array("pipe", "r"), //标准输入，子进程从此管道读取数据
            1 => array("pipe", "w"), //标准输出，子进程向此管道写入数据
            2 => array("file", "/tmp/error-output.txt", "a")    //标准错误，写入到指定文件
        );
        $cwd = '/home/aj/projects/a.com/';
        $process = proc_open("/home/aj/projects/a.com/updateAssetBundle " . $request->v, $descriptor, $pipes, $cwd);
//        $cmd = 'zip $(git rev-parse HEAD).zip $(git --no-pager diff --name-only '.$request->v. '$(git rev-parse HEAD))';
//        $cmd = 'zip $(git rev-parse HEAD).zip $(git --no-pager diff --name-only $1 $(git rev-parse HEAD))';
//        $process = proc_open($cmd, $descriptor, $pipes);

        if (is_resource($process)) {
            fwrite($pipes[0], $request->v);
            fclose($pipes[0]);
            $result = stream_get_contents($pipes[1]);
            $name = explode('+', $result)[0];
            fclose($pipes[1]);
            proc_close($process);   //在调用proc_close之前必须关闭所有管道
        }
        $content = file_get_contents("$cwd$name.zip");
        return response($content, 200)
            ->header('Content-Type', 'application/x-zip-compressed')
            ->header('Content-Disposition', 'attachment;filename=' . $name . '.zip');
    }

}
