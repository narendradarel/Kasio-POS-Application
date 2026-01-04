<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Visit;
use Illuminate\Support\Facades\Auth;

class TrackVisitors
{
    public function handle(Request $request, Closure $next)
    {
        // Jangan catat jika membuka halaman aset/api/ajax biar database tidak meledak
        if (!$request->is('livewire/*', 'api/*', 'build/*')) {
            Visit::create([
                'user_id' => Auth::id(), // null jika guest
                'ip_address' => $request->ip(),
                'url' => $request->path(),
            ]);
        }

        return $next($request);
    }
}