<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Console\Command;

class CheckMembershipConsistency extends Command
{
    protected $signature = 'membership:check';
    protected $description = 'Check membership data consistency';

    public function handle()
    {
        $this->info('Checking membership consistency...');

        // 1. Cek duplikat
        $duplicates = UserMembership::where('status', 'active')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        if ($duplicates->count() > 0) {
            $this->warn("Found {$duplicates->count()} users with duplicate active memberships");
        } else {
            $this->info('✓ No duplicate active memberships');
        }

        // 2. Cek user tanpa membership
        $usersWithoutMembership = User::whereDoesntHave('activeMembership')->count();
        
        if ($usersWithoutMembership > 0) {
            $this->warn("Found {$usersWithoutMembership} users without active membership");
        } else {
            $this->info('✓ All users have active membership');
        }

        // 3. Cek expired membership yang masih active
        $expiredButActive = UserMembership::where('status', 'active')
            ->whereNotNull('ends_at')
            ->where('ends_at', '<', now())
            ->count();

        if ($expiredButActive > 0) {
            $this->warn("Found {$expiredButActive} expired memberships still marked as active");
        } else {
            $this->info('✓ No expired memberships marked as active');
        }

        $this->info("\nDone!");
    }
}
