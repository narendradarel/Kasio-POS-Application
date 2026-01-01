<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /** @use HasFactory<\Database\Factories\CustomerFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email', 
        'phone',
        'user_id', // ✅ TAMBAH INI
    ];

    protected static function booted()
    {
        // ✅ OTOMATIS SET user_id saat create
        static::creating(function ($customer) {
            if (auth()->check()) {
                $customer->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class); // ✅ TAMBAH INI
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
