<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCreateTeacher()
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