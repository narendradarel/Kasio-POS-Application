<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class ListMembership extends Component
{
    public array $memberships = [];

    public function mount(): void
    {
        $this->memberships = [
            [
                'name' => 'Free',
                'price' => 0,
                'features' => [
                    '50 Produk',
                    '1 User',
                    '20 Customer',
                    'POS harian max 20',
                    'Tidak bisa cetak laporan',
                ],
            ],
            [
                'name' => 'Basic',
                'price' => 50000,
                'features' => [
                    '500 Produk',
                    '10 User',
                    '500 Customer',
                    'POS harian max 100',
                    'Bisa cetak laporan',
                ],
            ],
            [
                'name' => 'Premium',
                'price' => 100000,
                'features' => [
                    'Unlimited Produk',
                    'Unlimited User',
                    'Unlimited Customer',
                    'Unlimited POS',
                    'Bisa cetak laporan',
                ],
            ],
        ];
    }

    public function render(): View
    {
        return view('livewire.membership.list-membership');
    }
}
