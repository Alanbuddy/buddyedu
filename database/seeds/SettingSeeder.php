<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([ 'key' => 'access_token',
            'value' => '{"access_token":"example","expire_time":1497937039}' ]);
    }
}
