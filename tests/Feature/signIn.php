<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class signIn extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
//        $this->actingAs(User::find(1));
        $response = $this->post(route('schedule.signIn'), [
            'users' => [1, 2],
            'status' => 'applying',
            'schedule_id' => 1,
            'point_id' => 1,
            'merchant_id' => 1
        ]);
        $response->assertStatus(200);
    }
}
