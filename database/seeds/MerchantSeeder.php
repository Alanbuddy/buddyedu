<?php

use Illuminate\Database\Seeder;

class MerchantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('merchants')->insert([
            'name' => '万科成长中心',
            'admin_id' => 2,
            'status' => 'authorized'
        ]);
        DB::table('merchants')->insert([
            'name' => '蝴蝶页国际童书馆',
            'admin_id' => 3,
            'status' => 'authorized'
        ]);
        DB::table('merchants')->insert([
            'name' => '熊小米',
            'admin_id' => 4,
            'status' => 'authorized'
        ]);
    }
}
