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

        DB::table('seoroles')->insert([
            'name' => 'տնօրեն',

        ]);
        DB::table('seoroles')->insert([
            'name' => 'փոխտնօրեն',

        ]);


        DB::table('roles')->insert([
            'name' => 'Admin',

        ]);
        DB::table('roles')->insert([
            'name' => 'Role1',

        ]);
        DB::table('roles')->insert([
            'name' => 'Role2',

        ]);
        DB::table('roles')->insert([
            'name' => 'Role3',

        ]);
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
            'name' => 'Varduhi',
            'female' => 'Pashoyan',
            'email' => 'role1@admin.com',
            'number'=> '+37494777041',
            'is_admin' => 1,
            'role_id' => 1,
            'password' => bcrypt('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Artur',
            'female' => 'Mkrtchayn',
            'email' => 'Role2@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 2,
            'password' => bcrypt('12341234'),
        ]);
        DB::table('users')->insert([
            'name' => 'Armen',
            'female' => 'Ardaryan',
            'email' => 'Role3@admin.com',
            'number'=> '+37494756057',
            'is_admin' => 1,
            'role_id' => 3,
            'password' => bcrypt('12341234'),
        ]);

    }
}
