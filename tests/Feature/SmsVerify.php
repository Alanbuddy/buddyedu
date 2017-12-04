<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SmsVerify extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->post(route('sms-verify.validate'), [
            'phone' => '18911209450',
            'token' => '194008'
        ]);
        dd($response->content());
        $response->assertStatus(200);
    }
}
