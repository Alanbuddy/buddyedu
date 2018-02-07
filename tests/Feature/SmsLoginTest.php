<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmsLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post(route('api.login.sms'), [
            'phone'=>'12312341234',
            'token'=>'123456'
        ]);
        dd($response->status());
        $response->assertStatus(200);
    }
}
