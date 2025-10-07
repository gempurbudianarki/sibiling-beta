<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .sidebar-gradient{background:linear-gradient(180deg,#1a3b1fff 0%,#054e22ff 60%,#0C342C 100%)}.menu-hover{transition:all .3s ease-in-out}.menu-hover:hover{background:rgba(255,255,255,.1);box-shadow:0 4px 12px rgba(0,0,0,.2);transform:translateX(5px)}.menu-active{background:rgba(255,255,255,.15);font-weight:600}.logo-circle{background:#fff;padding:8px;border-radius:50%;box-shadow:0 4px 12px rgba(0,0,0,.3)}.btn-logout{background:linear-gradient(90deg,#FF5F6D,#FF0000);transition:all .3s ease-in-out}.btn-logout:hover{background:linear-gradient(90deg,#FF0000,#B30000);transform:scale(1.05)}
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
<div x-data="{ open: true }" class="flex h-screen bg-gray-100">
    <aside class="relative transition-all duration-500 ease-in-out" :class="open ? 'w-64' : 'w-20'">
        <div class="fixed inset-y-0 left-0 z-30 h-screen sidebar-gradient text-white transition-all duration-500" :class="open ? 'w-64' : 'w-20'">
            <div class="flex items-center justify-center p-4 border-b border-green-800">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" class="h-10 w-10">
                </div>
                <span x-show="open" class="ml-3 text-xl font-bold tracking-wide text-white transition-opacity duration-300">SIBILING</span>
            </div>
            <nav class="mt-6 space-y-2 px-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path></svg>
                    <span x-show="open" class="ml-3">Dashboard</span>
                </a>

                {{-- ==== MENU UNTUK ADMIN ==== --}}
                @if(Auth::user()->roles()->where('nama_role', 'admin')->exists())
                    {{-- Menggunakan nama rute asli --}}
                    <a href="{{ route('dosen.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen.index') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Dosen</span>
                    </a>
                    <a href="{{ route('mahasiswa.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('mahasiswa.index') ? 'menu-active' : '' }}">
                       <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.roles.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61-.25-1.17-.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19-.15-.24-.42-.12-.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l-.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path></svg>
                        <span x-show="open" class="ml-3">Pengguna & Roles</span>
                    </a>
                @endif
                
                {{-- ==== MENU UNTUK DOSEN PEMBIMBING ==== --}}
                @if(Auth::user()->roles()->where('nama_role', 'dosen_pembimbing')->exists())
                    <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-pembimbing.mahasiswa') ? 'menu-active' : '' }}">
                       <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Mahasiswa Bimbingan</span>
                    </a>
                    <a href="{{ route('dosen-pembimbing.rekomendasi') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-pembimbing.rekomendasi') ? 'menu-active' : '' }}">
                       <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"></path></svg>
                        <span x-show="open" class="ml-3">Rekomendasi Konseling</span>
                    </a>
                @endif

                {{-- ==== MENU UNTUK DOSEN KONSELING ==== --}}
                @if(Auth::user()->roles()->where('nama_role', 'dosen_konseling')->exists())
                    <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-konseling.pengajuan.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"></path></svg>
                        <span x-show="open" class="ml-3">Verifikasi Pengajuan</span>
                    </a>
                     <a href="{{ route('dosen-konseling.kasus.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-konseling.kasus.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1s-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm2 14H7v-2h7v2zm3-4H7v-2h10v2zm0-4H7V7h10v2z"></path></svg>
                        <span x-show="open" class="ml-3">Riwayat Kasus</span>
                    </a>
                @endif

            </nav>
            <div class="absolute bottom-6 w-full px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm font-medium text-left rounded-lg btn-logout text-white">
                        <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3 4a1 1 0 011-1h6a1 1 0 010 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm11.707 1.293a1 1 0 010 1.414L13.414 9H9a1 1 0 100 2h4.414l1.293 2.293a1 1 0 001.414-1.414L15.414 10l2-2.293a1 1 0 00-1.414-1.414L15 8.586l-1.293-1.293a1 1 0 00-1.414 0z" clip-rule="evenodd"/></svg>
                        <span x-show="open">Logout</span>
                    </button>
                </form>
            </div>
            <button @click="open = !open" class="absolute -right-3 top-6 bg-white text-green-700 rounded-full p-1 shadow-md hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="open"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" x-show="!open"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </button>
        </div>
    </aside>
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm" :class="open ? 'ml-64' : 'ml-20'" style="transition: margin-left 0.5s ease-in-out;">
            <h2 class="font-semibold text-xl text-gray-800">{{ $header ?? 'Dashboard' }}</h2>
            <div>{{ Auth::user()->name ?? 'User' }}</div>
        </header>
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50" :class="open ? 'ml-64' : 'ml-20'" style="transition: margin-left 0.5s ease-in-out;">
            <div class="container mx-auto px-6 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
</body>
</html>