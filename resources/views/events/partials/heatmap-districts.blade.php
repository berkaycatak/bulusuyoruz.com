<div x-data="{ 
    stats: {{ json_encode($viewModel->getResponseDistrictStats()) }},
    expanded: false,
    
    getColorClass(count) {
        if (count === 0) return 'bg-slate-100 text-slate-400';
        
        const max = this.stats.max;
        const intensity = max > 0 ? count / max : 0;

        if (intensity >= 0.75) return 'bg-emerald-500 text-white';
        if (intensity >= 0.5) return 'bg-green-500 text-white'; 
        if (intensity >= 0.25) return 'bg-yellow-400 text-white';
        
        return 'bg-red-400 text-white';
    },
    
    getWidthPercent(count) {
        const max = this.stats.max;
        return max > 0 ? (count / max) * 100 : 0;
    }
}">
    <div class="glass rounded-2xl overflow-hidden transition-all duration-300" :class="expanded ? 'p-6 md:p-8' : 'p-4 hover:bg-white/60'">
        <button @click="expanded = !expanded" class="w-full flex items-center justify-between group">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-50 rounded-lg text-primary group-hover:bg-blue-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h3 class="text-lg font-bold text-slate-900">İlçe Yoğunluk Haritası</h3>
                    <p class="text-slate-500 text-sm" x-show="!expanded">Görüntülemek için tıklayın</p>
                    <p class="text-slate-500 text-sm" x-show="expanded">Katılımcıların en çok tercih ettiği konumlar.</p>
                </div>
            </div>
            <div class="text-slate-400 group-hover:text-primary transition-colors">
                 <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </button>

        <div x-show="expanded" x-collapse>
            <div class="mt-6 space-y-4 pt-6 border-t border-slate-100">
                <template x-for="item in stats.items" :key="item.id">
                    <div class="relative">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-slate-700" x-text="item.name"></span>
                            <span class="text-sm font-bold text-slate-900" x-text="item.count + ' kişi'"></span>
                        </div>
                        
                        <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500 ease-out flex items-center justify-end pr-1"
                                 :style="'width: ' + getWidthPercent(item.count) + '%'"
                                 :class="getColorClass(item.count)">
                            </div>
                        </div>
                    </div>
                </template>
                
                <template x-if="stats.items.length === 0">
                    <div class="text-center py-6 text-slate-400">
                        Henüz konum tercihi yapılmamış.
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
