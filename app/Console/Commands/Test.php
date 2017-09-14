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
        $url='http://192.168.1.116:3000/cut';
//        $result=Curl::request($url,[]);

        $upload_file = new CURLFile('/home/gao/projects/django_demo/GetSegmentation.png');
        $post_data = array(
            'file' => $upload_file
        );
        $result=Curl::request($url,$post_data,'post');
        dd($result);
    }
}
