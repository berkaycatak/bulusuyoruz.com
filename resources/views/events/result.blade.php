<x-layouts.app title="İşlem Başarılı!">

    <div class="max-w-xl mx-auto w-full pt-12 animate-[fadeInUp_0.6s_ease-out_forwards]">
        
        <!-- Success Card -->
        <div class="glass rounded-2xl p-10 text-center shadow-2xl relative overflow-hidden">
            
            <!-- Confetti Effect (CSS only decoration) -->
            <div class="absolute inset-0 pointer-events-none opacity-50">
                <div class="absolute top-10 left-10 w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <div class="absolute top-12 left-20 w-3 h-3 bg-red-400 rounded-full animate-pulse delay-75"></div>
                <div class="absolute bottom-20 right-10 w-2 h-2 bg-green-500 rounded-full animate-pulse delay-150"></div>
                <div class="absolute top-1/2 right-20 w-3 h-3 bg-yellow-400 rounded-full animate-pulse delay-100"></div>
            </div>

            <!-- Icon -->
            <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-600 shadow-lg shadow-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-3xl font-extrabold text-slate-800 mb-2">Harika!</h1>
            <p class="text-slate-500 text-lg mb-8">Tercihlerin başarıyla kaydedildi.</p>

            <!-- Summary -->
            <div class="bg-slate-50 rounded-xl p-6 text-left mb-8 border border-slate-100">
                <div class="flex items-center justify-between mb-2 pb-2 border-b border-slate-200/60">
                    <span class="text-slate-400 font-medium">Etkinlik</span>
                    <span class="font-bold text-slate-700">Haftasonu Kahvaltısı</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-medium">Durum</span>
                    <span class="text-green-600 font-bold flex items-center gap-1">
                        <span class="w-2 h-2 rounded-full bg-green-500"></span> Onaylandı
                    </span>
                </div>
            </div>

            <!-- Actions -->
            <div class="space-y-4">
                <a href="/" class="btn-primary w-full shadow-xl shadow-blue-500/20">
                    Ana Sayfaya Dön
                </a>
                <a href="{{ route('events.create') }}" class="btn-secondary w-full border-none !bg-slate-50 hover:!bg-slate-100">
                    Yeni Etkinlik Oluştur
                </a>
            </div>

        </div>

    </div>

</x-layouts.app>
