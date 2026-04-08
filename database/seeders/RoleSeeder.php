<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // ← add this

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('roles')->insert([
            ['role_name' => 'admin'],
            ['role_name' => 'staff'],
            ['role_name' => 'customer'],
        ]);
    }
}