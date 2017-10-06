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
        $institution = Role::firstOrCreate([
            'name' => 'institution'
        ]);
        $teacher = Role::firstOrCreate([
            'name' => 'teacher'
        ]);
        $admin = Role::firstOrCreate([
            'name' => 'admin'
        ]);
        $operator = Role::firstOrCreate([
            'name' => 'operator'
        ]);
        $user = User::find(3);
        $user->attachRole($admin);
    }
}
