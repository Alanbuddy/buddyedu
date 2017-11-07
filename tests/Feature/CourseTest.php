<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStore()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('courses.store'), [
            'name' => 'course1',
            'price' => 11
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);
    }
}
