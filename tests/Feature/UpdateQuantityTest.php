<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateQuantityTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('merchant.course.quantity.update', ['merchant' => 1, 'course' => 1]), [
            'quantity' => 3
        ]);
        $response->assertStatus(200);
    }
}
