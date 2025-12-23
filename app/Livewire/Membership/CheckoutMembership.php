<?php

namespace App\Livewire\Membership;

use Livewire\Component;
use Illuminate\Contracts\View\View;

class CheckoutMembership extends Component
{
    public array $membership = [];

    public function mount(string $membershipName): void
    {
        $data = session('membership_payment');

        if (! $data || $data['name'] !== $membershipName) {
            abort(404);
        }

        $this->membership = $data;
    }

    public function pay()
    {
        // SIMULASI PAYMENT
        session()->put('membership_payment.status', 'paid');

        return redirect()->route('dashboard')
            ->with('success', 'Membership berhasil diaktifkan');
    }

    public function render(): View
    {
        return view('livewire.membership.checkout-membership');
    }
}
