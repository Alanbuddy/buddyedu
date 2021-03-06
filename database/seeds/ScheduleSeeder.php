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
        for ($i = 0; $i < 4; $i++) {
            $schedule = \App\Models\Schedule::create([
//            'begin' => date('Y-m-d'),
                'begin' => date('Y-m-d H:i:s', strtotime(($i - 1) . ' month')),
                'end' => date('Y-m-d H:i:s', strtotime('+4 month')),
                'status' => 'applying',
                'quota' => 20,
                'course_id' => 1,
                'price' => 1,
                'point_id' => 1,
                'merchant_id' => 1,
                'lessons_count'=>12,
            ]);
            $schedule->teachers()->sync([5 => ['type' => 'teacher'], 6 => ['type' => 'teacher']]);
        }

        for ($i = 0; $i < 4; $i++) {
            $schedule = \App\Models\Schedule::create([
//            'begin' => date('Y-m-d'),
                'begin' => date('Y-m-d H:i:s', strtotime(($i - 1) . ' month')),
                'end' => date('Y-m-d H:i:s', strtotime('+4 month')),
                'status' => 'applying',
                'quota' => 20,
                'course_id' => 1,
                'price' => 15,
                'point_id' => 1,
                'merchant_id' => 2,
                'lessons_count'=>11,
            ]);
            $schedule->teachers()->sync([7 => ['type' => 'teacher']]);
        }
    }
}
