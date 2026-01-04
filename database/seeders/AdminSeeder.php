<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Membership; // Pastikan import ini ada
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan Membership 'Free' ada dulu (karena Model User Anda membutuhkannya)
        // Kalau Anda sudah punya MembershipSeeder terpisah, bagian ini bisa dihapus.
        if (Membership::count() == 0) {
             Membership::create([
                'name' => 'Free',
                'price' => 0,
             ]);
        }

        // 2. Buat Akun Admin
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@kasio.com', 
            'password' => Hash::make('password123'), 
            'role' => 'admin', 
            'email_verified_at' => now(),
        ]);
    }
}