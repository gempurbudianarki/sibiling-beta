<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div x-data="{ open: true }" class="flex min-h-screen bg-gray-100">
        <aside :class="{ 'w-64': open, 'w-20': !open }" class="flex-shrink-0 bg-gray-800 text-white transition-all duration-300">
            <div class="flex items-center justify-between p-4 h-16">
                <span x-show="open" class="text-xl font-semibold">SIBILING</span>
                <button @click="open = !open" class="p-2 rounded-md focus:outline-none focus:ring">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            <nav class="mt-4 px-2 space-y-2">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path></svg>
                    <span x-show="open" class="ml-3">Dashboard</span>
                </a>

                {{-- ==== MENU UNTUK ADMIN ==== --}}
                @if(Auth::user()->hasRole('admin'))
                    {{-- Menggunakan nama rute yang benar dengan prefix 'admin.' --}}
                    <a href="{{ route('admin.dosen.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.dosen.index') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Dosen</span>
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.mahasiswa.index') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.roles.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61-.25-1.17-.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19-.15-.24-.42-.12-.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l-.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59 1.69-.98l2.49 1c.23.09.49 0 .61.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Role</span>
                    </a>
                @endif

                {{-- ==== MENU UNTUK DOSEN KONSELING ==== --}}
                @if(Auth::user()->hasRole('dosen_konseling'))
                    <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover">
                        <span x-show="open" class="ml-3">Menu Dosen Konseling</span>
                    </a>
                @endif
            </nav>
        </aside>

        <div class="flex-1 flex flex-col">
            @include('layouts.navigation')

            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>