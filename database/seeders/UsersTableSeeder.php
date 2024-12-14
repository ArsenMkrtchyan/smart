<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'female' => 'Mkrtchyan',
            'email' => 'admin@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 4,
            'password' => bcrypt('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Role1',
            'female' => 'Mkrtchyan',
            'email' => 'role1@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 1,
            'password' => bcrypt('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Role2',
            'female' => 'Mkrtchyan',
            'email' => 'Role2@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 2,
            'password' => bcrypt('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Role3',
            'female' => 'Mkrtchyan',
            'email' => 'Role3@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 3,
            'password' => bcrypt('12341234'),
        ]);

    }
}
