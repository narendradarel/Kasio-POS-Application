<?php

namespace App\Services\Midtrans;

use App\Models\MembershipPayment;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order)
    {
        parent::__construct();
        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => (string) $this->order->order_id,
                'gross_amount' => (int) $this->order->amount,
            ],
            'customer_details' => [
                'first_name' => (string) $this->order->user->name,
                'email' => (string) $this->order->user->email,
            ],
            'item_details' => [
                [
                    'id' => (string) $this->order->membership->id,
                    'price' => (int) $this->order->amount,
                    'quantity' => 1,
                    'name' => (string) $this->order->membership->name,
                ]
            ],
        ];

        try {
            \Log::info('=== Midtrans Request START ===');
            \Log::info('Params:', $params);
            
            // --- FIX START: Tambahkan ini untuk memperbaiki error PHP 8.x di Azure ---
            \Midtrans\Config::$curlOptions = [
                CURLOPT_HTTPHEADER => [] 
            ];
            // --- FIX END ---

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            
            \Log::info('Snap Token Success:', ['token' => $snapToken]);
            \Log::info('=== Midtrans Request END ===');
            
            return $snapToken;
            
        } catch (\Exception $e) {
            \Log::error('=== Midtrans Error ===');
            \Log::error('Message: ' . $e->getMessage());
            \Log::error('Code: ' . $e->getCode());
            \Log::error('File: ' . $e->getFile());
            \Log::error('Line: ' . $e->getLine());
            \Log::error('Trace: ' . $e->getTraceAsString());
            
            throw new \Exception('Midtrans Error: ' . $e->getMessage() . ' (Code: ' . $e->getCode() . ')');
        }
    }
}