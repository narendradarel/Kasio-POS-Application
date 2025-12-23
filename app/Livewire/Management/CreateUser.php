<?php

namespace App\Livewire\Management;

use App\Models\User;
use Livewire\Component;
use Filament\Notifications\Notification;
use Illuminate\Validation\Rule;

class CreateUser extends Component
{
    // Properti Form Standar
    public $name = '';
    public $email = '';
    public $role = 'cashier'; // Default cashier
    public $password = '';

    public function mount()
    {
        $user = auth()->user();

        // 1. CEK LIMIT SAAT LOAD (UX)
        if (! $user->canCreateUser()) {
            Notification::make()
                ->title('Akses Ditolak')
                ->body("Limit User paket Membership Anda sudah habis.")
                ->danger()
                ->send();

            $this->redirect(route('users.index'), navigate: true);
        }
    }

    public function save()
    {
        // 2. CEK LIMIT SAAT SAVE (SECURITY)
        if (! auth()->user()->canCreateUser()) {
            Notification::make()->title('Gagal')->body('Limit Habis!')->danger()->send();
            return;
        }

        // Validasi Manual Livewire
        $validated = $this->validate([
            'name'     => 'required|min:3',
            'email'    => 'required|email|unique:users,email',
            'role'     => 'required|in:admin,cashier,other',
            'password' => 'required|min:6',
        ]);

        // Simpan User
        User::create([
            'name'     => $this->name,
            'email'    => $this->email,
            'role'     => $this->role,
            'password' => $this->password, // Model User biasanya sudah auto-hash, atau pakai bcrypt($this->password)
        ]);

        Notification::make()
            ->title('Berhasil')
            ->body('User baru berhasil dibuat.')
            ->success()
            ->send();

        $this->redirect(route('users.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.management.create-user');
    }
}