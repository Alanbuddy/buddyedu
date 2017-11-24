<?php

namespace Tests\Feature;

use App\Models\User;
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
        $this->actingAs(User::find(3));
        $response = $this->post(route('schedule.signIn'), [
            'users' => [1, 2],
            'teacher_id' => auth()->user()->id,
            'schedule_id' => 1,
            'point_id' => 1,
            'merchant_id' => 1,
            'api_token'=>auth()->user()->api_token
        ]);
        $response->assertStatus(200);
    }
}
