<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $userRole = auth()->user()->role;

        // 2. KUNCI BARU: Hanya izinkan masuk JIKA role user benar-benar cocok dengan role yang diminta di web.php
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak cocok (misal Admin mau masuk ke halaman Chef), tendang ke dashboard!
        return redirect()->route('dashboard')->with('error', '🛑 Akses ditolak! Anda tidak memiliki izin ke halaman ini.');
    }
}