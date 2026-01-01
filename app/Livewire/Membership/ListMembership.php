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
                'key' => 'free',
                'name' => 'Free',
                'price' => 0,
                'features' => [
                    '50 Produk',
                    '20 Customer',
                    'POS harian max 20',
                    'Tidak bisa cetak laporan',
                ],
            ],
            [
                'key' => 'basic',
                'name' => 'Basic',
                'price' => 50000,
                'features' => [
                    '500 Produk',
                    '500 Customer',
                    'POS harian max 100',
                    'Bisa cetak laporan',
                ],
            ],
            [
                'key' => 'premium',
                'name' => 'Premium',
                'price' => 100000,
                'features' => [
                    'Unlimited Produk',
                    'Unlimited Customer',
                    'Unlimited POS',
                    'Bisa cetak laporan',
                ],
            ],
        ];
    }

    public function selectMembership(string $name)
    {
        $membership = collect($this->memberships)
            ->firstWhere('name', $name);

        if (! $membership) {
            abort(404);
        }

        session([
            'membership_payment' => [
                'name'   => $membership['name'],
                'price'  => $membership['price'],
                'status' => 'pending',
            ],
        ]);

        return redirect()->route(
            'membership.checkout',
            ['membershipName' => $membership['name']]
        );
    }

    public function render(): View
    {
        return view('livewire.membership.list-membership', [
            'memberships' => $this->memberships,
        ]);
    }
}
