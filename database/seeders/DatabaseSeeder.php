<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Panggil AdminSeeder kamu
        $this->call([
            AdminSeeder::class,
            // Kamu bisa tambahkan seeder lain di sini nanti
        ]);
    }
}