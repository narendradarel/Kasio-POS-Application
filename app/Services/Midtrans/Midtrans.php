<?php

namespace App\Services\Midtrans;

class Midtrans
{
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;

    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');

        // DEBUG: Cek apakah config terbaca
        \Log::info('Midtrans Config:', [
            'server_key' => $this->serverKey,
            'is_production' => $this->isProduction,
        ]);

        $this->_configureMidtrans();
    }

    protected function _configureMidtrans()
    {
        \Midtrans\Config::$serverKey = $this->serverKey;
        \Midtrans\Config::$isProduction = $this->isProduction;
        \Midtrans\Config::$isSanitized = $this->isSanitized;
        \Midtrans\Config::$is3ds = $this->is3ds;
        
        // TEMPORARY FIX - Hanya untuk development di localhost
        if (!$this->isProduction) {
            \Midtrans\Config::$curlOptions = [
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
            ];
        }
    }
}