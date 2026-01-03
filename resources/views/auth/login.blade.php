<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="relative group">
            <input type="email" id="email" name="email" class="input-field peer pt-6 pb-2" placeholder=" " :value="old('email')" required autofocus autocomplete="username" />
            <label for="email" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Email') }}
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative group">
            <input type="password" id="password" name="password" class="input-field peer pt-6 pb-2" placeholder=" " required autocomplete="current-password" />
            <label for="password" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Password') }}
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-primary shadow-sm focus:ring-primary" name="remember">
                <span class="ms-2 text-sm text-slate-500 hover:text-slate-700">{{ __('Remember me') }}</span>
            </label>
            
            @if (Route::has('password.request'))
                <a class="text-sm text-slate-400 hover:text-primary transition-colors hover:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            {{ __('Log in') }}
        </button>

        <p class="text-center text-sm text-slate-500 mt-4">
            Hesabın yok mu? <a href="{{ route('register') }}" class="text-primary hover:underline font-medium">Kayıt Ol</a>
        </p>
    </form>
</x-guest-layout>
