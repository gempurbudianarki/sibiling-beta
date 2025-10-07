<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleAssignmentController extends Controller
{
    public function index()
    {
        $users = User::whereHas('dosen')
                     ->with('dosen', 'roles')
                     ->latest()
                     ->paginate(15);

        return view('admin.roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('dosen'); 
        $roles = Role::all();
        
        // --- INI PERBAIKANNYA ---
        // Ambil ID dari semua peran yang dimiliki user ini dan ubah menjadi array
        $userRoles = $user->roles->pluck('id_role')->toArray();

        // Kirim ketiga variabel ini ke view
        return view('admin.roles.edit', compact('user', 'roles', 'userRoles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id_role', 
        ]);

        $roleIds = $request->input('roles', []);
        
        $adminRole = Role::where('nama_role', 'admin')->first();

        if ($adminRole && $user->roles->pluck('id_role')->contains($adminRole->id_role)) {
            if (!in_array($adminRole->id_role, $roleIds)) {
                $roleIds[] = $adminRole->id_role; 
            }
        }
        
        $user->roles()->sync($roleIds);

        return redirect()->route('admin.roles.index')
                         ->with('status', 'Peran untuk ' . $user->name . ' berhasil diperbarui.');
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $users = User::whereHas('dosen', function ($q) use ($query) {
                        $q->where('nm_dos', 'like', "%{$query}%")
                          ->orWhere('nidn', 'like', "%{$query}%");
                     })
                     ->with('dosen', 'roles')
                     ->latest()
                     ->paginate(15);
        
        return view('admin.roles.index', compact('users'));
    }
}