<x-layouts.app title="Etkinliği Düzenle">
    <div class="py-12">
        <div class="max-w-2xl mx-auto">
            <div class="mb-6 text-center">
                 <h1 class="font-bold text-2xl text-slate-800">
                    Etkinliği Düzenle
                </h1>
                <p class="text-slate-500 text-sm mt-1">Etkinlik detaylarını güncelleyebilirsiniz.</p>
            </div>

            <div class="glass p-8 rounded-2xl">
                <form action="{{ route('events.update', $event->slug) }}" method="POST" class="space-y-8" x-data="{ locationMode: '{{ old('location_mode', $event->location_mode) }}' }">
                    @csrf
                    @method('PUT')
                    
                    <!-- Event Title -->
                    <div class="relative group">
                        <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" 
                               class="input-field peer pt-6 pb-2 border-0 border-b-2 border-slate-200 bg-transparent rounded-none px-0 focus:ring-0 focus:border-primary placeholder-transparent text-lg font-semibold" 
                               placeholder=" " required />
                        <label for="title" class="absolute text-slate-400 duration-300 transform -translate-y-4 scale-75 top-4 z-10 origin-[0] left-0 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-4 peer-focus:text-primary">
                            Etkinlik Adı
                        </label>
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Date Range Selection -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="relative group">
                            <label for="start_date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Başlangıç Tarihi</label>
                            <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}" class="input-field" required />
                            <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
                        </div>
                        <div class="relative group">
                            <label for="end_date" class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Bitiş Tarihi</label>
                            <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}" class="input-field" required />
                            <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Location Mode Selection -->
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-4">Konum Tercihi</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Option 1: Common Location -->
                            <label class="cursor-pointer">
                                <input type="radio" name="location_mode" value="common" x-model="locationMode" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-blue-300 peer-checked:border-primary peer-checked:bg-blue-50/50 transition-all group">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                              <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                                              <circle cx="12" cy="10" r="3"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-slate-900">Ortak Konum</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Katılımcıların konumuna göre orta nokta bulunsun.</p>
                                </div>
                            </label>

                            <!-- Option 2: Suggestion -->
                            <label class="cursor-pointer">
                                <input type="radio" name="location_mode" value="suggestion" x-model="locationMode" class="peer sr-only">
                                <div class="p-4 rounded-xl border-2 border-slate-200 hover:border-green-300 peer-checked:border-green-500 peer-checked:bg-green-50/50 transition-all group">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-8 h-8 rounded-full bg-green-100 flex items-center justify-center text-green-600 group-hover:scale-110 transition-transform">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                              <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"/>
                                              <line x1="4" x2="4" y1="22" y2="15"/>
                                            </svg>
                                        </div>
                                        <span class="font-semibold text-slate-900">Buluşma Noktası</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Ben bir yer önereceğim veya anket yapılsın.</p>
                                </div>
                            </label>
                        </div>
                        <x-input-error :messages="$errors->get('location_mode')" class="mt-2" />
                    </div>

                    <!-- Description -->
                    <div class="relative group">
                        <textarea id="description" name="description" rows="3" class="input-field peer pt-6 pb-2" placeholder=" ">{{ old('description', $event->description) }}</textarea>
                        <label for="description" class="absolute text-slate-400 duration-300 transform -translate-y-3 scale-75 top-4 z-10 origin-[0] left-4 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-3 peer-focus:text-primary">
                            Açıklama (Opsiyonel)
                        </label>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-4 pt-4">
                        <a href="{{ route('events.show', $event->slug) }}" class="text-slate-500 hover:text-slate-800 font-medium text-sm">İptal</a>
                        <button type="submit" class="btn-primary px-10">
                            Güncelle &rarr;
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
