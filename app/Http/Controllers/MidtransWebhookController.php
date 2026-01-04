<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPayment;
use App\Models\UserMembership;
use Illuminate\Support\Facades\Log;

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('MIDTRANS WEBHOOK RECEIVED', $request->all());

        try {
            // RAW PAYLOAD - NO CallbackService
            $notif = $request->all();
            $orderId = $notif['order_id'] ?? null;
            $status = $notif['transaction_status'] ?? null;
            
            Log::info('Parsed webhook', [
                'order_id' => $orderId,
                'status' => $status
            ]);
            
            if (!$orderId || !$status) {
                Log::error('Missing order_id/status');
                return response()->json(['status' => 'missing_data'], 200);
            }

            // Cari payment
            $payment = MembershipPayment::where('order_id', $orderId)->first();
            if (!$payment) {
                Log::error('Payment not found', ['order_id' => $orderId]);
                return response()->json(['status' => 'payment_not_found'], 200);
            }

            // Update payment
            $payment->update([
                'transaction_status' => $status,
                'payment_type' => $notif['payment_type'] ?? null,
                'payload' => $notif,
            ]);

            // AKTIVASI MEMBERSHIP
            if (in_array($status, ['settlement', 'capture'])) {
                $payment->update(['status' => 'paid']);
                
                UserMembership::updateOrCreate(
                    ['user_id' => $payment->user_id],
                    [
                        'membership_id' => $payment->membership_id,
                        'order_id' => $orderId,
                        'started_at' => now(),
                        'ends_at' => now()->addYear(),
                        'status' => 'active',
                    ]
                );
                
                Log::info('✅ Membership ACTIVATED', [
                    'user_id' => $payment->user_id,
                    'order_id' => $orderId
                ]);
            }

            return response()->json(['status' => 'success'], 200);

        } catch (\Exception $e) {
            Log::error('WEBHOOK ERROR', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['status' => 'error'], 200);  // Midtrans tetap 200
        }
    }
}
