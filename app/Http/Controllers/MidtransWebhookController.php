<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\UserMembership;
use App\Services\Midtrans\CallbackService;
use Illuminate\Http\Request;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        \Log::info('🚀 MIDTRANS WEBHOOK RECEIVED', $request->all());

        try {
            // INSTANTIASI CallbackService untuk verifikasi
            $callbackService = new CallbackService();
            
            // ✅ VERIFIKASI SIGNATURE (KRITIS!)
            if (!$callbackService->isSignatureKeyVerified()) {
                \Log::error('❌ INVALID SIGNATURE KEY');
                return response()->json(['status' => 'failed'], 403);
            }

            $notification = $callbackService->getNotification();
            $payment = $callbackService->getOrder();

            if (!$payment) {
                \Log::error('❌ Payment not found: ' . $notification->order_id);
                return response()->json(['status' => 'not_found'], 404);
            }

            \Log::info('✅ Payment found', ['order_id' => $payment->order_id]);

            // Update payment data
            $payment->update([
                'transaction_status' => $notification->transaction_status,
                'payment_type' => $notification->payment_type ?? null,
                'payload' => $request->all(),
            ]);

            // 🟢 SUCCESS PAYMENT - UPDATE MEMBERSHIP
            if ($callbackService->isSuccess()) {
                \Log::info('🟢 PAYMENT SUCCESS - UPDATING MEMBERSHIP');
                
                // Update payment status
                $payment->update(['status' => 'paid']);
                
                // CRITICAL: Update membership
                UserMembership::updateOrCreate(
                    ['user_id' => $payment->user_id],
                    [
                        'membership_id' => $payment->membership_id,
                        'started_at' => now(),
                        'ends_at' => now()->addYear(),
                        'status' => 'active',
                    ]
                );
                
                \Log::info('✅ Membership activated for user: ' . $payment->user_id);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            \Log::error('💥 WEBHOOK ERROR: ' . $e->getMessage());
            return response()->json(['status' => 'error'], 500);
        }
    }
}
