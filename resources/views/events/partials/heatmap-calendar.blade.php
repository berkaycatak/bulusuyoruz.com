<div x-data="{ 
    startDate: new Date('{{ $viewModel->event->start_date->format('Y-m-d') }}'),
    endDate: new Date('{{ $viewModel->event->end_date->format('Y-m-d') }}'),
    
    // Processed stats from backend
    stats: {{ json_encode($viewModel->getResponseDateStats()) }},

    getDateInfo(dayIndex) {
        const date = new Date(this.startDate.getTime() + dayIndex * 86400000);
        return {
            date: date,
            dateStr: date.toISOString().split('T')[0],
            dayOfWeek: date.getDay(),
            dayNum: date.getDate(),
            monthShort: date.toLocaleDateString('tr-TR', { month: 'short' })
        };
    },

    get daysDifference() {
        if(!this.startDate || !this.endDate) return 0;
        const diffTime = Math.abs(this.endDate - this.startDate);
        return Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1; 
    },
    
    getWeeks() {
        const weeks = [];
        let currentWeek = [null, null, null, null, null, null, null];
        
        // Days difference logic from original calendar
        const diff = this.daysDifference;

        for (let i = 0; i < diff; i++) {
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
    },

    getColorClass(dateStr) {
        const count = this.stats.counts[dateStr] || 0;
        const max = this.stats.max;
        
        if (count === 0) return 'bg-white border-slate-100/50 text-slate-300';
        
        const intensity = max > 0 ? count / max : 0;

        if (intensity >= 0.75) return 'bg-green-500 border-green-600 text-white shadow-md shadow-green-200';
        if (intensity >= 0.5) return 'bg-green-400 border-green-500 text-white'; 
        if (intensity >= 0.25) return 'bg-green-300 border-green-400 text-white';
        
        if (intensity >= 0.8) return 'bg-emerald-500 border-emerald-600 text-white shadow-lg shadow-emerald-200 scale-105 z-10';
        if (intensity >= 0.6) return 'bg-emerald-400 border-emerald-400 text-white'; 
        if (intensity >= 0.4) return 'bg-yellow-400 border-yellow-400 text-white';
        
        return 'bg-red-400 border-red-400 text-white opacity-90';
    }

}">
    <div class="glass rounded-2xl p-6 md:p-8 h-full">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Tarih Yoğunluk Haritası
                </h3>
                <p class="text-slate-500 text-sm mt-1">Katılımcıların en çok tercih ettiği tarihler.</p>
            </div>
            
            <!-- Legend -->
            <div class="flex items-center gap-3 text-xs font-medium bg-white/50 px-3 py-2 rounded-lg border border-white/40">
                <div class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded bg-red-400"></span>
                    <span class="text-slate-600">Düşük</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded bg-yellow-400"></span>
                    <span class="text-slate-600">Orta</span>
                </div>
                <div class="flex items-center gap-1">
                    <span class="w-3 h-3 rounded bg-emerald-500"></span>
                    <span class="text-slate-600">Yüksek</span>
                </div>
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
                                <div class="w-full aspect-square rounded-lg flex flex-col items-center justify-center transition-all duration-200 border text-sm relative group cursor-default"
                                     :class="getColorClass(day.dateStr)">
                                    
                                    <!-- Day Number -->
                                    <span class="font-bold text-base leading-tight" x-text="day.dayNum"></span>
                                    
                                    <!-- Vote Count Badge (Only if > 0) -->
                                    <template x-if="stats.counts[day.dateStr] > 0">
                                        <div class="mt-1 flex items-center gap-0.5 text-[10px] font-bold bg-black/10 px-1.5 py-0.5 rounded-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            <span x-text="stats.counts[day.dateStr]"></span>
                                        </div>
                                    </template>
                                    
                                    <!-- No votes indicator -->
                                    <template x-if="!stats.counts[day.dateStr]">
                                        <span class="text-[10px] opacity-40">-</span>
                                    </template>

                                </div>
                            </template>
                            <template x-if="day === null">
                                <div class="w-full aspect-square"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </template>
        </div>
    </div>
</div>
