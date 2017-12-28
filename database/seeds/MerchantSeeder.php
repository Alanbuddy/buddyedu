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
            'name' => 'demo merchant 1',
            'admin_id' => 2,
            'status' => 'authorized'
        ]);
        DB::table('merchants')->insert([
            'name' => 'demo merchant 2',
            'admin_id' => 1,
            'status' => 'authorized'
        ]);
    }
}
