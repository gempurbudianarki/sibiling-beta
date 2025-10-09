<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Redirect the user to the appropriate dashboard based on their role.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Fallback in case user is not authenticated for some reason.
        if (!$user) {
            return redirect('/login');
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('dosen_konseling')) {
            return redirect()->route('dosen-konseling.dashboard');
        }

        if ($user->hasRole('dosen_pembimbing')) {
            return redirect()->route('dosen-pembimbing.dashboard');
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('mahasiswa.dashboard');
        }

        // Fallback for users with no specific role or if something goes wrong
        return redirect('/profile');
    }
}