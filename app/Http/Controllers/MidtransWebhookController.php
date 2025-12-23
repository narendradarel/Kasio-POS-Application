<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\UserMembership;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $orderId = $request->order_id;
        $status  = $request->transaction_status;

        $payment = MembershipPayment::where('order_id', $orderId)->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        // update payment status
        $payment->update([
            'transaction_status' => $status,
            'payment_type' => $request->payment_type ?? null,
            'payload' => $request->all(),
        ]);

        // JIKA SUKSES
        if (in_array($status, ['settlement', 'capture'])) {

            UserMembership::updateOrCreate(
                ['user_id' => $payment->user_id],
                [
                    'membership_id' => $payment->membership_id,
                    'starts_at' => now(),
                    'ends_at' => now()->addYear(),
                    'status' => 'active',
                ]
            );
        }

        // JIKA EXPIRED / CANCEL
        if (in_array($status, ['expire', 'cancel'])) {
            UserMembership::where('user_id', $payment->user_id)
                ->update(['status' => 'expired']);
        }

        return response()->json(['message' => 'OK']);
    }
}
