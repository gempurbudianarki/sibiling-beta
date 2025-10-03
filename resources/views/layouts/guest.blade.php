<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIBILING UBBG') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen flex">
        <!-- ==================== BAGIAN KIRI (BRANDING KAMPUS) ==================== -->
        <div class="hidden lg:flex w-1/2 relative">
            
            <!-- Background foto -->
            <div class="absolute inset-0 bg-cover bg-center"
                 style="background-image:url('https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=1600&auto=format&fit=crop');">
            </div>

            <!-- Overlay gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/85 via-indigo-800/70 to-transparent"></div>

            <!-- Konten branding -->
            <div class="relative flex flex-col justify-center items-center h-full w-full text-center text-white px-8">
                
                <!-- Logo -->
                <div class="bg-white/90 p-3 rounded-full shadow-lg mb-6">
                    <img src="{{ asset('images/logo-ubbg.png') }}" 
                         alt="Logo UBBG" 
                         class="h-20 w-20 drop-shadow-md">
                </div>

                <!-- Judul -->
                <h1 class="text-4xl font-extrabold tracking-tight text-white">SIBILING UBBG</h1>

                <!-- Subjudul -->
                <p class="mt-3 text-lg text-gray-100">Sistem Informasi Bimbingan Konseling</p>

                <!-- Slogan -->
                <p class="mt-3 italic text-orange-400 font-medium">“Unggul, Mandiri dan Religius”</p>
            </div>

            <!-- Footer copyright di paling bawah -->
            <div class="absolute bottom-6 inset-x-0 text-center text-xs text-gray-300 opacity-80">
                © {{ date('Y') }} Universitas Bina Bangsa Getsempena
            </div>
        </div>

        <!-- ==================== BAGIAN KANAN (FORM LOGIN / REGISTER) ==================== -->
        <div class="flex w-full lg:w-1/2 items-center justify-center p-6 sm:p-10 bg-gray-50">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
