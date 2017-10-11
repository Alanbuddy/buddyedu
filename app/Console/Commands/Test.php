<?php

namespace App\Console\Commands;

use App\Http\Util\Curl;
use CURLFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't {method?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    function b()
    {
        return function ($carry, $item) {
            $carry += $item;
            return $carry;
        };
    }

    public function handle()
    {
//        $arr = [1, 2, 3];
//        $r = array_reduce($arr, $this->b(),function(){return 3;});
//        $this->info($r);
//        return;

//        $data = $this->getBytes('中国');
//        $this->info(implode('',$data));//e4b8ade59bbd

//        file_put_contents('dumpc',$data);
//        $this->encodeBin(416);
//        $this->postLocalFile();

//        $this->testRegisterApi();
//        $this->testLoginApi();
//        $this->testRateLimit();

//        $this->info(Storage::prepend('public/2017_09_21_113331GetSegmentation.png','1111'));
//        $this->info(Storage::lastModified('public/2017_09_21_113331GetSegmentation.png'));
//        $this->info(Storage::delete('public/phpMjHvw1'));
//        $this->info(Storage::size('public/phpMjHvw1'));

//        dd(Storage::fake('avatars'));
//        $file=UploadedFile::fake()->image('avatar.jpg',100 ,200)->size(1000);
//        $file->move(storage_path());
//        $file=UploadedFile::fake()->create('document.pdf', 100);
//        $file->move(storage_path(),'document.pdf');
//        file_put_contents('dump',"123\r\n123");
//        return;

//        $result = $this->testResetPasswordApi();
//        $result = $this->testResetSendToken();

        $method = $this->argument('method');
        if ($method) {
            $result = call_user_func([$this, $method]);
        } else {
            $this->info('Method list:');
            foreach (get_class_methods($this) as $k => $v) {
                if (Str::startsWith($v, 'post'))
                    $this->info($v);
            }
            $result = $this->postServerFile();
        }

//        $result = $this->postServerFile_Bone();
        file_put_contents('dump.html', $result);
        Log::debug(__METHOD__ . __LINE__ . "\n" . $result);
        dd($this->dumpBinaryData($result));
//        $this->info($result);
//        $bstr = file_get_contents('dump');
    }

    public function testRateLimit()
    {
        $result = Curl::request('http://edu.com/api/files');//route('files.index')
        $this->info($result);
    }

    public function testLoginApi()
    {
        $data = [
            'phone' => '12312341237',
            'password' => '123456',
        ];
        $result = Curl::request('http://edu.com/api/login', $data, 'post');
        $this->info($result);
    }

    public function testRegisterApi()
    {
        $data = [
            'name' => 'b',
//            'email' => 'cdb@example.163.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => '123456',
            'password_confirmation' => '123456',
        ];
        $result = Curl::request('http://edu.com/api/register', $data, 'post');
        $this->info($result);
        Log::debug($result);
    }

    public function testResetSendToken()
    {
        $result = Curl::request('http://edu.com/password/sms/send?phone=18911209450');
        $this->info($result);
        return $result;

    }

    public function testResetPasswordApi()
    {
        $data = [
            'phone' => '189112094',
            'password' => '123456',
            'password_confirmation' => '123456',
            'token' => '442243',
        ];
        $result = Curl::request('http://edu.com/api/password/reset', $data, 'post');
        $this->info($result);
        Log::debug($result);
    }


    public function dumpBinaryData($data)
    {
        $bytes = $this->getBytes($data);
        return '\x' . implode('\x', $bytes);
    }

    /**
     * example:
     * [ 94 171 392 416]
     * "\x5e\x00\xab\x00\x88\x01\xa0\x01"
     * @param $str
     * @param bool $isBinaryData
     * @return array
     * @internal param $string
     */
    public function getBytes($str, $isBinaryData = true)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($str); $i++) {
            if (!$isBinaryData)
                $str[$i] = pack('C', ord($str[$i]));//format 参数 C - unsigned char
//            $bytes[] = ord($string[$i]);
            $bytes[] = bin2hex($str[$i]);
        }
        return $bytes;
    }

    /**
     * 输出数字的二进制表示
     * input 416
     * output "110100000"
     * @param $num
     * @param int $base
     */
    public function encodeBin($num, $base = 2)
    {
        if ($num > 0) {
            $this->encodeBin(intval($num / $base), $base);
            printf("%d", $num % $base);
        }
    }

    public function postLocalFile()
    {
        $url = env('AI_CUT_URL');
//        $result=Curl::request($url,[]);

        $upload_file = new CURLFile('/home/gao/projects/django_demo/GetSegmentation.png');
        $upload_file->setMimeType("image/jpeg");//必须指定文件类型，否则会默认为application/octet-stream，二进制流文件
        $post_data = array(
            'file' => $upload_file
        );
        $result = Curl::request($url, $post_data, 'post');
        dd($result);
    }

    public function postServerFile()
    {
//        $url = 'http://edu.com/file';
        $url = 'http://edu.com/api/v1/cut';
        $upload_file = new CURLFile('/home/aj/projects/django_demo/GetSegmentation.png');
        $upload_file->setMimeType("image/jpeg");//必须指定文件类型，否则会默认为application/octet-stream，二进制流文件
        $post_data = array(
            'file' => $upload_file,
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        );
        return Curl::request($url, $post_data, 'post');
    }

    public function postServerFile_Bone()
    {
        $url = 'http://edu.com/api/v1/bone';
        $upload_file = new CURLFile('/home/aj/projects/django_demo/GetSegmentation.png');
        $post_data = array(
            'file' => $upload_file,
            'animal' => 'goose',
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        );
        return Curl::request($url, $post_data, 'post');
    }

    public function postVideo()
    {
        $url = 'http://edu.com/api/files';
        $url = 'http://edu.com/api/v1/files';
        $upload_file = new CURLFile('/home/aj/projects/django_demo/GetSegmentation.png');
        $upload_file->setMimeType("image/jpeg");//必须指定文件类型，否则会默认为application/octet-stream，二进制流文件
        $post_data = array(
            'file' => $upload_file,
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        );
        return Curl::request($url, $post_data, 'post');
    }

}
