<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use App\Models\Membership;
use App\Models\UserMembership;

class AssignFreeMembership
{
    public function handle(Registered $event): void
    {
        $user = $event->user;

        // Ambil membership Free
        $freeMembership = Membership::where('name', 'Free')->first();

        if (! $freeMembership) {
            return; // safety
        }

        // Cegah double assign
        if ($user->activeMembership) {
            return;
        }

        UserMembership::create([
            'user_id' => $user->id,
            'membership_id' => $freeMembership->id,
            'starts_at' => now(),
            'status' => 'active',
        ]);
    }
}
