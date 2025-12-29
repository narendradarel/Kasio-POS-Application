<?php

namespace App\Livewire;

use Livewire\Component;

class MembershipBadge extends Component
{
    public $membershipName;
    public $badgeColor;

    public function mount()
    {
        $user = auth()->user();
        $this->membershipName = $user->membershipName();
        
        // Set warna badge berdasarkan membership
        $this->badgeColor = match($this->membershipName) {
            'Free' => 'bg-gray-500',
            'Basic' => 'bg-blue-500',
            'Premium' => 'bg-gradient-to-r from-amber-500 to-orange-500',
            default => 'bg-gray-500',
        };
    }

    public function render()
    {
        return view('livewire.membership-badge');
    }
}
