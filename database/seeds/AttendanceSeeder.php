<?php

use Illuminate\Database\Seeder;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            DB::table('attendances')->insert([
                'student_id' => 1,
                'teacher_id' => 3,
                'merchant_id' => 1,
                'point_id' => 1,
                'ordinal_no' => $i+1,
                'schedule_id' => 1,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
