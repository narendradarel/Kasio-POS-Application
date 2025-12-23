<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Membership;

class UserMembershipSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil User Admin (User pertama yang dibuat UserSeeder)
        $user = User::first();

        // 2. Ambil Paket 'Free' (Yang dibuat MembershipSeeder)
        $freePlan = Membership::where('name', 'Free')->first();

        // 3. Validasi: Pastikan User dan Paket ada sebelum insert
        if ($user && $freePlan) {
            DB::table('user_memberships')->insert([
                'user_id' => $user->id,
                'membership_id' => $freePlan->id,
                'status' => 'active',
                'started_at' => now(),
                'ends_at' => null, // null artinya berlaku selamanya (tidak ada expired)
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}