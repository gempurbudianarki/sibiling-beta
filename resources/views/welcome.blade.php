<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Selamat Datang di SIBILING UBBG</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Background video */
        #background-video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            position: fixed;
            inset: 0;
            z-index: -2;
        }

        /* Overlay gradient dengan RGB (abu gelap elegan) */
        .overlay-gradient {
            background: linear-gradient(135deg, rgb(35,37,38) 0%, rgb(65,67,69) 50%, rgb(23,25,26) 100%);
            opacity: 0.85;
            position: absolute;
            inset: 0;
            z-index: 0;
        }

        /* Animasi fade in */
        .fade-in {
            animation: fadeIn 2s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Glass effect glossy */
        .glass {
            background: rgba(15, 25, 40, 0.35);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        /* Glow text */
        .glow-text {
            background: linear-gradient(to right, rgb(135, 206, 250), rgb(0, 191, 255), rgb(0, 102, 204));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0px 0px 0px rgba(100,200,255,0.7);
        }

        /* Deskripsi */
        .desc {
            color: rgb(255,255,255);
        }

        /* Subjudul */
        .subtitle {
            color: rgb(255,255,255);
            font-size: 22px;
            font-weight: 500;
        }

        /* Tombol custom */
        .btn-animate {
            display: inline-block;
            padding: 16px 40px;
            font-size: 18px;
            font-weight: bold;
            color: rgb(255,255,255);
            background: linear-gradient(to right, rgb(0,191,255), rgb(0,102,204), rgb(25,25,112));
            border-radius: 12px;
            text-decoration: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.4);
            transition: all 0.4s ease;
        }
        .btn-animate:hover {
            transform: scale(1.08) translateY(-3px);
            box-shadow: 0 15px 30px rgba(0,128,255,0.6);
            background: linear-gradient(to right, rgb(30,144,255), rgb(0,76,153), rgb(0,0,102));
        }

        /* Footer */
        footer {
            color: rgba(255, 255, 255, 1);
        }
    </style>
</head>
<body style="font-family: 'Inter', sans-serif;" class="antialiased">

    <!-- Video Background -->
    <video autoplay muted loop id="background-video">
        <source src="https://assets.mixkit.co/videos/preview/mixkit-students-walking-in-a-university-campus-45258-large.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Overlay Gradient -->
    <div class="overlay-gradient"></div>

    <!-- Konten -->
    <div class="relative min-h-screen flex flex-col items-center justify-center p-6 fade-in">
        
        <!-- Panel Glass -->
        <div class="glass w-full max-w-2xl text-center rounded-3xl shadow-2xl p-10 border border-white/20">
            
            <!-- Logo -->
            <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" 
                 style="width: 110px; height: 110px; margin: 0 auto 24px; filter: drop-shadow(0px 4px 6px rgba(0,0,0,0.4));">

            <!-- Judul -->
            <h1 class="glow-text" style="font-size: 52px; font-weight: 800; margin-bottom: 12px;">
                SIBILING UBBG
            </h1>

            <!-- Subjudul -->
            <p class="subtitle">
                Sistem Informasi Bimbingan Konseling
            </p>

            <!-- Deskripsi -->
            <p class="desc" style="margin-top: 24px; font-size: 18px; line-height: 1.6; max-width: 600px; margin-left:auto; margin-right:auto;">
                Platform digital modern untuk mendukung layanan bimbingan dan konseling 
                bagi sivitas akademika 
            </p>
            <p class="desc" style="margin-top: 12px; font-size: 18px; line-height: 1.6; max-width: 600px; margin-left:auto; margin-right:auto;">
               <span style="font-weight: 600; color: rgba(255, 255, 255, 1);">Universitas Bina Bangsa Getsempena</span>.
            </p>

            <!-- Tombol -->
            <div style="margin-top: 40px;">
                <a href="{{ route('login') }}" class="btn-animate">
                    🚀 Masuk ke Sistem
                </a>
            </div>
        </div>

        <!-- Footer -->
        <footer style="position:absolute; bottom:00px; text-align:center; width:100%; font-size:14px;">
            &copy; {{ date('Y') }} Universitas Bina Bangsa Getsempena
        </footer>
    </div>
</body>
</html>
