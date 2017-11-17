<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class Point extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->post(route('points.store'), [
            'name'=>'point_demo',
            'area'=>'1000',
            'address'=>'street',
            'province_id' => 1,
            'city_id' => 2,
            'county_id' => 3,
            'merchant_id'=>1,
        ]);
        $response->assertStatus(200);
    }
}
