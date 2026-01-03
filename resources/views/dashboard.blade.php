<x-layouts.app title="Dashboard">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass p-8 rounded-2xl">
                <div class="p-6 text-slate-800">
                    <h1 class="text-2xl font-bold mb-4">Hoş geldin, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-slate-600">Etkinliklerini buradan yönetebilirsin.</p>
                    
                    <div class="flex items-center justify-between mt-8 mb-6">
                        <h2 class="text-lg font-bold text-slate-800">Etkinliklerim</h2>
                        <a href="{{ route('events.create') }}" class="btn-primary py-2 px-4 text-sm">
                            + Yeni Etkinlik
                        </a>
                    </div>

                    @if($events->count() > 0)
                        <div class="grid gap-4">
                            @foreach($events as $event)
                                <div class="bg-white p-6 rounded-xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                    <div>
                                        <h3 class="font-bold text-lg text-slate-900 mb-1">
                                            <a href="{{ route('events.show', $event->slug) }}" class="hover:text-primary transition-colors">
                                                {{ $event->title }}
                                            </a>
                                        </h3>
                                        <div class="flex items-center gap-4 text-sm text-slate-500">
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                {{ $event->start_date->translatedFormat('d F') }} - {{ $event->end_date->translatedFormat('d F') }}
                                            </div>
                                            <div class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                </svg>
                                                {{ $event->responses->count() }} Katılımcı
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('events.edit', $event->slug) }}" class="text-slate-400 hover:text-slate-600 p-2 rounded-lg hover:bg-slate-50 transition-colors" title="Düzenle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('events.show', $event->slug) }}" class="btn-secondary py-2 px-4 text-sm whitespace-nowrap">
                                            Görüntüle &rarr;
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="mt-8 text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                             <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                             </div>
                             <h3 class="text-lg font-medium text-slate-900 mb-1">Henüz etkinlik oluşturmadın</h3>
                             <p class="text-slate-500 mb-6 max-w-sm mx-auto">Arkadaşlarınla buluşmak için hemen yeni bir etkinlik planla.</p>
                             <a href="{{ route('events.create') }}" class="btn-primary">
                                Yeni Etkinlik Oluştur
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
