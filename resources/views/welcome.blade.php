<x-layouts.app title="Buluşuyoruz - Topluluklar Kolayca Buluşsun">

    <!-- Hero Section -->
    <section class="min-h-[70vh] flex flex-col items-center justify-center text-center relative max-w-4xl mx-auto">
        
        <!-- Abstract Decoration -->
        <div class="absolute inset-0 pointer-events-none opacity-30">
            <svg class="w-full h-full" viewBox="0 0 800 600" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="100" cy="100" r="40" fill="#2563EB" fill-opacity="0.1" />
                <circle cx="700" cy="500" r="60" fill="#22C55E" fill-opacity="0.1" />
                <path d="M600 100 Q 400 300 200 100" stroke="#F59E0B" stroke-width="2" stroke-dasharray="10 10" stroke-opacity="0.2" fill="none"/>
            </svg>
        </div>

        <div class="space-y-6 animate-[fadeInUp_0.8s_ease-out_forwards]">
            <h1 class="text-5xl md:text-7xl font-extrabold tracking-tight leading-[1.1] text-slate-900">
                Topluluklar <br/>
                <span class="bg-clip-text text-transparent bg-gradient-to-r from-primary to-secondary">
                    Kolayca Buluşsun
                </span>
            </h1>

            <p class="text-lg md:text-xl text-slate-500 font-medium max-w-xl mx-auto leading-relaxed">
                Karmaşık formlar yok. Gereksiz detaylar yok. <br class="hidden md:block"/> Sadece toplanın, planlayın ve buluşun.
            </p>

            <div class="flex flex-col sm:flex-row gap-4 justify-center pt-8">
                <a href="{{ route('events.create') }}" class="btn-primary">
                    Etkinlik Oluştur
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </a>
                <a href="#nasil-calisir" class="btn-secondary">
                    Nasıl Çalışır?
                </a>
            </div>
        </div>
    </section>

    <!-- Minimal Features -->
    <section class="py-20" id="nasil-calisir">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="glass p-8 rounded-2xl md:min-h-48 flex flex-col items-center text-center card-hover">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Konum Seç</h3>
                <p class="text-slate-500 text-sm">Haritadan veya listeden en uygun yeri belirle.</p>
            </div>

            <!-- Card 2 -->
            <div class="glass p-8 rounded-2xl md:min-h-48 flex flex-col items-center text-center card-hover">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Tarih Belirle</h3>
                <p class="text-slate-500 text-sm">Herkes için en uygun zamanı oylayarak bul.</p>
            </div>

            <!-- Card 3 -->
            <div class="glass p-8 rounded-2xl md:min-h-48 flex flex-col items-center text-center card-hover">
                <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">Buluşun!</h3>
                <p class="text-slate-500 text-sm">Katılımcı listesini yönet ve eğlencenin tadını çıkar.</p>
            </div>
        </div>
    </section>

</x-layouts.app>
