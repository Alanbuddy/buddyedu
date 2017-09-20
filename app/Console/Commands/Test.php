<?php

namespace App\Console\Commands;

use App\Http\Util\Curl;
use CURLFile;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't';

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
    public function handle()
    {
        $this->info(route('api.login'));
//        $data = $this->getBytes('中国');
//        $this->info(implode('',$data));//e4b8ade59bbd

//        file_put_contents('dumpc',$data);
//        $this->encodeBin(416);
        return;

//        $this->postLocalFile();
        $result = $this->postServerFile();
        file_put_contents('dump', $result);
        Log::debug(__METHOD__ . __LINE__ . "\n" . $result);
        dd($this->dumpBinaryData($result));
//        $this->info($result);
//        $bstr = file_get_contents('dump');
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
        $url = 'http://192.168.1.116:3000/cut';
//        $result=Curl::request($url,[]);

        $upload_file = new CURLFile('/home/gao/projects/django_demo/GetSegmentation.png');
        $post_data = array(
            'file' => $upload_file
        );
        $result = Curl::request($url, $post_data, 'post');
        dd($result);
    }

    public function postServerFile()
    {
        $url = 'http://edu.com/file';
        $url = 'http://edu.com/api/file';
        $url = 'http://edu.com/api/v1/cut';
        $upload_file = new CURLFile('/home/gao/projects/django_demo/GetSegmentation.png');
        $post_data = array(
            'file' => $upload_file,
            'name' => 'aaa',
            'api_token' => '1443e624-160e-3752-bd8d-80f4953a1fa6',
        );
        return Curl::request($url, $post_data, 'post');
    }

}
