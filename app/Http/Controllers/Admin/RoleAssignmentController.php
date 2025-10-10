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

        $users = User::query()
            ->whereHas('dosen') 
            ->when($query, function ($q, $search) {
                return $q->where('email', 'like', "%{$search}%")
                         ->orWhereHas('dosen', function ($q_dosen) use ($search) {
                             // ================== PERBAIKAN DI SINI ==================
                             $q_dosen->where('nm_dos', 'like', "%{$search}%")
                                     ->orWhere('nidn', 'like', "%{$search}%");
                         });
            })
            ->with('roles', 'dosen')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.roles.index', compact('users'));
    }

    public function edit(User $user)
    {
        $user->load('dosen'); 
        $roles = Role::where('name', 'like', 'dosen_%')->get();
        
        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'sometimes|array'
        ]);

        $dosenRoles = Role::where('name', 'like', 'dosen_%')->pluck('name')->toArray();
        
        $user->removeRole(...$dosenRoles);

        if ($request->has('roles')) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Roles untuk ' . ($user->dosen->nm_dos ?? $user->name) . ' berhasil diperbarui.');
    }
}