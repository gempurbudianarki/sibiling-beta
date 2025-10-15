<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SIBILING UBBG | Layanan Konseling Mahasiswa</title>
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <style>
    :root {
      --bg-cream: #FFFCF9;
      --bg-green-light: #EAF7F2;
      --btn-green: #2BA172;
      --btn-hover: #23865F;
      --text-dark: #111827;
      --text-sub: #334155;
      --text-normal: #475569;
      --shadow-md: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background-color: var(--bg-cream);
      color: var(--text-dark);
      overflow-x: hidden;
    }

    .bg-shapes {
      position: fixed;
      inset: 0;
      z-index: -1;
    }

    .shape-top-right {
      position: absolute;
      top: -10%;
      right: -15%;
      width: 70%;
      height: 45%;
      background-color: var(--bg-green-light);
      border-bottom-left-radius: 50%;
      opacity: 0.75;
    }

    .shape-bottom-left {
      position: absolute;
      bottom: -10%;
      left: -15%;
      width: 70%;
      height: 40%;
      background-color: var(--bg-green-light);
      border-top-right-radius: 50%;
      opacity: 0.75;
    }

    .container {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      height: 100vh;
      overflow: hidden;
      padding: 1.5rem;
      gap: 2rem;
    }

    .logo {
      display: flex;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }

    .logo-img {
      width: 2.8rem;
      height: 2.8rem;
    }

    .logo-text {
      font-size: 1.6rem;
      color: var(--btn-green);
      font-weight: 700;
    }

    h1 {
      font-size: 2.2rem;
      font-weight: 800;
      line-height: 1.2;
      margin-bottom: 1rem;
    }

    .subtitle {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-sub);
      margin-bottom: 1.2rem;
    }

    .desc {
      font-size: 1rem;
      color: var(--text-normal);
      margin-bottom: 2rem;
      max-width: 500px;
    }

    .btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      background-color: var(--btn-green);
      color: white;
      text-decoration: none;
      font-weight: 700;
      font-size: 1.1rem;
      padding: 1rem 2rem;
      border-radius: 0.75rem;
      box-shadow: var(--shadow-md);
      transition: all 0.3s ease;
    }

    .btn:hover {
      background-color: var(--btn-hover);
      transform: translateY(-2px);
    }

    .illustration {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .illustration-img {
      width: 90%;
      max-width: 320px;
      height: auto;
    }

    /* 📱 Mobile fix (pas dan gak bisa digeser) */
    @media (max-width: 767px) {
      .container {
        height: 100vh;
        justify-content: space-between;
        padding-top: 2rem;
        padding-bottom: 2rem;
      }

      .desc {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
      }

      .illustration {
        margin-top: 0.5rem;
      }

      .illustration-img {
        max-width: 300px;
      }
    }

    /* 💻 Desktop fix — gedein semua */
    @media (min-width: 1024px) {
      .container {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 0 8rem;
        height: 100vh;
      }

      .content {
        flex: 1;
      }

      h1 {
        font-size: 4.5rem;
        margin-bottom: 1.5rem;
      }

      .subtitle {
        font-size: 1.75rem;
        margin-bottom: 1.5rem;
      }

      .desc {
        font-size: 1.3rem;
        max-width: 650px;
        margin-bottom: 3rem;
      }

      .btn {
        font-size: 1.25rem;
        padding: 1.25rem 3rem;
        border-radius: 1rem;
      }

      .illustration {
        flex: 1;
        justify-content: flex-end;
      }

      .illustration-img {
        max-width: 850px;
        height: auto;
      }
    }

    /* 🖥 Ultra wide monitor */
    @media (min-width: 1440px) {
      h1 { font-size: 5rem; }
      .subtitle { font-size: 2rem; }
      .desc { font-size: 1.5rem; }
      .illustration-img { max-width: 950px; }
    }
  </style>
</head>

<body>
  <div class="bg-shapes">
    <div class="shape-top-right"></div>
    <div class="shape-bottom-left"></div>
  </div>

  <div class="container">
    <div class="content">
      <div class="logo">
        <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" class="logo-img">
        <span class="logo-text">Sibiling</span>
      </div>
      <h1>Selamat Datang di SIBILING UBBG</h1>
      <p class="subtitle">Layanan Konseling Mahasiswa Universitas Bina Bangsa Getsempena</p>
      <p class="desc">
        Kami hadir untuk mendampingi mahasiswa menghadapi berbagai tantangan akademik, pribadi, dan karier.  
        Dapatkan ruang curhat yang aman, nyaman, dan penuh empati bersama konselor profesional kami.
      </p>
      <a href="{{ route('login') }}" class="btn">Yok Konseling</a>
    </div>

    <div class="illustration">
      <img src="{{ asset('images/konseling.png') }}" alt="Ilustrasi Konseling" class="illustration-img">
    </div>
  </div>
</body>
</html>
