<x-layouts.app title="Hata Oluştu">
    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="glass p-8 rounded-2xl text-center border border-red-100">
                <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>

                <h1 class="text-3xl font-bold text-slate-900 mb-2">tüh! 😔</h1>
                <p class="text-slate-600 mb-8">
                    Etkinlik oluşturulurken beklenmedik bir sorun oluştu. Lütfen bilgileri kontrol edip tekrar dene.
                </p>

                @if(session('error'))
                <div class="bg-red-50 text-red-700 p-3 rounded-lg text-sm mb-6">
                    {{ session('error') }}
                </div>
                @endif

                <div class="flex flex-col gap-3">
                    <a href="{{ url()->previous() }}" class="btn-primary w-full justify-center">
                        Tekrar Dene
                    </a>
                    <a href="{{ route('dashboard') }}" class="text-slate-500 hover:text-slate-800 text-sm font-medium">
                        Ana Sayfaya Dön
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
