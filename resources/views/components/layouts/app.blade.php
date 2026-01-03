<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Buluşuyoruz' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 text-slate-800 antialiased min-h-screen flex flex-col relative overflow-x-hidden">

    <!-- Decorative Gradient Background -->
    <div class="fixed inset-0 z-[-1] overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-blue-100 rounded-full blur-[120px] opacity-60"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-green-100 rounded-full blur-[120px] opacity-60"></div>
    </div>

    <!-- Navigation (Unified) -->
    <x-navbar />

    <!-- Main Content -->
    <main class="flex-grow w-full max-w-7xl mx-auto px-6 py-8 md:px-12 z-10">
        {{ $slot }}
    </main>

    <!-- Footer (Minimal) -->
    <footer class="w-full py-8 text-center text-slate-400 text-sm mt-auto z-10">
        &copy; {{ date('Y') }} Buluşuyoruz. Basit ve Hızlı.
    </footer>

</body>
</html>
