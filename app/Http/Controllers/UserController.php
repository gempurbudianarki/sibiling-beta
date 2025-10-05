<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role; // <-- TAMBAHKAN INI untuk memanggil model Role
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Menampilkan halaman daftar user.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(15);
        return view('admin.users.index', ['users' => $users]);
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        // Ambil semua role dari database
        $roles = Role::all();

        // Kirim data roles ke view
        return view('admin.users.create', ['roles' => $roles]);
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        // Akan kita implementasikan di langkah berikutnya
    }

    /**
     * Menampilkan detail satu user.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        // Akan kita implementasikan nanti
    }

    /**
     * Update data user di database.
     */
    public function update(Request $request, User $user)
    {
        // Akan kita implementasikan nanti
    }

    /**
     * Hapus user dari database.
     */
    public function destroy(User $user)
    {
        // Akan kita implementasikan nanti
    }
}