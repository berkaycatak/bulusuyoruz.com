<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 mb-2">Şifrenizi mi unuttunuz?</h2>
        <p class="text-sm text-slate-500">
            {{ __('Sorun değil. E-posta adresinizi girin, size yeni bir şifre oluşturmanız için sıfırlama bağlantısı gönderelim.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('E-Posta Adresi')" />
            <x-text-input id="email" class="block mt-1 w-full input-field" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <button type="submit" class="btn-primary w-full justify-center py-3">
                {{ __('Sıfırlama Bağlantısı Gönder') }}
            </button>
        </div>
        
        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-primary transition-colors">
                Giriş ekranına dön
            </a>
        </div>
    </form>
</x-guest-layout>
