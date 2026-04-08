<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('genres')->insert([
            ['genre_name' => 'Action'],
            ['genre_name' => 'Comedy'],
            ['genre_name' => 'Drama'],
            ['genre_name' => 'Horror'],
            ['genre_name' => 'Romance'],
            ['genre_name' => 'Sci-Fi'],
            ['genre_name' => 'Thriller'],
            ['genre_name' => 'Animation'],
        ]);
    }
}