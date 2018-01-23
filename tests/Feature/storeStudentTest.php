<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class storeStudentTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('schedule.student.store', 1), [
            'name' => str_random(5),
            'phone' => str_random(15),
            'gender' => 'male',
            'birthday' => '2000-10-10'
        ]);
        dd($response->getStatusCode());
        $response->assertStatus(200);
    }
}
