<?php

namespace Tests\Feature;

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
        $response = $this->post(route('users.store'), [
            'name' => 'teacherDemo',
            'phone' => '122' . rand(1000000, 29999999),
//            'phone' => '17610076052',
            'merchant_id' => 1
        ]);
        $response->assertStatus(200);
    }
}
