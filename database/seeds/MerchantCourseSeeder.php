<?php

use Illuminate\Database\Seeder;

class MerchantCourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('course_merchant')->insert([
            'merchant_id' => 1,
            'course_id' => 1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'status'=>'applying'
        ]);
        DB::table('course_merchant')->insert([
            'merchant_id' => 2,
            'course_id' => 1,
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now(),
            'status'=>'applying'
        ]);
    }
}
