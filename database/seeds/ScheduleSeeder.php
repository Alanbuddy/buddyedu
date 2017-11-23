<?php

use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('schedules')->insert([
            'begin' => date('Y-m-d'),
            'end' => date('Y-m-d H:i:s',strtotime('+4 hour')),
            'status' => 'applying',
            'course_id' => 1,
            'point_id' => 1,
            'merchant_id' => 1
        ]);
    }
}
