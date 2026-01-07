<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Şifreni Sıfırla</h2>
        <p class="text-sm text-slate-500">
            Lütfen yeni şifrenizi belirleyin.
        </p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-Posta Adresi')" />
            <x-text-input id="email" class="block mt-1 w-full input-field" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Yeni Şifre')" />
            <x-text-input id="password" class="block mt-1 w-full input-field" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Şifre Tekrar')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full input-field"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                {{ __('Şifreyi Sıfırla') }}
            </button>
        </div>
    </form>
</x-guest-layout>
