<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BatchEnrollTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(2));
        $response = $this->post(route('schedule.student.batch-enroll',1), [
            'students' => [7, 8],
        ]);
        dd( $response->getStatusCode());
        $response->assertStatus(200);
    }
}
