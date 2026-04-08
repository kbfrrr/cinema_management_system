<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;   // ← add this
use Illuminate\Support\Facades\Hash; // ← add this

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name'       => 'Admin',
                'email'      => 'admin@cinema.com',
                'password'   => Hash::make('admin1234'),
                'role_id'    => 1,
                'created_at' => now(),
            ],
            [
                'name'       => 'Customer',
                'email'      => 'customer@cinema.com',
                'password'   => Hash::make('customer1234'),
                'role_id'    => 3,
                'created_at' => now(),
            ],
        ]);
    }
}