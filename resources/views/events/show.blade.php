<x-layouts.app :title="$viewModel->event->title">
    <div class="py-8 md:py-12">
        <div class="max-w-5xl mx-auto px-4">
            
            <!-- Hero Header -->
            <div class="relative mb-8">
                <div class="glass rounded-3xl p-8 md:p-10 relative overflow-hidden">
                    <!-- Decorative Background -->
                    <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-transparent to-secondary/5"></div>
                    <div class="absolute top-0 right-0 w-48 h-48 bg-gradient-to-br from-primary/10 to-transparent rounded-full blur-3xl"></div>
                    
                    <div class="relative">
                        <!-- Status Badge -->
                        @if($viewModel->event->status === 'completed')
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white text-sm font-bold mb-4 shadow-lg shadow-teal-500/25">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Planlandı
                        </div>
                        @else
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-bold mb-4">
                            <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                            Aktif
                        </div>
                        @endif

                        <!-- Title -->
                        <h1 class="text-3xl md:text-4xl font-extrabold text-slate-900 mb-4">
                            {{ $viewModel->event->title }}
                        </h1>
                        
                        <!-- Event Meta -->
                        <div class="flex flex-wrap items-center gap-4 text-slate-600">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $viewModel->formattedDateRange() }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-green-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $viewModel->event->location_mode === 'common' ? 'Ortak Konum' : 'Öneri Konum' }}</span>
                            </div>
                            @if($viewModel->isOwner())
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <span class="font-medium">{{ $viewModel->responsesCount() }} Katılımcı</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            @if($viewModel->isOwner())
                {{-- ==================== OWNER VIEW ==================== --}}
                
                @if($viewModel->event->status === 'completed' && $viewModel->event->result)
                    {{-- COMPLETED STATE --}}
                    
                    <!-- AI Result Card -->
                    @include('events.partials.ai-result-card')

                    <!-- Owner Actions Panel -->
                    <div class="mt-6 glass rounded-2xl p-6" x-data="{ 
                        recalcLoading: false, 
                        reactivateLoading: false,
                        showRecalcConfirm: false,
                        showReactivateConfirm: false
                    }">
                        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                            <div>
                                <h3 class="font-bold text-slate-900">Başka bir planın mı var?</h3>
                                <p class="text-sm text-slate-500">Sonucu güncelleyebilir veya yeni yanıtlar alabilirsin.</p>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap justify-center">
                                <!-- Recalculate Button -->
                                <button @click="showRecalcConfirm = true"
                                        :disabled="recalcLoading"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-teal-600 bg-teal-50 hover:bg-teal-100 py-2.5 px-5 rounded-xl transition-all border border-teal-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    <span x-show="!recalcLoading">Tekrar Hesapla</span>
                                    <span x-show="recalcLoading" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        Hesaplanıyor...
                                    </span>
                                </button>

                                <!-- Reactivate Button -->
                                <button @click="showReactivateConfirm = true"
                                        :disabled="reactivateLoading"
                                        class="inline-flex items-center gap-2 text-sm font-semibold text-amber-600 bg-amber-50 hover:bg-amber-100 py-2.5 px-5 rounded-xl transition-all border border-amber-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    <span x-show="!reactivateLoading">Yanıt Al</span>
                                    <span x-show="reactivateLoading">Açılıyor...</span>
                                </button>

                                <!-- Edit Button -->
                                <a href="{{ route('events.edit', $viewModel->event->slug) }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-slate-700 py-2.5 px-5 rounded-xl transition-all hover:bg-slate-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Düzenle
                                </a>
                            </div>
                        </div>

                        <!-- Recalculate Confirmation Modal -->
                        <template x-teleport="body">
                            <div x-show="showRecalcConfirm" x-cloak 
                                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
                                 x-transition>
                                <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4" @click.away="showRecalcConfirm = false">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-teal-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-slate-900 mb-2">Konumu Tekrar Hesapla?</h4>
                                        <p class="text-slate-500 mb-6">Yapay zeka mevcut yanıtları yeniden analiz edecek.</p>
                                        <div class="flex gap-3">
                                            <button @click="showRecalcConfirm = false" class="flex-1 py-3 px-4 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition-colors">İptal</button>
                                            <form action="{{ route('events.finalize', $viewModel->event->slug) }}" method="POST" class="flex-1" @submit="recalcLoading = true; showRecalcConfirm = false">
                                                @csrf
                                                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-teal-500 text-white font-bold hover:bg-teal-600 transition-colors">Evet, Hesapla</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Reactivate Confirmation Modal -->
                        <template x-teleport="body">
                            <div x-show="showReactivateConfirm" x-cloak 
                                 class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
                                 x-transition>
                                <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4" @click.away="showReactivateConfirm = false">
                                    <div class="text-center">
                                        <div class="w-16 h-16 bg-amber-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                            </svg>
                                        </div>
                                        <h4 class="text-xl font-bold text-slate-900 mb-2">Yanıt Almaya Devam Et?</h4>
                                        <p class="text-slate-500 mb-6">Etkinlik tekrar aktif olacak ve yeni yanıtlar alabileceksin.</p>
                                        <div class="flex gap-3">
                                            <button @click="showReactivateConfirm = false" class="flex-1 py-3 px-4 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition-colors">İptal</button>
                                            <form action="{{ route('events.reactivate', $viewModel->event->slug) }}" method="POST" class="flex-1" @submit="reactivateLoading = true; showReactivateConfirm = false">
                                                @csrf
                                                <button type="submit" class="w-full py-3 px-4 rounded-xl bg-amber-500 text-white font-bold hover:bg-amber-600 transition-colors">Evet, Aktif Et</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                @else
                    {{-- ACTIVE STATE --}}
                    
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Column -->
                        <div class="lg:col-span-2 space-y-6">
                            
                            <!-- AI Finalize Card -->
                            @if($viewModel->responsesCount() > 0)
                            <div class="glass rounded-2xl p-6 md:p-8 relative overflow-hidden" x-data="{ loading: false }">
                                <div class="absolute inset-0 bg-gradient-to-br from-teal-500/5 to-emerald-500/5"></div>
                                <div class="relative">
                                    <div class="flex items-start gap-4 mb-6">
                                        <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-teal-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-teal-500/25 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-xl font-bold text-slate-900">Yapay Zeka Hazır</h3>
                                            <p class="text-slate-600">{{ $viewModel->responsesCount() }} katılımcının tercihlerini analiz edebilirsin.</p>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('events.finalize', $viewModel->event->slug) }}" method="POST" @submit="loading = true">
                                        @csrf
                                        <button type="submit" 
                                                :disabled="loading"
                                                :class="{ 'opacity-75 cursor-wait': loading }"
                                                class="w-full bg-gradient-to-r from-teal-500 to-emerald-500 text-white font-bold py-4 px-8 rounded-xl shadow-lg shadow-teal-500/25 hover:shadow-xl hover:shadow-teal-500/30 transition-all flex items-center justify-center gap-3">
                                            <template x-if="!loading">
                                                <span class="flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                    </svg>
                                                    Yapay Zeka ile Planla
                                                </span>
                                            </template>
                                            <template x-if="loading">
                                                <span class="flex items-center gap-2">
                                                    <svg class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                                    Analiz Ediliyor...
                                                </span>
                                            </template>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif

                            <!-- Participants List -->
                            <div class="glass rounded-2xl p-6 md:p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                        </svg>
                                        Katılımcılar
                                    </h3>
                                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-primary/10 text-primary">
                                        {{ $viewModel->responsesCount() }} Yanıt
                                    </span>
                                </div>

                                @if($viewModel->responsesCount() > 0)
                                    <div class="space-y-3">
                                        @foreach($viewModel->event->responses as $response)
                                            <div class="bg-white/60 hover:bg-white p-4 rounded-xl border border-slate-100 transition-colors" 
                                                 x-data="{ showDeleteConfirm: false }">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 bg-gradient-to-br from-primary/20 to-secondary/20 rounded-full flex items-center justify-center text-primary font-bold text-sm flex-shrink-0">
                                                        {{ strtoupper(substr($response->user ? $response->user->name : 'A', 0, 1)) }}
                                                    </div>
                                                    <div class="flex-1 min-w-0">
                                                        <div class="font-semibold text-slate-900 truncate">{{ $response->user ? $response->user->name : 'Anonim Katılımcı' }}</div>
                                                        <div class="text-xs text-slate-500">{{ $response->created_at->diffForHumans() }}</div>
                                                    </div>
                                                    <!-- Delete Button -->
                                                    <button @click="showDeleteConfirm = true" 
                                                            class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                            title="Yanıtı Sil">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <div class="mt-3 pt-3 border-t border-slate-100 grid gap-2 text-sm">
                                                    @if($response->province && $response->district)
                                                    <div class="flex items-center gap-2 text-slate-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        </svg>
                                                        <span>{{ $response->province->name }} / {{ $response->district->name }}</span>
                                                    </div>
                                                    @endif
                                                    <div class="flex items-center gap-2 text-slate-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span>{{ $viewModel->formatResponseDates($response) }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-2 text-slate-600">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <span>{{ $viewModel->formatResponseTimes($response) }}</span>
                                                    </div>
                                                </div>

                                                <!-- Delete Confirmation Modal -->
                                                <template x-teleport="body">
                                                    <div x-show="showDeleteConfirm" x-cloak 
                                                         class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/50 backdrop-blur-sm"
                                                         x-transition>
                                                        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md mx-4" @click.away="showDeleteConfirm = false">
                                                            <div class="text-center">
                                                                <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                                    </svg>
                                                                </div>
                                                                <h4 class="text-xl font-bold text-slate-900 mb-2">Yanıtı Sil?</h4>
                                                                <p class="text-slate-500 mb-6">
                                                                    <strong>{{ $response->user ? $response->user->name : 'Anonim Katılımcı' }}</strong> kullanıcısının yanıtını silmek istediğinize emin misiniz?
                                                                </p>
                                                                <div class="flex gap-3">
                                                                    <button @click="showDeleteConfirm = false" class="flex-1 py-3 px-4 rounded-xl border border-slate-200 text-slate-600 font-medium hover:bg-slate-50 transition-colors">İptal</button>
                                                                    <form action="{{ route('events.responses.destroy', [$viewModel->event->slug, $response->id]) }}" method="POST" class="flex-1">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="w-full py-3 px-4 rounded-xl bg-red-500 text-white font-bold hover:bg-red-600 transition-colors">Evet, Sil</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </template>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-10">
                                        <div class="w-20 h-20 bg-slate-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                        </div>
                                        <p class="text-slate-600 font-medium">Henüz kimse katılmadı</p>
                                        <p class="text-slate-400 text-sm mt-1">Linki paylaşarak arkadaşlarını davet et!</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Sidebar -->
                        <div class="space-y-6">
                            <!-- Share Link Card -->
                            <div class="glass rounded-2xl p-6">
                                <h3 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                                    </svg>
                                    Paylaş
                                </h3>
                                <p class="text-sm text-slate-500 mb-4">Bu linki arkadaşlarına gönder.</p>
                                
                                <div class="space-y-3" x-data="{ copied: false }">
                                    <input type="text" readonly value="{{ $viewModel->shareUrl() }}" class="input-field bg-white text-slate-600 text-sm select-all" />
                                    <button @click="navigator.clipboard.writeText('{{ $viewModel->shareUrl() }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                            class="btn-primary w-full py-3 justify-center">
                                        <span x-show="!copied" class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                            </svg>
                                            Linki Kopyala
                                        </span>
                                        <span x-show="copied" x-cloak class="flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                            </svg>
                                            Kopyalandı!
                                        </span>
                                    </button>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="glass rounded-2xl p-6">
                                <h3 class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-4">Hızlı İşlemler</h3>
                                <div class="space-y-2">
                                    <a href="{{ route('events.edit', $viewModel->event->slug) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/60 transition-colors text-slate-600 hover:text-slate-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        <span class="font-medium">Etkinliği Düzenle</span>
                                    </a>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-white/60 transition-colors text-slate-600 hover:text-slate-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                        <span class="font-medium">Ana Sayfaya Dön</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            @else
                {{-- ==================== NON-OWNER VIEW ==================== --}}
                
                @if($viewModel->event->status === 'completed' && $viewModel->event->result)
                    @include('events.partials.ai-result-card')
                @else
                    @include('events.partials.participate-form')
                @endif
            @endif

        </div>
    </div>
</x-layouts.app>
