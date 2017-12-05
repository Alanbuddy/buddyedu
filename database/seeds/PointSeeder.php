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
            'admin'=>'admin name',
            'contact'=>'19938293382',
            'merchant_id' => 1,
            'area'=>'1000',
            'address'=>'street',
            'province' => 1,
            'city' => 2,
            'county' => 3
        ]);
    }
}
