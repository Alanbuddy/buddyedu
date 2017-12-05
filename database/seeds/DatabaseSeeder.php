<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(SettingSeeder::class);
        $this->call(MerchantSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(PointSeeder::class);
        $this->call(ScheduleSeeder::class);
        $this->call(ScheduleUserSeeder::class);
        $this->call(AttendanceSeeder::class);
    }
}
