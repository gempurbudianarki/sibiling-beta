<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root{
            --bg-cream:#FFFCF9;--bg-green-light:#EAF7F2;--bg-green-dark:#2BA172;--bg-green-darker:#23865F;
            --text-dark:#111827;--text-gray:#6B7280;--text-light:#9CA3AF;--border-light:#E5E7EB;
            --shadow-sm:0 2px 8px rgba(0,0,0,.05);--shadow-md:0 8px 24px rgba(0,0,0,.08);--shadow-lg:0 20px 40px rgba(0,0,0,.06)
        }
        .font-sans{font-family:'Inter',sans-serif}
        .sidebar-modern{background:linear-gradient(180deg,var(--bg-green-dark) 0%,var(--bg-green-darker) 100%);box-shadow:var(--shadow-lg)}
        .menu-hover{transition:.3s;color:rgba(255,255,255,.85)}
        .menu-hover:hover{background:rgba(255,255,255,.18);color:#fff;transform:translateX(4px)}
        .menu-active{background:rgba(255,255,255,.24);color:#fff;border-left:4px solid #fff}
        .logo-text{background:linear-gradient(135deg,#fff 0%,#EAF7F2 100%);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;font-weight:800}
        .main-content{background:var(--bg-cream)}
        .header-modern{background:#fff;box-shadow:var(--shadow-sm);border-bottom:1px solid var(--border-light)}
        .user-dropdown{background:rgba(255,255,255,.98);backdrop-filter:blur(10px);border:1px solid rgba(0,0,0,.04)}
        .icon-primary{color:#fff}
        .sidebar-scroll::-webkit-scrollbar{width:4px}
        .sidebar-scroll::-webkit-scrollbar-track{background:rgba(255,255,255,.1);border-radius:10px}
        .sidebar-scroll::-webkit-scrollbar-thumb{background:rgba(255,255,255,.35);border-radius:10px}
        .sidebar-transition{transition:all .3s cubic-bezier(.4,0,.2,1)}
        .role-badge{background:rgba(255,255,255,.2);color:#fff;font-size:.7rem;padding:.25rem .5rem;border-radius:12px;margin-top:.25rem}
        .dashboard-card{background:#fff;border-radius:16px;box-shadow:var(--shadow-sm);border:1px solid var(--border-light)}
        .table-modern{width:100%;border-collapse:collapse}
        .table-modern th{background:var(--bg-green-light);color:var(--text-dark);font-weight:600;padding:1rem;text-align:left;border-bottom:2px solid var(--border-light)}
        .table-modern td{padding:1rem;border-bottom:1px solid var(--border-light);color:var(--text-gray)}
        .table-modern tr:hover{background:var(--bg-cream)}
        .empty-state{text-align:center;padding:3rem 2rem;color:var(--text-light)}
        .empty-state svg{width:64px;height:64px;margin-bottom:1rem;opacity:.5}
        
        /* === PREMIUM LOADING ANIMATION - TAMBAHAN BARU === */
        .premium-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--bg-green-dark) 0%, var(--bg-green-darker) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .premium-loader.active {
            opacity: 1;
            visibility: visible;
        }

        .loader-logo {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            animation: logoBounce 2s ease-in-out infinite;
        }

        .loader-logo span {
            font-size: 2rem;
            font-weight: 800;
            color: var(--bg-green-dark);
        }

        .loader-content {
            text-align: center;
            color: white;
        }

        .loader-text {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            opacity: 0;
            animation: fadeInUp 0.8s 0.5s ease forwards;
        }

        .loader-subtext {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 2rem;
            opacity: 0;
            animation: fadeInUp 0.8s 0.7s ease forwards;
        }

        .loader-progress {
            width: 200px;
            height: 4px;
            background: rgba(255,255,255,0.2);
            border-radius: 10px;
            overflow: hidden;
        }

        .loader-progress-bar {
            height: 100%;
            background: white;
            border-radius: 10px;
            animation: progressLoad 2s ease-in-out infinite;
        }

        @keyframes logoBounce {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-10px) scale(1.05); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes progressLoad {
            0% { width: 0%; }
            50% { width: 70%; }
            100% { width: 100%; }
        }

        .navigation-loading {
            position: relative;
            pointer-events: none;
        }
        
        .navigation-loading::after {
            content: '';
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 16px;
            height: 16px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: translateY(-50%) rotate(0deg); }
            100% { transform: translateY(-50%) rotate(360deg); }
        }
        /* === END PREMIUM LOADING ANIMATION === */

        /* mobile: sidebar menjadi off-canvas, konten full */
        @media (max-width:1023px){ .offcanvas { position:fixed; inset:0 auto 0 0; height:100vh; } }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">

<!-- === PREMIUM LOADER OVERLAY - TAMBAHAN BARU === -->
<div id="premiumLoader" class="premium-loader">
    <div class="loader-logo">
        <span>S</span>
    </div>
    <div class="loader-content">
        <div class="loader-text">SIBILING UBBG</div>
        <div class="loader-subtext">Memuat konten...</div>
        <div class="loader-progress">
            <div class="loader-progress-bar"></div>
        </div>
    </div>
</div>

<div x-data="{ 
    open:true, 
    mobileOpen:false,
    showLoading(url) {
        // Show premium loader
        const loader = document.getElementById('premiumLoader');
        loader.classList.add('active');
        
        // Add loading state to clicked menu
        event.target.classList.add('navigation-loading');
        
        // Navigate after short delay for smooth UX
        setTimeout(() => {
            window.location.href = url;
        }, 800);
    }
}" class="flex min-h-screen">

    <!-- Overlay mobile -->
    <div x-show="mobileOpen" @click="mobileOpen=false"
         class="fixed inset-0 bg-black/50 z-40 lg:hidden"
         x-transition.opacity></div>

    <!-- Sidebar -->
    <aside
        :class="{
            'w-64': open,
            'w-20': !open,
            'translate-x-0': mobileOpen,
            '-translate-x-full': !mobileOpen
        }"
        class="sidebar-modern text-white sidebar-transition flex flex-col z-50 h-screen offcanvas lg:relative lg:translate-x-0 lg:h-auto">

        <!-- Header logo + toggles -->
        <div class="flex items-center justify-between p-6 h-20 flex-shrink-0 border-b border-white/10">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <span class="text-green-600 font-bold text-lg">S</span>
                </div>
                <span x-show="open" class="logo-text text-xl font-bold">SIBILING</span>
            </div>

            <!-- Toggle (desktop) -->
            <button @click="open=!open" class="p-2 rounded-lg hover:bg-white/10 transition hidden lg:flex">
                <svg class="h-5 w-5 icon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'"></path>
                </svg>
            </button>
            <!-- Close (mobile) -->
            <button @click="mobileOpen=false" class="p-2 rounded-lg hover:bg-white/10 transition lg:hidden">
                <svg class="h-5 w-5 icon-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Menu - MODIFIED dengan loading handler -->
        <nav class="mt-4 px-4 space-y-1 flex-grow overflow-y-auto sidebar-scroll">
            <a href="{{ route('dashboard') }}"
               @click="showLoading('{{ route('dashboard') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dashboard') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                <span x-show="open" class="ml-3">Dashboard</span>
            </a>

            @role('admin')
            <a href="{{ route('admin.dosen.index') }}"
               @click="showLoading('{{ route('admin.dosen.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.dosen.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                <span x-show="open" class="ml-3">Manajemen Dosen</span>
            </a>
            <a href="{{ route('admin.mahasiswa.index') }}"
               @click="showLoading('{{ route('admin.mahasiswa.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.mahasiswa.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 5.9c1.16 0 2.1.94 2.1 2.1s-.94 2.1-2.1 2.1S9.9 9.16 9.9 8s.94-2.1 2.1-2.1m0 9c2.97 0 6.1 1.46 6.1 2.1v1.1H5.9V17c0-.64 3.13-2.1 6.1-2.1M12 4C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 9c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4z"/></svg>
                <span x-show="open" class="ml-3">Manajemen Mahasiswa</span>
            </a>
            <a href="{{ route('admin.roles.index') }}"
               @click="showLoading('{{ route('admin.roles.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('admin.roles.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19.43 12.98c.04-.32.07-.64.07-.98s-.03-.66-.07-.98l2.11-1.65c.19-.15.24-.42.12-.64l-2-3.46c-.12-.22-.39-.3-.61-.22l-2.49 1c-.52-.4-1.08-.73-1.69-.98l-.38-2.65C14.46 2.18 14.25 2 14 2h-4c-.25 0-.46.18-.49.42l-.38 2.65c-.61-.25-1.17-.59-1.69-.98l-2.49-1c-.23-.09-.49 0-.61.22l-2 3.46c-.13.22-.07.49.12.64l2.11 1.65c-.04.32-.07.65-.07.98s.03.66.07.98l-2.11 1.65c-.19-.15-.24-.42-.12-.64l2 3.46c.12.22.39.3.61.22l2.49-1c.52.4 1.08.73 1.69.98l-.38 2.65c.03.24.24.42.49.42h4c.25 0 .46-.18.49-.42l.38-2.65c.61-.25 1.17-.59-1.69-.98l2.49 1c.23.09.49 0 .61-.22l2-3.46c.12-.22.07-.49-.12-.64l-2.11-1.65zM12 15.5c-1.93 0-3.5-1.57-3.5-3.5s1.57-3.5 3.5-3.5 3.5 1.57 3.5 3.5-1.57 3.5-3.5 3.5z"/></svg>
                <span x-show="open" class="ml-3">Manajemen Role</span>
            </a>
            @endrole

            @role('dosen_pembimbing')
            <a href="{{ route('dosen-pembimbing.mahasiswa') }}"
               @click="showLoading('{{ route('dosen-pembimbing.mahasiswa') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-pembimbing.mahasiswa') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                <span x-show="open" class="ml-3">Mahasiswa Bimbingan</span>
            </a>
            <a href="{{ route('dosen-pembimbing.rekomendasi.index') }}"
               @click="showLoading('{{ route('dosen-pembimbing.rekomendasi.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-pembimbing.rekomendasi.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v-2h-2z"/></svg>
                <span x-show="open" class="ml-3">Rekomendasi</span>
            </a>
            @endrole

            @role('dosen_konseling')
            <a href="{{ route('dosen-konseling.pengajuan.index') }}"
               @click="showLoading('{{ route('dosen-konseling.pengajuan.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.pengajuan.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M20 6h-8l-2-2H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V8c0-1.1-.9-2-2-2zm0 12H4V6h5.17l2 2H20v10z"/></svg>
                <span x-show="open" class="ml-3">Pengajuan</span>
            </a>
            <a href="{{ route('dosen-konseling.jadwal.index') }}"
               @click="showLoading('{{ route('dosen-konseling.jadwal.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.jadwal.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z"/></svg>
                <span x-show="open" class="ml-3">Jadwal Saya</span>
            </a>
            <a href="{{ route('dosen-konseling.kasus.index') }}"
               @click="showLoading('{{ route('dosen-konseling.kasus.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('dosen-konseling.kasus.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M3 5v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2zm12 4h-2v2h2V9zm0 4h-2v2h2v-2zm-4-4H9v2h2V9zm0 4H9v2h2v-2z"/></svg>
                <span x-show="open" class="ml-3">Riwayat Kasus</span>
            </a>
            @endrole

            @role('mahasiswa')
            <a href="{{ route('mahasiswa.pengajuan.create') }}"
               @click="showLoading('{{ route('mahasiswa.pengajuan.create') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('mahasiswa.pengajuan.create') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                <span x-show="open" class="ml-3">Ajukan Konseling</span>
            </a>
            <a href="{{ route('mahasiswa.riwayat.index') }}"
               @click="showLoading('{{ route('mahasiswa.riwayat.index') }}')"
               class="flex items-center px-4 py-3 text-sm font-medium rounded-xl menu-hover {{ request()->routeIs('mahasiswa.riwayat.*') ? 'menu-active' : '' }}">
                <svg class="h-5 w-5 icon-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M13 3a9 9 0 0 0-9 9H1l3.89 3.89.07.14L9 12H6c0-3.87 3.13-7 7-7s7 3.13 7 7-3.13 7-7 7c-1.93 0-3.68-.79-4.94-2.06l-1.42 1.42A8.954 8.954 0 0 0 13 21a9 9 0 0 0 0-18zm-1 5v5l4.28 2.54.72-1.21-3.5-2.08V8H12z"/></svg>
                <span x-show="open" class="ml-3">Riwayat Konseling</span>
            </a>
            @endrole
        </nav>

        <!-- User / Dropdown -->
        <div class="p-4 flex-shrink-0 border-t border-white/10">
            <div x-data="{ dd:false }" class="relative">
                <button @click="dd=!dd" class="w-full flex items-center justify-between p-3 bg-white/10 rounded-xl hover:bg-white/15 transition">
                    <div class="flex items-center min-w-0">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-green-600 font-bold text-sm">{{ strtoupper(substr(Auth::user()->name,0,2)) }}</span>
                        </div>
                        <div x-show="open" class="ml-3 text-left min-w-0 flex-1">
                            <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-white/70 truncate -mt-1">{{ Auth::user()->email }}</p>
                            <div class="role-badge inline-block">
                                @foreach(Auth::user()->roles as $role)
                                    {{ ucfirst(str_replace('_',' ',$role->name)) }}
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <svg x-show="open" class="w-4 h-4 flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="dd" @click.away="dd=false"
                     x-transition
                     class="absolute bottom-full left-0 w-full mb-2 user-dropdown rounded-xl shadow-lg overflow-hidden"
                     style="display:none;">
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50">
                        <svg class="h-4 w-4 mr-3 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex items-center w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50">
                            <svg class="h-4 w-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col main-content lg:ml-0 transition-all duration-300">
        <!-- Mobile header -->
        <div class="lg:hidden header-modern px-4 py-3 flex items-center justify-between">
            <button @click="mobileOpen=true" class="p-2 rounded-lg hover:bg-gray-100">
                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
            <div class="text-lg font-semibold text-gray-800">SIBILING UBBG</div>
            <div class="w-10"></div>
        </div>

        @if (isset($header))
            <header class="header-modern">
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

<script>
    // Hide loader when page is fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const loader = document.getElementById('premiumLoader');
        if (loader) {
            loader.classList.remove('active');
        }
    });
</script>
</body>
</html>