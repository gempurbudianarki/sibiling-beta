<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Gradient sidebar */
        .sidebar-gradient {
            background: linear-gradient(180deg, #1a3b1fff 0%, #054e22ff 60%, #0C342C 100%);
        }

        /* Hover effect menu */
        .menu-hover {
            transition: all 0.3s ease-in-out;
        }
        .menu-hover:hover {
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transform: translateX(5px);
        }

        /* Logo bulat */
        .logo-circle {
            background: white;
            padding: 8px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
        }

        /* Logout button merah elegan */
        .btn-logout {
            background: linear-gradient(90deg, #FF5F6D, #FF0000);
            transition: all 0.3s ease-in-out;
        }
        .btn-logout:hover {
            background: linear-gradient(90deg, #FF0000, #B30000);
            transform: scale(1.05);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100">
<div x-data="{ open: true }" class="flex h-screen bg-gray-100">

    <!-- Sidebar -->
    <aside 
        class="relative transition-all duration-500 ease-in-out"
        :class="open ? 'w-64' : 'w-20'"
    >
        <!-- Background Gradient Hijau Mewah -->
        <div class="fixed inset-y-0 left-0 z-30 h-screen sidebar-gradient text-white transition-all duration-500"
             :class="open ? 'w-64' : 'w-20'">

            <!-- Logo & Branding -->
            <div class="flex items-center justify-center p-4 border-b border-green-800">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" class="h-10 w-10">
                </div>
                <span x-show="open" 
                      class="ml-3 text-xl font-bold tracking-wide text-white transition-opacity duration-300">
                    SIBILING
                </span>
            </div>

            <!-- Navigation Links -->
            <nav class="mt-6 space-y-2">
                <a href="{{ route('dashboard') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L2 6v2h16V6l-8-4zM2 10h16v8H2v-8z"/>
                    </svg>
                    <span x-show="open" class="ml-3">Dashboard</span>
                </a>

                <a href="{{ route('dosen.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a4 4 0 00-4 4v2H4v10h12V8h-2V6a4 4 0 00-4-4z"/>
                    </svg>
                    <span x-show="open" class="ml-3">Manajemen Dosen</span>
                </a>

                <a href="{{ route('mahasiswa.index') }}" 
                   class="flex items-center px-4 py-3 text-sm font-medium rounded-lg menu-hover">
                    <svg class="h-5 w-5 text-lime-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 12a5 5 0 100-10 5 5 0 000 10zm-7 6a7 7 0 0114 0H3z"/>
                    </svg>
                    <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
                </a>
            </nav>

            <!-- Tombol Logout -->
            <div class="absolute bottom-6 w-full px-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="flex items-center w-full px-4 py-3 text-sm font-medium text-left rounded-lg btn-logout text-white">
                        <svg class="h-5 w-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" 
                                  d="M3 4a1 1 0 011-1h6a1 1 0 010 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm11.707 1.293a1 1 0 010 1.414L13.414 9H9a1 1 0 100 2h4.414l1.293 2.293a1 1 0 001.414-1.414L15.414 10l2-2.293a1 1 0 00-1.414-1.414L15 8.586l-1.293-1.293a1 1 0 00-1.414 0z" 
                                  clip-rule="evenodd"/>
                        </svg>
                        <span x-show="open">Logout</span>
                    </button>
                </form>
            </div>

            <!-- Tombol Toggle -->
            <button @click="open = !open" 
                    class="absolute -right-3 top-6 bg-white text-green-700 rounded-full p-1 shadow-md hover:scale-110 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <header class="flex items-center justify-between p-4 bg-white border-b shadow-sm">
            <h2 class="font-semibold text-xl text-gray-800">
                {{ $header ?? 'Dashboard' }}
            </h2>
            <div>{{ Auth::user()->name ?? 'User' }}</div>
        </header>

        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
            <div class="container mx-auto px-6 py-8">
                {{ $slot }}
            </div>
        </main>
    </div>
</div>
</body>
</html>
