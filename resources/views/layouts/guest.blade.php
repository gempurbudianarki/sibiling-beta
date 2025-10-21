<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>SIBILING UBBG | Login Konseling</title>
  <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800" rel="stylesheet" />
  <style>
    :root {
      --primary-green: #2E8B57;
      --primary-light: #3CB371;
      --primary-dark: #23865F;
      --bg-cream: #FFFCF9;
      --bg-green-light: #EAF7F2;
      --bg-green-lighter: #F0FAF7;
      --text-dark: #1A1A1A;
      --text-gray: #4A4A4A;
      --text-light: #9E9E9E;
      --border-light: #E5E7EB;
      --shadow-sm: 0 2px 8px rgba(0, 0, 0, 0.05);
      --shadow-md: 0 8px 24px rgba(0, 0, 0, 0.08);
      --shadow-lg: 0 20px 40px rgba(0, 0, 0, 0.06);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, var(--bg-green-light) 0%, var(--bg-green-lighter) 100%);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      padding: 1rem;
      line-height: 1.6;
    }

    /* === Enhanced Main Container === */
    .main-container {
      display: flex;
      flex-wrap: wrap;
      background: var(--bg-cream);
      border-radius: 28px;
      box-shadow: var(--shadow-lg);
      overflow: hidden;
      max-width: 1200px;
      width: 100%;
      min-height: 650px;
      animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }

    @keyframes fadeInUp {
      from { 
        opacity: 0; 
        transform: translateY(30px) scale(0.98); 
      }
      to { 
        opacity: 1; 
        transform: translateY(0) scale(1); 
      }
    }

    /* === Enhanced Brand Section === */
    .brand-section {
      flex: 1;
      background: linear-gradient(135deg, var(--primary-green) 0%, var(--primary-dark) 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 4rem 3rem;
      text-align: center;
      position: relative;
      overflow: hidden;
    }

    .brand-section::before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: radial-gradient(circle, rgba(255,255,255,0.1) 1%, transparent 20%);
      animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-20px) rotate(180deg); }
    }

    .brand-logo {
      width: 80px;
      height: 80px;
      margin-bottom: 2rem;
      z-index: 2;
      filter: drop-shadow(0 4px 12px rgba(0,0,0,0.1));
    }

    .brand-section h1 {
      font-weight: 800;
      font-size: 2.5rem;
      margin-bottom: 1rem;
      color: white;
      z-index: 2;
      text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .brand-section p {
      color: rgba(255, 255, 255, 0.9);
      font-size: 1.1rem;
      line-height: 1.6;
      margin-bottom: 2.5rem;
      max-width: 400px;
      z-index: 2;
    }

    .brand-illustration {
      max-width: 320px;
      height: auto;
      z-index: 2;
      filter: drop-shadow(0 8px 24px rgba(0,0,0,0.15));
      transition: transform 0.3s ease;
    }

    .brand-illustration:hover {
      transform: scale(1.05);
    }

    /* === Enhanced Login Section === */
    .login-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem;
      background: var(--bg-cream);
      position: relative;
    }

    .login-content {
      width: 100%;
      max-width: 400px;
      animation: slideInRight 0.6s 0.3s both;
    }

    @keyframes slideInRight {
      from {
        opacity: 0;
        transform: translateX(30px);
      }
      to {
        opacity: 1;
        transform: translateX(0);
      }
    }

    /* === Enhanced Responsive Design === */
    @media (max-width: 1024px) {
      .main-container {
        max-width: 900px;
        min-height: 600px;
      }
      
      .brand-section {
        padding: 3rem 2rem;
      }
      
      .brand-section h1 {
        font-size: 2.2rem;
      }
    }

    @media (max-width: 768px) {
      .main-container {
        flex-direction: column;
        border-radius: 24px;
        max-width: 500px;
        min-height: auto;
        margin: 1rem;
      }

      .brand-section {
        padding: 3rem 2rem 2rem 2rem;
        order: 1;
        border-radius: 24px 24px 0 0;
      }

      .brand-logo {
        width: 70px;
        height: 70px;
        margin-bottom: 1.5rem;
      }

      .brand-section h1 {
        font-size: 2rem;
        margin-bottom: 0.8rem;
      }

      .brand-section p {
        font-size: 1rem;
        margin-bottom: 2rem;
        max-width: 300px;
      }

      .brand-illustration {
        max-width: 250px;
        margin-bottom: 0.5rem;
      }

      .login-section {
        padding: 2.5rem 2rem 3rem 2rem;
        order: 2;
        border-radius: 0 0 24px 24px;
      }

      .login-content {
        animation: slideInUp 0.6s 0.3s both;
      }

      @keyframes slideInUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    }

    @media (max-width: 480px) {
      body {
        padding: 0.5rem;
      }

      .main-container {
        margin: 0.5rem;
        border-radius: 20px;
      }

      .brand-section {
        padding: 2.5rem 1.5rem 1.5rem 1.5rem;
      }

      .brand-logo {
        width: 60px;
        height: 60px;
        margin-bottom: 1.25rem;
      }

      .brand-section h1 {
        font-size: 1.75rem;
      }

      .brand-section p {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
      }

      .brand-illustration {
        max-width: 200px;
      }

      .login-section {
        padding: 2rem 1.5rem 2.5rem 1.5rem;
      }

      .login-content {
        max-width: 100%;
      }
    }

    @media (max-width: 360px) {
      .brand-section {
        padding: 2rem 1rem 1rem 1rem;
      }

      .brand-section h1 {
        font-size: 1.5rem;
      }

      .brand-section p {
        font-size: 0.9rem;
      }

      .brand-illustration {
        max-width: 180px;
      }

      .login-section {
        padding: 1.5rem 1rem 2rem 1rem;
      }
    }

    /* === Enhanced Loading State === */
    .loading {
      opacity: 0.7;
      pointer-events: none;
    }

    /* === Better Focus Management === */
    .main-container:focus-within {
      box-shadow: var(--shadow-lg), 0 0 0 3px rgba(46, 139, 87, 0.1);
    }

    /* === Print Styles === */
    @media print {
      .main-container {
        box-shadow: none;
        border: 1px solid var(--border-light);
      }
      
      .brand-section {
        background: #f8f8f8 !important;
        color: var(--text-dark) !important;
      }
    }
  </style>
