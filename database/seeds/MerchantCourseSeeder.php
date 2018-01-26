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
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'status' => 'applying',
            'quantity' => 200,
            'is_batch' => 1
        ]);
        DB::table('course_merchant')->insert([
            'merchant_id' => 2,
            'course_id' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'status' => 'applying',
            'is_batch' => 0
        ]);
    }
}
