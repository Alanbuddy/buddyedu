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
            'phone' => '18911209450',
            'password' => bcrypt('secret'),
            'api_token' => '1509a743-cd29-38fb-867c-c2cc42b84b3d'
        ]);
        //merchant admin
        DB::table('users')->insert([
            'name' => 'merchant_admin_demo',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'api_token' => \Faker\Provider\Uuid::uuid(),
        ]);
        //teacher
        DB::table('users')->insert([
            'name' => 'teacher demo',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '17610076052',
            'password' => bcrypt('secret'),
            'merchant_id' => 1,
            'api_token' => 'da262427-88c6-356a-a431-8686856c81b3',
        ]);
        //teacher
        DB::table('users')->insert([
            'name' => 'teacher demo 2',
            'email' => str_random(10) . '@gmail.com',
            'phone' => '1' . rand(1000000000, 9999999999),
            'password' => bcrypt('secret'),
            'merchant_id' => 1,
            'api_token' => 'za262427-88c6-356a-a431-8686856c81b5',
        ]);



    }
}
