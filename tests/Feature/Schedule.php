<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Schedule extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('schedules.store'), [
            'begin' => '2017-11-17',
            'end' => '2017-11-18',
            'status' => 'applying',
            'course_id' => 1,
            'point_id' => 1,
            'merchant_id' => 1
        ]);
        $response->assertStatus(200);
    }
}
