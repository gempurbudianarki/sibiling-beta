<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SIBILING UBBG | Login Konseling</title>
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <style>
    :root {
      --bg-cream: #FFFCF9;
      --bg-green-light: #EAF7F2;
      --bg-green-lighter: #F0FAF7;
      --btn-green: #2BA172;
      --btn-hover: #23865F;
      --text-dark: #111827;
      --text-gray: #6B7280;
      --border-light: #E5E7EB;
      --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, var(--bg-green-light) 0%, #E0F0FF 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
    }

    /* === Kartu Utama === */
    .main-container {
      display: flex;
      flex-wrap: wrap;
      background: var(--bg-cream);
      border-radius: 24px;
      box-shadow: var(--shadow-md);
      overflow: hidden;
      max-width: 1200px;
      width: 100%;
      animation: fadeIn 0.6s ease forwards;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(25px); }
      to { opacity: 1; transform: translateY(0); }
    }

    /* === Kiri: Brand === */
    .brand-section {
      flex: 1;
      background: linear-gradient(135deg, var(--bg-green-light) 0%, var(--bg-green-lighter) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      text-align: center;
    }

    .brand-section h1 {
      font-weight: 800;
      font-size: 2rem;
      margin-bottom: 1rem;
      color: var(--text-dark);
    }

    .brand-section p {
      color: var(--text-gray);
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 1.5rem;
    }

    .brand-section img {
      max-width: 100%;
      height: auto;
    }

    /* === Kanan: Form === */
    .login-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      background: var(--bg-cream);
    }

    /* === Responsive === */
    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
        border-radius: 18px;
        max-width: 450px;
      }

      .brand-section {
        padding: 2rem 1.5rem 1rem 1.5rem;
        justify-content: flex-start; /* ⬅️ Biar gak terlalu tengah */
      }

      .brand-section img:first-child {
        width: 70px;
        margin-bottom: 0.8rem;
      }

      .brand-section h1 {
        font-size: 1.5rem;
        margin-bottom: 0.6rem;
      }

      .brand-section p {
        font-size: 0.9rem;
        margin-bottom: 1rem;
      }

      .brand-section img:last-child {
        width: 260px;
        margin-top: 0.5rem;
        margin-bottom: 0.2rem;
      }

      /* 🩵 Form sekarang langsung menempel di bawah */
      .login-section {
        padding: 1.5rem 1rem 2rem 1rem;
        margin-top: 0; /* penting */
      }
    }

    @media (max-width: 480px) {
      .brand-section img:last-child {
        width: 210px;
      }
    }
  </style>
</head>

<body>
  <div class="main-container">
    <div class="brand-section">
      <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG">
      <h1>SIBILING UBBG</h1>
      <p>Layanan Konseling Mahasiswa<br>Universitas Bina Bangsa Getsempena</p>
      <img src="{{ asset('images/konseling.png') }}" alt="Ilustrasi Konseling">
    </div>

    <div class="login-section">
      {{ $slot }}
    </div>
  </div>
</body>
</html>
