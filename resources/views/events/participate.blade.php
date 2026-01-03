<x-layouts.app title="Buluşmaya Katıl">

    <div class="max-w-3xl mx-auto w-full" x-data="{ 
        step: 1, 
        locationMode: 'common', /* 'common' (user decides resident) or 'suggestion' (user picks venue) - Simulated from backend */
        location: null,
        
        /* Simulated Date Range from Backend (e.g., 2026-01-10 to 2026-01-20) */
        startDate: new Date('2026-01-10'),
        endDate: new Date('2026-01-20'),
        dates: [],
        
        times: [],
        availableTimes: ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'],

        get daysDifference() {
            const diffTime = Math.abs(this.endDate - this.startDate);
            return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
        },

        formatDate(dateObj) {
            return dateObj.getDate(); 
        },

        toggleDate(dateStr) {
            if (this.dates.includes(dateStr)) {
                this.dates = this.dates.filter(d => d !== dateStr);
            } else {
                this.dates.push(dateStr);
            }
        },

        toggleTime(time) {
            if (this.times.includes(time)) {
                this.times = this.times.filter(t => t !== time);
            } else {
                this.times.push(time);
            }
        }
    }">
        
        <!-- Progress Steps -->
        <div class="flex items-center justify-between mb-10 px-4 md:px-0 relative">
            <div class="absolute left-0 top-1/2 w-full h-1 bg-gray-200 -z-10 rounded-full"></div>
            <div class="absolute left-0 top-1/2 h-1 bg-primary -z-10 rounded-full transition-all duration-500 ease-out"
                 :style="'width: ' + ((step - 1) / 2) * 100 + '%'"></div>

            <template x-for="i in 3">
                <div class="flex flex-col items-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm transition-all duration-300 border-4"
                         :class="step >= i ? 'bg-primary border-white text-white shadow-lg scale-110' : 'bg-white border-gray-200 text-gray-400'">
                        <span x-text="i"></span>
                    </div>
                </div>
            </template>
        </div>

        <div class="glass rounded-2xl p-8 md:p-12 shadow-2xl min-h-[400px] flex flex-col justify-start relative overflow-hidden">
            
            <!-- Step 1: Location -->
            <div x-show="step === 1" x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="opacity-0 translate-x-8" 
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform absolute top-8 left-8 right-8" 
                 x-transition:leave-start="opacity-100 translate-x-0" 
                 x-transition:leave-end="opacity-0 -translate-x-8">
                
                <h2 class="text-2xl font-bold mb-2 text-slate-800">
                    <span x-show="locationMode === 'common'">Nerede Yaşıyorsun?</span>
                    <span x-show="locationMode === 'suggestion'">Nerede Buluşalım?</span>
                </h2>
                <p class="text-slate-500 mb-6">
                    <span x-show="locationMode === 'common'">Etkinlik sahibi, katılımcıların konumuna göre orta bir nokta belirleyecek.</span>
                    <span x-show="locationMode === 'suggestion'">Etkinlik sahibi belirli buluşma noktaları önerdi. Birini seç veya öner.</span>
                </p>
                
                <!-- Common Mode: Input District/City -->
                <div x-show="locationMode === 'common'" class="space-y-4">
                    <div @click="location = 'current'" 
                         class="cursor-pointer p-6 rounded-xl border-2 transition-all duration-200 flex items-center gap-4 hover:shadow-md"
                         :class="location === 'current' ? 'border-primary bg-primary/5' : 'border-slate-100 bg-white hover:border-slate-200'">
                        <div class="w-12 h-12 rounded-full bg-blue-100 text-primary flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-800">Bulunduğum Konumu Kullan</span>
                            <span class="block text-sm text-slate-500">Otomatik tespit edilir</span>
                        </div>
                    </div>
                    
                    <div class="relative group">
                         <select class="input-field" x-model="location">
                            <option value="" disabled selected>Şehir / İlçe Seçin</option>
                            <option value="istanbul">İstanbul</option>
                            <option value="ankara">Ankara</option>
                            <option value="izmir">İzmir</option>
                        </select>
                    </div>
                </div>

                <!-- Suggestion Mode: List of Places -->
                <div x-show="locationMode === 'suggestion'" class="space-y-4">
                     <div @click="location = 'place1'" 
                         class="cursor-pointer p-4 rounded-xl border-2 transition-all duration-200 flex items-center justify-between hover:shadow-md"
                         :class="location === 'place1' ? 'border-primary bg-primary/5' : 'border-slate-100 bg-white hover:border-slate-200'">
                         <span class="font-medium">Caddebostan Sahil</span>
                         <span class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded-full">Açık Hava</span>
                     </div>
                     <div @click="location = 'place2'" 
                         class="cursor-pointer p-4 rounded-xl border-2 transition-all duration-200 flex items-center justify-between hover:shadow-md"
                         :class="location === 'place2' ? 'border-primary bg-primary/5' : 'border-slate-100 bg-white hover:border-slate-200'">
                         <span class="font-medium">Beşiktaş Meydan</span>
                         <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Merkezi</span>
                     </div>
                </div>

                <div class="flex justify-end pt-8">
                    <button @click="if(location) step = 2" 
                            :disabled="!location"
                            class="btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
                        İleri
                    </button>
                </div>
            </div>

            <!-- Step 2: Date & Time -->
            <div x-show="step === 2" x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="opacity-0 translate-x-8" 
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform absolute top-8 left-8 right-8" 
                 x-transition:leave-start="opacity-100 translate-x-0" 
                 x-transition:leave-end="opacity-0 -translate-x-8" style="display: none;">
                
                <h2 class="text-2xl font-bold mb-6 text-slate-800">Ne Zaman?</h2>
                
                <!-- Date Selection -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Tarih Seçimi</h3>
                    <div class="flex flex-wrap gap-2">
                        <template x-for="i in daysDifference">
                            <button @click="toggleDate(new Date(startDate.getTime() + (i-1) * 86400000).toISOString().split('T')[0])" 
                                    class="w-14 h-16 rounded-xl flex flex-col items-center justify-center transition-all duration-200 border"
                                    :class="dates.includes(new Date(startDate.getTime() + (i-1) * 86400000).toISOString().split('T')[0]) 
                                        ? 'bg-secondary border-secondary text-white shadow-md scale-105' 
                                        : 'bg-white border-slate-200 text-slate-600 hover:border-primary/50'">
                                <span class="text-[10px] opacity-70">Oca</span>
                                <span class="font-bold text-lg" x-text="new Date(startDate.getTime() + (i-1) * 86400000).getDate()"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Time Selection -->
                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider mb-3">Saat Aralığı</h3>
                    <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                         <template x-for="time in availableTimes">
                            <button @click="toggleTime(time)"
                                    class="py-2 rounded-lg text-sm font-medium transition-colors border"
                                    :class="times.includes(time) 
                                        ? 'bg-primary border-primary text-white' 
                                        : 'bg-white border-slate-200 text-slate-600 hover:bg-slate-50'">
                                <span x-text="time"></span>
                            </button>
                         </template>
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <button @click="step = 1" class="btn-secondary px-6">Geri</button>
                    <button @click="if(dates.length > 0 && times.length > 0) step = 3" 
                            :disabled="dates.length === 0 || times.length === 0"
                            class="btn-primary disabled:opacity-50 disabled:cursor-not-allowed">
                        İleri
                    </button>
                </div>
            </div>

            <!-- Step 3: Confirm -->
            <div x-show="step === 3" x-transition:enter="transition ease-out duration-300 transform" 
                 x-transition:enter-start="opacity-0 translate-x-8" 
                 x-transition:enter-end="opacity-100 translate-x-0"
                 style="display: none;">
                
                <h2 class="text-2xl font-bold mb-6 text-slate-800">Özet & Onay</h2>
                
                <div class="bg-gradient-to-br from-slate-50 to-white border border-slate-100 rounded-xl p-6 mb-8 shadow-inner space-y-4">
                    
                    <!-- Location Summary -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-blue-100 text-primary flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Konum Tercihi</p>
                            <p class="text-lg font-bold text-slate-800 capitalize" x-text="location"></p>
                        </div>
                    </div>

                    <!-- Date Summary -->
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Tarihler</p>
                            <p class="text-lg font-bold text-slate-800" x-text="dates.length + ' gün seçildi'"></p>
                            <p class="text-sm text-slate-500" x-text="dates.join(', ')"></p>
                        </div>
                    </div>

                     <!-- Time Summary -->
                     <div class="flex items-start gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-wide">Saatler</p>
                            <p class="text-lg font-bold text-slate-800" x-text="times.length + ' saat aralığı'"></p>
                             <p class="text-sm text-slate-500" x-text="times.join(', ')"></p>
                        </div>
                    </div>

                </div>

                <div class="flex justify-between pt-4">
                    <button @click="step = 2" class="btn-secondary px-6">Geri</button>
                    <a href="{{ route('events.result') }}" class="btn-primary flex-1 ml-4 !bg-emerald-500 hover:!bg-emerald-600 !shadow-emerald-500/30">
                        Katılımı Gönder
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

</x-layouts.app>
