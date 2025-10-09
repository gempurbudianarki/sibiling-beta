<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;

class RoleAssignmentController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Query diubah untuk HANYA mengambil user yang punya profil dosen
        $users = User::query()
            ->whereHas('dosen') // HANYA USER DENGAN PROFIL DOSEN
            ->when($query, function ($q, $search) {
                return $q->where('email', 'like', "%{$search}%")
                         ->orWhereHas('dosen', function ($q_dosen) use ($search) {
                             $q_dosen->where('nm_dosen', 'like', "%{$search}%")
                                     ->orWhere('nidn', 'like', "%{$search}%");
                         });
            })
            ->with('roles', 'dosen') // Cukup eager load dosen dan roles
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('dosen'); 
        $roles = Role::where('name', 'like', 'dosen_%')->get(); // Hanya ambil role untuk dosen
        
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'sometimes|array' // 'sometimes' agar bisa mengosongkan role
        ]);

        // Ambil semua role yang ada, kecuali 'admin' dan 'mahasiswa'
        $dosenRoles = Role::where('name', 'like', 'dosen_%')->pluck('name')->toArray();
        
        // Hapus dulu semua role dosen yang mungkin sudah ada
        $user->removeRole(...$dosenRoles);

        // Berikan role baru dari request, jika ada
        if ($request->has('roles')) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Roles untuk ' . ($user->dosen->nm_dosen ?? $user->name) . ' berhasil diperbarui.');
    }
}