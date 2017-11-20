<?php

use Illuminate\Database\Seeder;

class PointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('points')->insert([
            'name' => 'demo point',
            'merchant_id' => 1,
            'area'=>'1000',
            'address'=>'street',
            'province_id' => 1,
            'city_id' => 2,
            'county_id' => 3
        ]);
    }
}
