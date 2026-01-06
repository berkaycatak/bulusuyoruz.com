<div class="max-w-3xl mx-auto w-full" x-data="{ 
    step: 1, 
    locationMode: '{{ $viewModel->event->location_mode }}', 
    location: null,
    
    startDate: new Date('{{ $viewModel->event->start_date->format('Y-m-d') }}'),
    endDate: new Date('{{ $viewModel->event->end_date->format('Y-m-d') }}'),
    dates: [],
    
    times: [],
    availableTimes: ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00'],
    provinces: {{ json_encode($viewModel->provinces()) }},
    districts: {{ json_encode($viewModel->districts()) }},
    hasProvinceRestriction: {{ $viewModel->event->province_id ? 'true' : 'false' }},
    restrictedProvinceId: '{{ $viewModel->event->province_id ?? '' }}',
    selectedProvince: '{{ $viewModel->event->province_id ?? '' }}',
    selectedDistrict: '',
    availableDistricts: [],
    
    // Email for notification
    email: '',
    
    // Weather data
    weatherData: {},
    weatherLoading: false,
    weatherError: false,
    weatherIcons: {
        0: '☀️', 1: '🌤️', 2: '⛅', 3: '☁️',
        45: '🌫️', 48: '🌫️',
        51: '🌧️', 53: '🌧️', 55: '🌧️',
        61: '🌧️', 63: '🌧️', 65: '🌧️',
        71: '❄️', 73: '❄️', 75: '❄️',
        80: '🌦️', 81: '🌦️', 82: '🌦️',
        95: '⛈️', 96: '⛈️', 99: '⛈️'
    },

    // Heatmap Statistics
    stats: {{ json_encode($viewModel->getResponseDateStats()) }},

    getTopDates() {
        if (!this.stats || !this.stats.counts) return [];
        
        return Object.entries(this.stats.counts)
            .filter(([_, count]) => count > 0)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 3)
            .map(([date, count]) => {
                const d = new Date(date);
                const dateFormatted = d.toLocaleDateString('tr-TR', { day: 'numeric', month: 'long' });
                return { text: `${dateFormatted} için ${count} kişi`, date: date };
            });
    },

    getDateClass(day) {
        // 1. Selected State (Primary Blue)
        if (this.dates.includes(day.dateStr)) {
            return 'bg-secondary border-secondary text-white shadow-md scale-105 z-10';
        }

        // 2. Heatmap State (Votes > 0)
        const count = this.stats.counts[day.dateStr] || 0;
        if (count > 0) {
            const max = this.stats.max;
            const intensity = max > 0 ? count / max : 0;

            if (intensity >= 0.75) return 'bg-emerald-500 border-emerald-600 text-white font-semibold shadow-sm';
            if (intensity >= 0.5) return 'bg-emerald-400 border-emerald-400 text-white'; 
            if (intensity >= 0.25) return 'bg-yellow-400 border-yellow-400 text-white';
            
            return 'bg-red-400 border-red-400 text-white';
        }

        // 3. Default State (Weekend vs Weekday)
        // day.dayOfWeek: 0=Sun, 6=Sat
        if (day.dayOfWeek === 0 || day.dayOfWeek === 6) {
             return 'bg-amber-50 border-amber-200 text-amber-700 hover:border-amber-400';
        }

        return 'bg-white border-slate-200 text-slate-600 hover:border-primary/50';
    },

    init() {
        // If province is restricted, pre-load districts and fetch weather immediately
        if (this.hasProvinceRestriction && this.restrictedProvinceId) {
            this.availableDistricts = this.districts[this.restrictedProvinceId] || [];
            this.fetchWeather();
        }
        
        // Watch for province changes to fetch weather
        this.$watch('selectedProvince', (value) => {
            if (value) this.fetchWeather();
        });
    },

    updateDistricts() {
        this.availableDistricts = this.districts[this.selectedProvince] || [];
        this.selectedDistrict = '';
        this.weatherData = {};
    },

    get locationValid() {
        return this.location === 'current' || (this.selectedProvince && this.selectedDistrict);
    },

    get daysDifference() {
        if(!this.startDate || !this.endDate) return 0;
        const diffTime = Math.abs(this.endDate - this.startDate);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
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
    },
    
    getWeatherIcon(dateStr) {
        const code = this.weatherData[dateStr]?.code;
        return this.weatherIcons[code] || '';
    },
    
    getTemperature(dateStr) {
        const temp = this.weatherData[dateStr]?.temp;
        return temp !== undefined ? Math.round(temp) + '°' : '';
    },
    
    async fetchWeather() {
        if (!this.selectedProvince) return;
        
        const province = this.provinces.find(p => p.id == this.selectedProvince);
        if (!province || !province.latitude || !province.longitude) return;
        
        this.weatherLoading = true;
        this.weatherError = false;
        
        try {
            // Use coordinates from database directly
            const { latitude, longitude } = province;
            
            // Get weather forecast
            const weatherRes = await fetch(`https://api.open-meteo.com/v1/forecast?latitude=${latitude}&longitude=${longitude}&daily=weather_code,temperature_2m_max&timezone=auto&forecast_days=16`);
            const weather = await weatherRes.json();
            
            // Map weather data by date
            this.weatherData = {};
            if (weather.daily && weather.daily.time) {
                weather.daily.time.forEach((date, index) => {
                    this.weatherData[date] = {
                        code: weather.daily.weather_code[index],
                        temp: weather.daily.temperature_2m_max[index]
                    };
                });
            }
        } catch (e) {
            console.error('Weather fetch error:', e);
            this.weatherError = true;
        }
        
        this.weatherLoading = false;
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
            
            <!-- Location Selection (Unified for both modes) -->
            <div class="space-y-4">
                
                <!-- Province/District Dropdowns -->
                <div :class="{'opacity-50': location === 'current'}"
                     @click="if(location === 'current') location = null">
                    
                    <!-- Show province info if restricted -->
                    <template x-if="hasProvinceRestriction">
                        <div class="mb-4 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-center gap-2 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                </svg>
                                <span class="font-semibold">Bu etkinlik <span x-text="provinces[0]?.name"></span> şehri için düzenlendi</span>
                            </div>
                        </div>
                    </template>
                    
                    <div class="grid gap-4" :class="hasProvinceRestriction ? 'grid-cols-1' : 'grid-cols-1 sm:grid-cols-2'">
                        <!-- Province Dropdown (only show if no restriction) -->
                        <div class="relative group" x-show="!hasProvinceRestriction">
                             <select class="input-field" x-model="selectedProvince" @change="updateDistricts(); location = null">
                                <option value="" disabled selected>Lütfen İl Seçiniz</option>
                                <template x-for="province in provinces" :key="province.id">
                                    <option :value="province.id" x-text="province.name"></option>
                                </template>
                            </select>
                        </div>
                        
                        <!-- District Dropdown -->
                        <div class="relative group">
                             <select class="input-field" x-model="selectedDistrict" :disabled="!selectedProvince && !hasProvinceRestriction" @change="location = null">
                                <option value="" disabled selected>Lütfen İlçe Seçiniz</option>
                                 <template x-for="district in availableDistricts" :key="district.id">
                                    <option :value="district.id" x-text="district.name"></option>
                                </template>
                            </select>
                        </div>
                    </div>
                </div>
            </div>


            <div class="flex justify-end pt-8">
                <button @click="step = 2" 
                        :disabled="!locationValid"
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
            <div class="mb-8" x-data="{
                getDateInfo(dayIndex) {
                    const date = new Date(startDate.getTime() + dayIndex * 86400000);
                    return {
                        date: date,
                        dateStr: date.toISOString().split('T')[0],
                        dayOfWeek: date.getDay(),
                        dayNum: date.getDate(),
                        monthShort: date.toLocaleDateString('tr-TR', { month: 'short' })
                    };
                },
                
                getWeeks() {
                    const weeks = [];
                    let currentWeek = [null, null, null, null, null, null, null];
                    
                    for (let i = 0; i < daysDifference; i++) {
                        const info = this.getDateInfo(i);
                        let weekPos = info.dayOfWeek === 0 ? 6 : info.dayOfWeek - 1;
                        
                        if (weekPos === 0 && i > 0 && currentWeek.some(d => d !== null)) {
                            weeks.push([...currentWeek]);
                            currentWeek = [null, null, null, null, null, null, null];
                        }
                        
                        currentWeek[weekPos] = { ...info, index: i };
                    }
                    
                    if (currentWeek.some(d => d !== null)) {
                        weeks.push(currentWeek);
                    }
                    
                    return weeks;
                }
            }">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-3 gap-2">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Tarih Seçimi</h3>
                    
                    <div class="flex items-center gap-3">
                        <!-- Legend -->
                        <div class="flex items-center gap-3 text-xs font-medium bg-slate-50 px-3 py-1.5 rounded-lg border border-slate-100">
                            <span class="text-slate-400">Katılıma göre:</span>
                            <div class="flex items-center gap-1">
                                <span class="w-2.5 h-2.5 rounded bg-red-400"></span>
                                <span class="text-slate-600">Düşük</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-2.5 h-2.5 rounded bg-yellow-400"></span>
                                <span class="text-slate-600">Orta</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span class="w-2.5 h-2.5 rounded bg-emerald-500"></span>
                                <span class="text-slate-600">Yüksek</span>
                            </div>
                        </div>

                        <template x-if="weatherLoading">
                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                <svg class="animate-spin h-3 w-3" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="hidden sm:inline">Hava durumu yükleniyor...</span>
                            </span>
                        </template>
                    </div>
                </div>
                
                <!-- Week Days Header -->
                <div class="grid grid-cols-7 gap-1 mb-2">
                    <div class="text-center text-xs font-semibold text-slate-400 py-1">Pzt</div>
                    <div class="text-center text-xs font-semibold text-slate-400 py-1">Sal</div>
                    <div class="text-center text-xs font-semibold text-slate-400 py-1">Çar</div>
                    <div class="text-center text-xs font-semibold text-slate-400 py-1">Per</div>
                    <div class="text-center text-xs font-semibold text-slate-400 py-1">Cum</div>
                    <div class="text-center text-xs font-semibold text-amber-500 py-1">Cmt</div>
                    <div class="text-center text-xs font-semibold text-amber-500 py-1">Paz</div>
                </div>
                
                <!-- Calendar Grid -->
                <div class="space-y-1">
                    <template x-for="(week, weekIndex) in getWeeks()" :key="weekIndex">
                        <div class="grid grid-cols-7 gap-1">
                            <template x-for="(day, dayIndex) in week" :key="dayIndex">
                                <div>
                                    <template x-if="day !== null">
                                        <button type="button"
                                                @click="toggleDate(day.dateStr)"
                                                class="w-full aspect-square rounded-lg flex flex-col items-center justify-center transition-all duration-200 border text-sm relative"
                                                :class="getDateClass(day)">
                                            
                                            <!-- Vote Count Badge (If > 0) -->
                                            <template x-if="stats.counts[day.dateStr] > 0">
                                                <div class="absolute top-1 right-1 flex items-center justify-center w-4 h-4 rounded-full bg-white/30 backdrop-blur-sm text-[8px] font-bold shadow-sm"
                                                     :class="dates.includes(day.dateStr) ? 'text-white bg-white/20' : 'text-slate-800'">
                                                    <span x-text="stats.counts[day.dateStr]"></span>
                                                </div>
                                            </template>

                                            <!-- Weather Icon -->
                                            <span class="text-sm leading-none mt-1" x-text="getWeatherIcon(day.dateStr)"></span>
                                            <!-- Day Number -->
                                            <span class="font-bold text-base leading-tight" x-text="day.dayNum"></span>
                                            <!-- Temperature -->
                                            <span class="text-[10px] leading-none opacity-80 font-medium" x-text="getTemperature(day.dateStr)"></span>
                                        </button>
                                    </template>
                                    <template x-if="day === null">
                                        <div class="w-full aspect-square"></div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
                <!-- Top Dates Text -->
                <template x-if="getTopDates().length > 0">
                    <div class="mt-4 flex flex-wrap gap-2 text-sm text-slate-600 bg-emerald-50/50 p-3 rounded-xl border border-emerald-100/50">
                        <span class="font-bold text-emerald-700">En çok tercih edilenler:</span>
                        <template x-for="(item, index) in getTopDates()" :key="index">
                            <span class="inline-flex items-center">
                                <span x-text="item.text" class="font-medium"></span>
                                <span x-show="index < getTopDates().length - 1" class="mx-2 text-slate-300">•</span>
                            </span>
                        </template>
                    </div>
                </template>
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
            
            <!-- Email Input for Notification -->
            <div class="mb-6 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                <label for="email" class="flex items-center gap-2 text-sm font-semibold text-blue-700 mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Buluşma planlandığında haber almak ister misin?
                </label>
                <input type="email" 
                       id="email" 
                       x-model="email" 
                       placeholder="ornek@email.com (isteğe bağlı)"
                       class="input-field bg-white">
                <p class="text-xs text-blue-600/70 mt-2">E-posta adresin yalnızca bu etkinlikle ilgili bildirim göndermek için kullanılacaktır.</p>
            </div>
            
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
                        <template x-if="location === 'current'">
                             <p class="text-lg font-bold text-slate-800">Mevcut Konumum</p>
                        </template>
                        <template x-if="location !== 'current'">
                            <p class="text-lg font-bold text-slate-800">
                                <span x-text="provinces.find(p => p.id == selectedProvince)?.name"></span> / 
                                <span x-text="availableDistricts.find(d => d.id == selectedDistrict)?.name"></span>
                            </p>
                        </template>
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

            <!-- Hidden Form for Submission -->
            <form id="participate-form" method="POST" action="{{ route('events.respond', $viewModel->event->slug) }}">
                @csrf
                <!-- Note: location_answer is kept but null/optional now. Sending IDs. -->
                <input type="hidden" name="location_answer" :value="location">
                <input type="hidden" name="province_id" :value="selectedProvince">
                <input type="hidden" name="district_id" :value="selectedDistrict">
                <input type="hidden" name="email" :value="email">
                <template x-for="date in dates">
                    <input type="hidden" name="selected_dates[]" :value="date">
                </template>
                <template x-for="time in times">
                    <input type="hidden" name="selected_times[]" :value="time">
                </template>
            </form>

            <div class="flex justify-between pt-4">
                <button @click="step = 2" class="btn-secondary px-6">Geri</button>
                
                <button @click="document.getElementById('participate-form').submit()" 
                        class="btn-primary flex-1 ml-4 !bg-emerald-500 hover:!bg-emerald-600 !shadow-emerald-500/30">
                    Katılımı Gönder
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>
