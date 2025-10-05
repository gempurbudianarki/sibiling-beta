<?php

namespace App\Http\Middleware;

use App\Models\User;
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
        $user = Auth::user();

        if (Auth::check() && $user instanceof User) {
            // GANTI 'name' MENJADI 'nama_role' DI SINI
            if ($user->roles()->where('nama_role', 'admin')->exists()) {
                return $next($request);
            }
        }

        // Jika tidak, tendang ke halaman dashboard biasa dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki hak akses ke halaman ini.');
    }
}