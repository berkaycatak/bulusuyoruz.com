<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div class="relative group">
            <input type="text" id="name" name="name" class="input-field peer pt-6 pb-2" placeholder=" " :value="old('name')" required autofocus autocomplete="name" />
            <label for="name" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Name') }}
            </label>
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="relative group">
            <input type="email" id="email" name="email" class="input-field peer pt-6 pb-2" placeholder=" " :value="old('email')" required autocomplete="username" />
            <label for="email" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Email') }}
            </label>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="relative group">
            <input type="password" id="password" name="password" class="input-field peer pt-6 pb-2" placeholder=" " required autocomplete="new-password" />
            <label for="password" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Password') }}
            </label>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="relative group">
            <input type="password" id="password_confirmation" name="password_confirmation" class="input-field peer pt-6 pb-2" placeholder=" " required autocomplete="new-password" />
            <label for="password_confirmation" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                {{ __('Confirm Password') }}
            </label>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit" class="btn-primary w-full justify-center">
            {{ __('Register') }}
        </button>

        <p class="text-center text-sm text-slate-500 mt-4">
            Zaten hesabın var mı? <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">Giriş Yap</a>
        </p>
    </form>
</x-guest-layout>