</head>

<body>
  <div class="main-container">
    <!-- Brand Section -->
    <div class="brand-section">
      <img src="{{ asset('images/logo-ubbg.png') }}" alt="Logo UBBG" class="brand-logo">
      <h1>SIBILING UBBG</h1>
      <p>Layanan Konseling Mahasiswa<br>Universitas Bina Bangsa Getsempena</p>
      <img src="{{ asset('images/konseling.png') }}" alt="Ilustrasi Konseling" class="brand-illustration">
    </div>

    <!-- Login Form Section -->
    <div class="login-section">
      <div class="login-content">
        {{ $slot }}
      </div>
    </div>
  </div>

  <script>
    // Enhanced loading state handling
    document.addEventListener('DOMContentLoaded', function() {
      const forms = document.querySelectorAll('form');
      
      forms.forEach(form => {
        form.addEventListener('submit', function() {
          this.classList.add('loading');
        });
      });

      // Add subtle interactive effects
      const container = document.querySelector('.main-container');
      
      container.addEventListener('mousemove', (e) => {
        const { left, top, width, height } = container.getBoundingClientRect();
        const x = (e.clientX - left) / width - 0.5;
        const y = (e.clientY - top) / height - 0.5;
        
        container.style.transform = `perspective(1000px) rotateY(${x * 2}deg) rotateX(${-y * 2}deg)`;
      });

      container.addEventListener('mouseleave', () => {
        container.style.transform = 'perspective(1000px) rotateY(0) rotateX(0)';
      });
    });
  </script>
</body>
</html>