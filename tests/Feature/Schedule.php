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
            'begin' => date('Y-m-d'),
            'end' => date('Y-m-d H:i:s',strtotime('+4 hour')),
            'status' => 'applying',
            'course_id' => 1,
            'point_id' => 1,
            'merchant_id' => 1
        ]);
        $response->assertStatus(200);
    }
}
