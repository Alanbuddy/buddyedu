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
            'name' => '朝阳区望京万科大厦',
            'admin' => '田纯',
            'contact' => '18010196003',
            'merchant_id' => 1,
            'area' => '1000',
            'address' => '朝阳区望京万科大厦',
            'geolocation' => '[39.998424,116.469433]',
            'province' => '北京市',
            'city' => '北京市',
            'approved'=>true,
            'county' => '朝阳区'
        ]);

        DB::table('points')->insert([
            'name' => '北角公园内紫竹书苑',
            'admin' => '孙左满',
            'contact' => '18601004314',
            'merchant_id' => 2,
            'area' => '1000',
            'address' => '西城区马甸桥东北角公园内紫竹书苑',
            'geolocation' => '[39.96817,116.38042]',
            'province' => '北京市',
            'city' => '北京市',
            'approved'=>true,
            'county' => '西城区'
        ]);
        DB::table('points')->insert([
            'name' => '熊小米',
            'admin' => '于导',
            'contact' => '13811089551',
            'merchant_id' => 3,
            'area' => '1000',
            'address' => '景龙国际b座',
            'geolocation' => '[39.96817,116.38042]',
            'province' => '北京市',
            'city' => '北京市',
            'approved'=>true,
            'county' => '朝阳区'
        ]);
    }
}
