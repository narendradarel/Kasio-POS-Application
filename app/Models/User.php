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
            });
    }

    public function membershipName(): string
    {
        return $this->activeMembership?->membership?->name ?? 'Free';
    }

    /* =========================
    | USER LIMIT
    ========================= */

    public function userLimit(): int
    {
        return (int) optional(
            $this->activeMembership?->membership
        )->user_limit ?? 0;
    }

    public function userCount(): int
    {
        // hitung user aktif selain owner (atau semua, sesuaikan)
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

    /**
     * Total item saat ini
     */
    public function productCount(): int
    {
        return Item::count();
        // kalau per user / per toko → tambahkan where
    }

    /**
     * Limit item dari membership
     * null = unlimited
     */
    public function productLimit(): ?int
    {
        return $this->activeMembership?->membership?->product_limit;
    }

    /**
     * Boleh tambah item atau tidak
     */
    public function canCreateProduct(): bool
    {
        $limit = $this->productLimit();

        if (is_null($limit)) {
            return true; // Premium / unlimited
        }

        return $this->productCount() < $limit;
    }

    /* =========================
     | CUSTOMER LIMIT (SIAP)
     ========================= */

    public function customerLimit(): int
    {
        return (int) optional(
            $this->activeMembership?->membership
        )->customer_limit ?? 0;
    }

    public function customerCount(): int
    {
        return Customer::count();
    }

    public function canCreateCustomer(): bool
    {
        $limit = $this->customerLimit();

        // 0 = tidak boleh
        if ($limit === 0) {
            return false;
        }

        return $this->customerCount() < $limit;
    }

    /* =========================
     | POS DAILY LIMIT (SIAP)
     ========================= */

    public function dailyPosLimit(): ?int
    {
        return $this->activeMembership?->membership?->daily_pos_limit;
    }

    public function todayPosCount(): int
    {
        return Sale::where('user_id', $this->id)
            ->whereDate('created_at', Carbon::today())
            ->count();
    }

    public function canCreateSale(): bool
    {
        return $this->todayPosCount() < $this->dailyPosLimit();
    }

    /* =========================
     | EXPORT REPORT
     ========================= */

    public function canExportReport(): bool
    {
        return (bool) ($this->activeMembership?->membership?->can_export_report);
    }
}
