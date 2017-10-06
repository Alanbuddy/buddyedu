<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->insert([
            'name' => str_random(10),
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
    }
}
