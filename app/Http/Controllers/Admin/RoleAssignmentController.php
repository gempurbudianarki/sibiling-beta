<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $dosens = Dosen::with('user.roles')
            ->orderBy('nm_dos', 'asc') // Urutkan berdasarkan nama
            ->paginate(15);

        return view('admin.roles.index', ['dosens' => $dosens]);
    }

    // ==== METHOD BARU UNTUK MENANGANI LIVE SEARCH ====
    public function search(Request $request)
    {
        $searchQuery = $request->query('search');

        $dosens = Dosen::with('user.roles')
            ->where('nm_dos', 'like', '%' . $searchQuery . '%')
            ->orderBy('nm_dos', 'asc')
            ->get();

        // Kembalikan hanya view parsial yang berisi baris-baris tabel
        return view('admin.roles._dosen_table_rows', ['dosens' => $dosens]);
    }

    public function edit(Dosen $dosen)
    {
        $user = $dosen->user;
        if (!$user) {
            $user = User::create([
                'name' => $dosen->nm_dos,
                'email' => $dosen->email_dos,
                'username' => explode('@', $dosen->email_dos)[0] . ($dosen->nidn ?? ''),
                'password' => Hash::make('password123'),
            ]);
            $dosen->load('user');
        }
        $roles = Role::all();
        return view('admin.roles.edit', [
            'dosen' => $dosen,
            'roles' => $roles
        ]);
    }

    public function update(Request $request, Dosen $dosen)
    {
        $user = $dosen->user;
        $user->roles()->sync($request->roles);
        return redirect()->route('admin.roles.index')->with('success', 'Peran untuk ' . $dosen->nm_dos . ' berhasil diperbarui.');
    }
}