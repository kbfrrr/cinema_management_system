<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // ← add this
use Illuminate\Support\Facades\Hash; // ← add this

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $adminRoleId = DB::table('roles')->where('role_name', 'admin')->value('role_id');
        $customerRoleId = DB::table('roles')->where('role_name', 'customer')->value('role_id');

        DB::table('users')->insert([
            [
                'name'       => 'Admin',
                'email'      => 'admin@cinema.com',
                'password'   => Hash::make('password'),
                'role_id'    => $adminRoleId,
                'created_at' => now(),
            ],
            [
                'name'       => 'Customer',
                'email'      => 'customer@cinema.com',
                'password'   => Hash::make('password'),
                'role_id'    => $customerRoleId,
                'created_at' => now(),
            ],
        ]);
    }
}