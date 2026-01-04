<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    public function mount()
    {
        // LOGIC PENGECEKAN DI SINI
        // Jika user belum login ATAU role-nya bukan admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            // Tendang ke halaman dashboard biasa atau tampilkan error 403
            abort(403, 'Anda bukan Admin!'); 
            // atau: return redirect()->route('dashboard'); 
        }
    }

    public function render()
    {
        // 1. LOGIC CHART (Grafik Pengunjung 7 Hari Terakhir)
        $visits = Visit::select(DB::raw("DATE(created_at) as date"), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();

        // Format data untuk Chart.js / ApexCharts
        $chartDates = $visits->pluck('date')->toArray();
        $chartCounts = $visits->pluck('count')->toArray();

        // 2. LOGIC TABEL USER
        // Kita eager load relasi membership agar query tidak berat (N+1 Problem)
        // Asumsi relasi di model User adalah 'activeMembership.membership'
        $users = User::with(['activeMembership.membership'])
                ->where('role', '!=', 'admin') // Sembunyikan admin dari list
                ->latest()
                ->paginate(10);

        return view('livewire.admin.dashboard', [
            'users' => $users,
            'chartDates' => $chartDates,
            'chartCounts' => $chartCounts
        ]);
    }
}