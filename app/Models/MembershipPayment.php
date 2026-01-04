<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MembershipPayment extends Model
{
    protected $fillable = [
        'user_id',
        'membership_id',
        'order_id',
        'amount',
        'gateway',
        'payment_type',
        'transaction_status',
        'status',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

