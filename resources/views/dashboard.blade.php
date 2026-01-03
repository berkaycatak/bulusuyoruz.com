<x-layouts.app title="Dashboard">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="glass p-8 rounded-2xl">
                <div class="p-6 text-slate-800">
                    <h1 class="text-2xl font-bold mb-4">Hoş geldin, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-slate-600">Etkinliklerini buradan yönetebilirsin.</p>
                    
                    <div class="mt-8">
                         <a href="{{ route('events.create') }}" class="btn-primary">
                            Yeni Etkinlik Oluştur
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
