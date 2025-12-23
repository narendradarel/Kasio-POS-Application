<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Owner Toko',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'), // Passwordnya: password
            'role' => 'admin', // Sesuaikan jika ada kolom role
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}