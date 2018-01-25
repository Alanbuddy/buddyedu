<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class ScheduleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'user' . str_random(5),
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'merchant_id' => 1,
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
        \App\Models\Schedule::find(1)->students()->attach($user , [
            'type' => 'student',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
        ]);
        \App\Models\Merchant::find(1)->users()->attach($user);
    }
}
