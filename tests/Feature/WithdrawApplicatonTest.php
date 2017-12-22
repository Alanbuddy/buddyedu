<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WithdrawApplicatonTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('applications.store'), [
            'type' => 'withdraw',
            'merchant_id' => 1,
            'amount' => 3
        ]);
        $response->assertStatus(200);
    }
}
