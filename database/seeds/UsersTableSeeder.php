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
        //admin
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '12312341234',
            'password' => bcrypt('secret'),
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        ]);
        DB::table('users')->insert([
            'name' => 'merchant_admin_demo',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
    }
}
