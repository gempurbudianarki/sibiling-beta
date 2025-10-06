<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pengecekan yang lebih ringkas dan aman
        if (Auth::check() && $request->user()->roles()->where('nama_role', 'admin')->exists()) {
            return $next($request);
        }

        // Jika tidak, tendang ke halaman dashboard biasa dengan pesan error
        return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki hak akses Administrator.');
    }
}