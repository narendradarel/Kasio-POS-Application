<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMembership extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'status',
        'started_at', // <--- Pastikan ini 'started_at', BUKAN 'starts_at'
        'ends_at',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke membership
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'active'
            && ($this->ends_at === null || now()->lte($this->ends_at));
    }
}
