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
            'name' => 'demo merchant',
            'admin_id' => 1,
        ]);
    }
}
