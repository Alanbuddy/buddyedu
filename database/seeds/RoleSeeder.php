<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::firstOrCreate([
            'name' => 'admin'
        ]);
        $merchant = Role::firstOrCreate([
            'name' => 'merchant'
        ]);
        $teacher = Role::firstOrCreate([
            'name' => 'teacher'
        ]);
        $operator = Role::firstOrCreate([
            'name' => 'operator'
        ]);
        $user = User::find(1);
        $user->attachRole($admin);
        $user = User::find(2);
        $user->attachRole($merchant);
        $user = User::find(3);
        $user->attachRole($teacher);
        $user = User::find(4);
        $user->attachRole($teacher);
    }
}
