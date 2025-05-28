<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Pastikan namespace model User benar

class AdminSeeder extends Seeder // Ubah nama class
{
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'jeremimangatur21s08@gmail.com',
                'password' => 'password123', 
            ],
        ];

        foreach ($users as $data) {
            if (!User::where('email', $data['email'])->exists()) {
                User::create([
                    'nama' => $data['nama'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                ]);
            }
        }
    }
}