<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\UserMembership;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // LOG semua data yang masuk
        \Log::info('=== MIDTRANS WEBHOOK RECEIVED ===');
        \Log::info('Request Data:', $request->all());

        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        \Log::info('Order ID: ' . $orderId);
        \Log::info('Status: ' . $status);

        $payment = MembershipPayment::where('order_id', $orderId)->first();

        if (! $payment) {
            \Log::error('Payment not found for order_id: ' . $orderId);
            return response()->json(['message' => 'Payment not found'], 404);
        }

        \Log::info('Payment found:', $payment->toArray());

        // update payment status
        $payment->update([
            'transaction_status' => $status,
            'payment_type' => $request->payment_type ?? null,
            'payload' => $request->all(),
        ]);

        \Log::info('Payment updated');

        // JIKA SUKSES
        if (in_array($status, ['settlement', 'capture'])) {
            \Log::info('Payment SUCCESS - Creating/Updating UserMembership');

            $userMembership = UserMembership::updateOrCreate(
                ['user_id' => $payment->user_id],
                [
                    'membership_id' => $payment->membership_id,
                    'started_at' => now(), // GANTI JADI started_at
                    'ends_at' => now()->addYear(),
                    'status' => 'active',
                ]
            );

            \Log::info('UserMembership created/updated:', $userMembership->toArray());
        }

        // JIKA EXPIRED / CANCEL
        if (in_array($status, ['expire', 'cancel'])) {
            \Log::info('Payment EXPIRED/CANCELLED');
            
            UserMembership::where('user_id', $payment->user_id)
                ->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }
}
