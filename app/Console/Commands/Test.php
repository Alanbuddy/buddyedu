<?php

namespace App\Console\Commands;

use App\Http\Util\Curl;
use CURLFile;
use Illuminate\Console\Command;

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
//        $this->postLocalFile();
        $result = $this->postServerFile();
        file_put_contents('dump', $result);
        dd($this->dumpBinaryData($result));
//        Log::debug($result);
        $this->info($result);
//        $bstr = file_get_contents('dump');
    }

    public function dumpBinaryData($data)
    {
        $bytes = $this->getBytes($data);
        return '\x' . implode('\x', $bytes);
    }

    public function getBytes($string)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($string); $i++) {
//            $bytes[] = ord($string[$i]);
            $bytes[] = bin2hex($string[$i]);
        }
        return $bytes;
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
        $upload_file = new CURLFile('/home/gao/projects/django_demo/GetSegmentation.png');
        $post_data = array(
            'file' => $upload_file,
            'name' => 'aaa'
        );
        return Curl::request($url, $post_data, 'post');
    }
}
