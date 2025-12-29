<?php

namespace App\Models;

use App\Models\User as UserModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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
     | MEMBERSHIP RELATION
     ========================= */

    public function activeMembership()
    {
        return $this->hasOne(UserMembership::class)
            ->where('status', 'active')
            ->where(function ($q) {
                $q->whereNull('ends_at')
                    ->orWhere('ends_at', '>=', now());
            })
            ->latest(); // Tambahkan ini untuk ambil data terbaru
    }

    // TAMBAHKAN METHOD INI (yang dipanggil di blade)
    public function getEffectiveMembershipAttribute()
    {
        $activeSub = $this->activeMembership()->with('membership')->first();

        if ($activeSub && $activeSub->membership) {
            return $activeSub->membership;
        }

        // Fallback ke Free
        return Membership::where('name', 'Free')->first();
    }

    public function membershipName(): string
    {
        return $this->effective_membership?->name ?? 'Free';
    }

    /* =========================
    | USER LIMIT
    ========================= */

    public function userLimit(): int
    {
        return (int) ($this->effective_membership?->user_limit ?? 1);
    }

    public function userCount(): int
    {
        return UserModel::count();
    }

    public function canCreateUser(): bool
    {
        $limit = $this->userLimit();

        if ($limit === 0) {
            return false;
        }

        return $this->userCount() < $limit;
    }

    /* =========================
     | PRODUCT / ITEM LIMIT
     ========================= */

    public function productCount(): int
    {
        return Item::count();
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
        return Customer::count();
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
            return true; // unlimited
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
