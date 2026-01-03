<x-layouts.app title="Yeni Etkinlik Oluştur">

    <div class="max-w-2xl mx-auto w-full animate-[fadeIn_0.5s_ease-out_forwards]">
        
        <div class="glass rounded-2xl p-8 md:p-12 shadow-2xl border-white/40">
            
            <div class="text-center mb-10">
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Etkinlik Oluştur</h1>
                <p class="text-slate-500">Detayları gir ve topluluğunu bir araya getir.</p>
            </div>

            <form action="{{ route('events.participate') }}" method="GET" class="space-y-6" x-data="{ locationMode: 'common' }">
                
                <!-- Event Title -->
                <div class="relative group">
                    <input type="text" id="title" class="input-field peer pt-6 pb-2" placeholder=" " required />
                    <label for="title" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                        Etkinlik Başlığı
                    </label>
                </div>

                <!-- Description -->
                <div class="relative group">
                    <textarea id="description" rows="3" class="input-field peer pt-6 pb-2 resize-none" placeholder=" "></textarea>
                    <label for="description" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                        Kısa Açıklama (Opsiyonel)
                    </label>
                </div>

                <!-- Date Range -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="relative group">
                        <input type="date" id="start_date" class="input-field peer pt-6 pb-2" placeholder=" " required />
                        <label for="start_date" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                            Başlangıç Tarihi
                        </label>
                    </div>
                    <div class="relative group">
                        <input type="date" id="end_date" class="input-field peer pt-6 pb-2" placeholder=" " required />
                        <label for="end_date" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                            Bitiş Tarihi
                        </label>
                    </div>
                </div>

                <!-- Location Mode -->
                <div class="border border-slate-200 rounded-xl p-4 bg-slate-50/50">
                    <label class="block text-sm font-semibold text-slate-700 mb-3">Konum Tercihi</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="cursor-pointer relative">
                            <input type="radio" name="location_mode" value="common" class="peer sr-only" x-model="locationMode" checked>
                            <div class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-primary peer-checked:bg-white transition-all hover:bg-white hover:border-slate-300 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-slate-800">Ortak Konum</span>
                                    <span class="block text-xs text-slate-500">Katılımcıların konumuna göre</span>
                                </div>
                            </div>
                        </label>

                        <label class="cursor-pointer relative">
                            <input type="radio" name="location_mode" value="suggestion" class="peer sr-only" x-model="locationMode">
                            <div class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-primary peer-checked:bg-white transition-all hover:bg-white hover:border-slate-300 flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0121 18.382V7.618a1 1 0 01-.894-.553L15 7m0 13V7" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block font-medium text-slate-800">Buluşma Noktası</span>
                                    <span class="block text-xs text-slate-500">Önerilen yerleri oylama</span>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="btn-primary w-full text-lg">
                        Devam Et
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </button>
                    
                    <p class="text-center text-xs text-slate-400 mt-4">
                        Devam ederek <a href="#" class="underline hover:text-primary">Kullanım Koşulları</a>'nı kabul etmiş olursunuz.
                    </p>
                </div>

            </form>
        </div>

    </div>

</x-layouts.app>
