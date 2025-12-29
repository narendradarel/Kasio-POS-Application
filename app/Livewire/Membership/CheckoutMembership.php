<?php

namespace App\Livewire\Membership;

use App\Models\Membership;
use App\Models\MembershipPayment;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Component;

class CheckoutMembership extends Component
{
    public array $membership = [];

    public $snapToken;

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
        // Generate unique order ID
        $orderId = 'KASIO-'.strtoupper(Str::random(8)).'-'.time();

        // Get membership ID dari database
        $membership = Membership::where('name', $this->membership['name'])->first();

        if (! $membership) {
            session()->flash('error', 'Membership tidak ditemukan');

            return;
        }

        // Create payment record
        $payment = MembershipPayment::create([
            'user_id' => auth()->id(),
            'membership_id' => $membership->id,
            'order_id' => $orderId,
            'amount' => $this->membership['price'],
            'gateway' => 'midtrans',
            'transaction_status' => 'pending',
        ]);

        // LOAD RELASI sebelum pass ke service
        $payment->load(['membership', 'user']);

        // // DEBUGGING: Cek data sebelum kirim ke Midtrans
        // dd([
        //     'payment' => $payment->toArray(),
        //     'membership' => $payment->membership ? $payment->membership->toArray() : null,
        //     'user' => $payment->user ? $payment->user->toArray() : null,
        // ]);

        try {
            // Generate Snap Token
            $midtrans = new CreateSnapTokenService($payment);
            $this->snapToken = $midtrans->getSnapToken();

            // Dispatch event to open Midtrans popup
            $this->dispatch('openMidtransPopup', snapToken: $this->snapToken);

        } catch (\Exception $e) {
            // Jika gagal generate token, hapus payment record
            $payment->delete();

            session()->flash('error', 'Gagal memproses pembayaran: '.$e->getMessage());

            return;
        }
    }

    public function render(): View
    {
        return view('livewire.membership.checkout-membership');
    }
}
