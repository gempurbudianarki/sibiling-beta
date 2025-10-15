<x-guest-layout>
  <div class="login-card" style="background:white; padding:2.5rem; border-radius:16px; box-shadow:0 8px 24px rgba(0,0,0,0.08); width:100%; max-width:420px;">
    <div class="login-header" style="text-align:center; margin-bottom:2rem;">
      <h2 style="font-size:1.75rem; font-weight:700; color:#111827;">Masuk ke Akun</h2>
      <p style="color:#6B7280; font-size:1rem;">Silakan masuk untuk mengakses layanan konseling</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div style="margin-bottom:1.5rem;">
        <label for="login" style="font-weight:600; color:#111827; display:block; margin-bottom:0.5rem;">Email atau Username</label>
        <input id="login" name="login" type="text" value="{{ old('login') }}" required autofocus autocomplete="username"
          style="width:100%; padding:0.9rem 1rem; border:1.5px solid #E5E7EB; border-radius:10px; font-size:1rem;">
        <x-input-error :messages="$errors->get('login')" class="mt-2 text-red-500 text-sm" />
      </div>

      <div style="margin-bottom:1.5rem; position: relative;">
        <label for="password" style="font-weight:600; color:#111827; display:block; margin-bottom:0.5rem;">Password</label>
        <input id="password" name="password" type="password" required autocomplete="current-password"
          style="width:100%; padding:0.9rem 1rem; border:1.5px solid #E5E7EB; border-radius:10px; font-size:1rem;">
        
        <!-- Tombol Lihat Password -->
        <button type="button" id="togglePassword" 
          style="position:absolute; right:12px; top:42px; background:none; border:none; cursor:pointer;">
          👁️
        </button>

        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-sm" />
      </div>

      <button type="submit" style="width:100%; padding:0.9rem; border:none; border-radius:10px; background:#2BA172; color:white; font-weight:600; font-size:1.05rem; cursor:pointer;">
        Masuk
      </button>

      @if (Route::has('password.request'))
        <div style="text-align:center; margin-top:1rem;">
          <a href="{{ route('password.request') }}" style="color:#2BA172; text-decoration:none; font-size:0.95rem;">Lupa password?</a>
        </div>
      @endif
    </form>
  </div>

  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('mousedown', () => {
      passwordInput.type = 'text';
    });

    togglePassword.addEventListener('mouseup', () => {
      passwordInput.type = 'password';
    });

    togglePassword.addEventListener('mouseleave', () => {
      passwordInput.type = 'password';
    });
  </script>
</x-guest-layout>
