<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password',
        'google_id', 'avatar', 'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /* =========================
     | AUTO-ASSIGN MEMBERSHIP
     ========================= */

    protected static function booted(): void
    {
        // Default role = admin jika kosong
        static::creating(function (User $user) {
            if (empty($user->role)) {
                $user->role = 'admin';
            }
        });

        // SET FREE MEMBERSHIP UNTUK USER BARU (boleh admin & cashier)
        static::created(function (User $user) {
            $freePlan = Membership::where('name', 'Free')->first();

            if ($freePlan) {
                UserMembership::create([
                    'user_id'       => $user->id,
                    'membership_id' => $freePlan->id,
                    'status'        => 'active',
                    'started_at'    => now(),
                    'ends_at'       => null,
                ]);
            }
        });
    }

    /* =========================
     | BASIC USER HELPERS
     ========================= */

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->take(2)
            ->map(fn ($word) => Str::substr($word, 0, 1))
            ->implode('');
    }

    /* =========================
     | ROLE HELPERS
     ========================= */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isCashier(): bool
    {
        return $this->role === 'cashier';
    }

    /* =========================
     | MEMBERSHIP RELATIONS
     ========================= */

    // Semua subscription user (riwayat)
    public function memberships()
    {
        return $this->hasMany(UserMembership::class);
    }

    // Active subscription user ini (RELATIONSHIP BIASA)
    public function activeMembership()
    {
        return $this->hasOne(UserMembership::class)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')
                  ->orWhere('ends_at', '>=', now());
            })
            ->latest();
    }

    // Membership plan (Membership model) yang sedang aktif
    public function getEffectiveMembershipAttribute()
    {
        $activeSub = $this->activeMembership()
            ->with('membership')
            ->first();

        if ($activeSub && $activeSub->membership) {
            return $activeSub->membership;
        }

        // Fallback ke Free (jaga‑jaga kalau relasi kosong)
        return Membership::where('name', 'Free')->first();
    }

    public function membershipName(): string
    {
        return $this->effective_membership?->name ?? 'Free';
    }

    /* =========================
     | PRODUCT / ITEM LIMIT
     ========================= */

    public function productCount(): int
    {
        return Item::where('user_id', $this->id)->count();
    }

    public function productLimit(): ?int
    {
        return $this->effective_membership?->product_limit;
    }

    public function canCreateProduct(): bool
    {
        $limit = $this->productLimit();

        if (is_null($limit)) {
            return true;
        }

        return $this->productCount() < $limit;
    }

    /* =========================
     | CUSTOMER LIMIT
     ========================= */

    public function customerLimit(): ?int
    {
        return $this->effective_membership?->customer_limit;
    }

    public function customerCount(): int
    {
        return Customer::where('user_id', $this->id)->count();
    }

    public function canCreateCustomer(): bool
    {
        $limit = $this->customerLimit();

        if (is_null($limit)) {
            return true;
        }

        return $this->customerCount() < $limit;
    }

    /* =========================
     | POS DAILY LIMIT
     ========================= */

    public function dailyPosLimit(): ?int
    {
        return $this->effective_membership?->daily_pos_limit;
    }

    public function todayPosCount(): int
    {
        return Sale::where('user_id', $this->id)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    public function canCreateSale(): bool
    {
        $limit = $this->dailyPosLimit();

        if (is_null($limit)) {
            return true;
        }

        return $this->todayPosCount() < $limit;
    }

    /* =========================
     | EXPORT REPORT
     ========================= */

    public function canExportReport(): bool
    {
        return (bool) ($this->effective_membership?->can_export_report ?? false);
    }
}
