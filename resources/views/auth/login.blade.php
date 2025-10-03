<x-guest-layout>
    <div class="bg-white shadow-xl rounded-2xl p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-800">👋 Selamat Datang Kembali</h2>
            <p class="text-gray-500 mt-2">
                Masuk untuk mengakses layanan <span class="font-semibold text-indigo-600">SIBILING UBBG</span>
            </p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">👤</span>
                    <x-text-input id="username" 
                        class="block w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
                </div>
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">🔒</span>
                    <x-text-input id="password" 
                        class="block w-full pl-10 pr-3 py-2 rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" 
                        type="password" name="password" required autocomplete="current-password" />
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember + Forgot -->
            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="ml-2 text-gray-600">Ingat saya</span>
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" 
                       class="text-indigo-600 hover:underline">Lupa password?</a>
                @endif
            </div>

            <!-- Tombol Login -->
            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white font-semibold rounded-lg shadow hover:scale-[1.02] transition">
                Masuk
            </button>
        </form>

        <!-- Register -->
        <p class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-indigo-600 hover:underline">
                Daftar di sini
            </a>
        </p>
    </div>
</x-guest-layout>
