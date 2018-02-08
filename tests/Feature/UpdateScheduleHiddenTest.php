<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdateScheduleHiddenTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->put(route('schedules.update', 1), [
            'hidden' => true
        ]);
        dd($response);
        $this->assertTrue(true);
    }
}
