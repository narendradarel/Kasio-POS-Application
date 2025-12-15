<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MembershipPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'order_id',
        'amount',
        'gateway',
        'payment_type',
        'transaction_status',
        'payload',
    ];
}
