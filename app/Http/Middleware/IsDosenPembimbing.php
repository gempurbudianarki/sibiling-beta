<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class IsDosenPembimbing
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Cek apakah user sudah login dan punya peran 'dosen_pembimbing'
        if ($user && $user instanceof User && $user->roles()->where('nama_role', 'dosen_pembimbing')->exists()) {
            // Jika iya, izinkan masuk
            return $next($request);
        }

        // Jika tidak, tendang ke dashboard biasa dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses sebagai Dosen Pembimbing.');
    }
}