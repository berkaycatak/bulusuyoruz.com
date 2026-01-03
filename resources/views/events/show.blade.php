<x-layouts.app :title="$viewModel->event->title">
    <div class="py-12">
        <div class="max-w-4xl mx-auto px-6">
            <div class="mb-6 text-center">
                 <h1 class="font-bold text-2xl text-slate-800">
                    {{ $viewModel->event->title }}
                </h1>
            </div>

            <div class="grid gap-6">
                <!-- Global Info Badge (Visible to All) -->
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-slate-600 text-sm font-medium bg-slate-50 p-4 rounded-xl inline-flex mx-auto border border-slate-200 mb-6">
                    <div class="flex items-center gap-2">
                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary">
                          <rect width="18" height="18" x="3" y="4" rx="2" ry="2"/>
                          <line x1="16" x2="16" y1="2" y2="6"/>
                          <line x1="8" x2="8" y1="2" y2="6"/>
                          <line x1="3" x2="21" y1="10" y2="10"/>
                        </svg>
                        {{ $viewModel->formattedDateRange() }}
                    </div>
                    <div class="hidden sm:block text-slate-300">|</div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary">
                          <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/>
                          <circle cx="12" cy="10" r="3"/>
                        </svg>
                        {{ $viewModel->event->location_mode === 'common' ? 'Ortak Konum' : 'Öneri Konum' }}
                    </div>
                </div>

                @if($viewModel->isOwner())
                    <!-- Status/Summary Card (Owner Only) -->
                    <div class="glass p-8 rounded-2xl text-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-green-500"></div>
                        
                        @if(session('success'))
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-green-600">
                              <path d="M20 6 9 17l-5-5"/>
                            </svg>
                        </div>

                        <h1 class="text-3xl font-bold text-slate-900 mb-2">Harika! 🎉</h1>
                        <p class="text-slate-600 mb-8 max-w-lg mx-auto">
                            Etkinliğin başarıyla oluşturuldu. Şimdi arkadaşlarınla paylaş ve ne zaman buluşacağınıza karar verin.
                        </p>
                        @else
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-primary">
                              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                            </svg>
                        </div>

                        <h1 class="text-3xl font-bold text-slate-900 mb-2">Etkinlik Durumu 📊</h1>
                        <p class="text-slate-600 mb-8 max-w-lg mx-auto">
                            Katılımcıların durumunu buradan takip edebilirsin. Henüz paylaşmadıysan linki göndererek arkadaşlarını davet et.
                        </p>
                        @endif
                    </div>

                    <!-- Owner Actions: Share Link -->
                    <div class="glass p-8 rounded-2xl">
                        <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary">
                              <circle cx="18" cy="5" r="3"/>
                              <circle cx="6" cy="12" r="3"/>
                              <circle cx="18" cy="19" r="3"/>
                              <line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/>
                              <line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/>
                            </svg>
                            Paylaşma Linki
                        </h3>
                        <p class="text-slate-600 text-sm mb-4">Bu linki arkadaşlarına göndererek etkinliğe katılmalarını sağla.</p>
                        
                        <div class="flex items-center gap-2" x-data="{ copied: false }">
                            <input type="text" readonly value="{{ $viewModel->shareUrl() }}" class="input-field bg-white text-slate-500 select-all" />
                            <button @click="navigator.clipboard.writeText('{{ $viewModel->shareUrl() }}'); copied = true; setTimeout(() => copied = false, 2000)" 
                                    class="btn-primary py-3 px-6 whitespace-nowrap min-w-[140px]">
                                <span x-show="!copied" class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                      <rect width="14" height="14" x="8" y="8" rx="2" ry="2"/>
                                      <path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>
                                    </svg> 
                                    Kopyala
                                </span>
                                <span x-show="copied" class="flex items-center gap-2" x-cloak>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                      <path d="M20 6 9 17l-5-5"/>
                                    </svg> 
                                    Kopyalandı
                                </span>
                            </button>
                        </div>
                    </div>

                    <!-- Responses Section (Owner View) -->
                    <div class="glass p-8 rounded-2xl">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5 text-primary">
                                  <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                  <circle cx="9" cy="7" r="4"/>
                                  <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                                  <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                                </svg>
                                Katılımcılar
                            </h3>
                            <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold">
                                {{ $viewModel->responsesCount() }} Yanıt
                            </span>
                        </div>

                        @if($viewModel->responsesCount() > 0)
                            <div class="space-y-4">
                                @foreach($viewModel->event->responses as $response)
                                    <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center text-slate-500 font-bold">
                                                {{ substr($response->user ? $response->user->name : ($response->ip_address ?? 'A'), 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900">{{ $response->user ? $response->user->name : 'Anonim Katılımcı' }}</div>
                                                <div class="text-xs text-slate-500">{{ $response->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <div class="bg-slate-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-8 h-8">
                                      <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                                      <circle cx="9" cy="7" r="4"/>
                                      <line x1="17" x2="22" y1="8" y2="13"/>
                                      <line x1="22" x2="17" y1="8" y2="13"/>
                                    </svg>
                                </div>
                                <p class="text-slate-500 font-medium">Henüz kimse katılmadı.</p>
                                <p class="text-slate-400 text-sm mt-1">Link paylaşarak arkadaşlarını davet et!</p>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex justify-center mt-4">
                         <!-- Owner can also participate if they want, but hidden by default to keep clean -->
                         <a href="{{ route('events.participate', ['event' => $viewModel->event->slug]) }}" class="text-primary hover:underline text-sm font-medium">
                            Kendin de yanıt eklemek ister misin?
                        </a>
                    </div>

                @else
                    <!-- NON-OWNER VIEW: Embedded Participation Wizard -->
                   @include('events.partials.participate-form')
                @endif

            </div>
        </div>
    </div>
</x-layouts.app>
