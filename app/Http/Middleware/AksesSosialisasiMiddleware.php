<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AksesSosialisasiMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Pastikan user sudah login terlebih dahulu
        if (!auth()->check()) {
            return redirect('/login');
        }

        // 2. Cek apakah user berhak mengakses sosialisasi
        if (auth()->user()->hasAksesSosialisasi()) {
            return $next($request);
        }

        // 3. Jika tidak berhak, tolak dan kembalikan ke dashboard
        return redirect()->route('dashboard')->with('error', 'Akses ditolak! Anda tidak memiliki izin untuk membuka halaman sosialisasi.');
    }
}

