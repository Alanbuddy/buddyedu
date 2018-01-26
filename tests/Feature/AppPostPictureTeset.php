<?php

namespace Tests\Feature;

use App\Models\User;
use CURLFile;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AppPostPictureTeset extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $upload_file = new CURLFile('/home/aj/projects/django_demo/GetSegmentation.png');
        $upload_file->setMimeType("image/jpeg");//必须指定文件类型，否则会默认为application/octet-stream，二进制流文件
        $response = $this->post(url('/api/v1/files'), [
            'file' => $upload_file,
            'user_id' => 1,
            'student_id' => 1,
            'uuid' => 1,
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        ]);
        $response->assertStatus(200);
    }
}
