<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Paket FREE (Sesuai Screenshot)
        DB::table('memberships')->insert([
            'name' => 'Free',
            'product_limit' => 50,       // Sesuai gambar
            'customer_limit' => 20,      // Sesuai gambar
            'daily_pos_limit' => 20,     // Sesuai gambar
            'can_export_report' => false,// Sesuai gambar
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Paket Basic
        DB::table('memberships')->insert([
            'name' => 'Basic',
            'product_limit' => 500,
            'customer_limit' => 500,
            'daily_pos_limit' => 100,
            'can_export_report' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 2. Paket PRO (Contoh Unlimited/Berbayar)
        DB::table('memberships')->insert([
            'name' => 'Premium',
            'product_limit' => 0,    // 0 = Unlimited
            'customer_limit' => 0,   // Unlimited
            'daily_pos_limit' => 0,  // Unlimited
            'can_export_report' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}