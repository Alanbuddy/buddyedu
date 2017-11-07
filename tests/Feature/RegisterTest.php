<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;


class RegisterTest extends TestCase
{
    /**
     * create a merchant
     *
     * @return void
     */
    public function testExample()
    {
        $this->actingAs(User::find(1));
        $response = $this->json('POST', '/merchants', [
            'name' => 'Sally',
            'adminName' => 'AdminSally',
            'phone' => '189' . rand(1000000, 99999999)
        ]);
//        dd($response->exception);
        $response->assertStatus(200);
    }

    public function testCourseAuthorization()
    {
        $uri = route('merchant.course.authorize', ['merchant' => 1, 'course' => 1, 'operation' => 'attach']);
        $uri = route('merchant.course.authorize', ['merchant' => 1, 'course' => 1, 'operation' => 'detach']);
        $this->actingAs(User::find(1));
        $response = $this->json('GET', $uri, [
            'name' => 'Sally',
        ]);
//        dd($response->exception);
        $response->assertStatus(200);
    }
}

