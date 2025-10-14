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
        <aside :class="{ 'w-64': open, 'w-20': !open }" class="flex-shrink-0 bg-gray-800 text-white transition-all duration-300 flex flex-col">
            <div class="flex items-center justify-between p-4 h-16 flex-shrink-0">
                <span x-show="open" class="text-xl font-semibold">SIBILING</span>
                <button @click="open = !open" class="p-2 rounded-md focus:outline-none focus:ring">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
            
            <nav class="mt-4 px-2 space-y-2 flex-grow overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"></path></svg>
                    <span x-show="open" class="ml-3">Dashboard</span>
                </a>

                {{-- ==== MENU UNTUK ADMIN ==== --}}
                @role('admin')
                    <a href="{{ route('admin.dosen.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.dosen.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Dosen</span>
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.mahasiswa.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
                    </a>
                    <a href="{{ route('admin.roles.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('admin.roles.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61-.25-1.17-.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19-.15-.24-.42-.12-.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l-.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59-1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"></path></svg>
                        <span x-show="open" class="ml-3">Manajemen Role</span>
                    </a>
                @endrole

                {{-- ==== MENU UNTUK DOSEN PEMBIMBING ==== --}}
                @role('dosen_pembimbing')
                    <a href="{{ route('dosen-pembimbing.mahasiswa') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-pembimbing.mahasiswa') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"></path></svg>
                        <span x-show="open" class="ml-3">Mahasiswa Bimbingan</span>
                    </a>
                    <a href="{{ route('dosen-pembimbing.rekomendasi.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-pembimbing.rekomendasi.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v-2h-2z"></path></svg>
                        <span x-show="open" class="ml-3">Rekomendasi</span>
                    </a>
                @endrole
                
                {{-- ==== MENU UNTUK DOSEN KONSELING ==== --}}
                @role('dosen_konseling')
                    <a href="{{ route('dosen-konseling.pengajuan.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-konseling.pengajuan.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V6h5.17l2 2H20v10z"></path></svg>
                        <span x-show="open" class="ml-3">Pengajuan</span>
                    </a>
                    <a href="{{ route('dosen-konseling.jadwal.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-konseling.jadwal.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"></path></svg>
                        <span x-show="open" class="ml-3">Jadwal Saya</span>
                    </a>
                    <a href="{{ route('dosen-konseling.kasus.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('dosen-konseling.kasus.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm12 4h-2v2h2V9zm0 4h-2v2h2v-2zm-4-4H9v2h2V9zm0 4H9v2h2v-2z"></path></svg>
                        <span x-show="open" class="ml-3">Riwayat Kasus</span>
                    </a>
                @endrole

                {{-- ==== MENU UNTUK MAHASISWA ==== --}}
                @role('mahasiswa')
                    <a href="{{ route('mahasiswa.pengajuan.create') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('mahasiswa.pengajuan.create') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"></path></svg>
                        <span x-show="open" class="ml-3">Ajukan Konseling</span>
                    </a>
                    <a href="{{ route('mahasiswa.riwayat.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover {{ request()->routeIs('mahasiswa.riwayat.*') ? 'menu-active' : '' }}">
                        <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"></path></svg>
                        <span x-show="open" class="ml-3">Riwayat Konseling</span>
                    </a>
                @endrole
            </nav>

            <div class="p-2 flex-shrink-0">
                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center justify-between p-2 bg-gray-700 rounded-lg hover:bg-gray-600">
                        <div class="flex items-center">
                            <svg class="h-8 w-8 rounded-full bg-gray-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                            <div x-show="open" class="ml-3 text-left">
                                <p class="text-sm font-semibold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-400 -mt-1">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <div x-show="dropdownOpen" @click.away="dropdownOpen = false" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform -translate-y-2"
                         x-transition:enter-end="opacity-100 transform translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform translate-y-0"
                         x-transition:leave-end="opacity-0 transform -translate-y-2"
                         class="absolute bottom-full left-0 w-full mb-2 bg-gray-700 rounded-lg shadow-lg" style="display: none;">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-200 hover:bg-gray-600">Profile</a>
                        
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); this.closest('form').submit();"
                                   class="block w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-gray-600">
                                Log Out
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <main class="flex-1 p-6 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>