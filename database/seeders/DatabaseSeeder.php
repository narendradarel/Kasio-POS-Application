<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            MembershipSeeder::class, // Jalankan ini duluan
            UserSeeder::class,       // Baru buat user
            UserMembershipSeeder::class, // Baru assign paket ke user
        ]);
    }
}