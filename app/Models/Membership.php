<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'limits',
        'product_limit',
        'user_limit',
        'customer_limit',
        'daily_pos_limit',
        'can_export_report',
    ];

       protected $casts = [
        'limits' => 'array',
    ];
}
