<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsDosenKonseling
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Menggunakan logika pengecekan peran yang sudah terbukti benar
        if (Auth::check() && Auth::user()->roles()->where('nama_role', 'dosen_konseling')->exists()) {
            return $next($request);
        }

        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses Dosen Konseling.');
    }
}