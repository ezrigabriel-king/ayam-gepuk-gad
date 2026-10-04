<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Ayam Gepuk GAD — Menu' }}</title>
    <meta name="description" content="Ayam Gepuk GAD — Nasi Ayam Gepuk menu with MYR prices, payment methods and QR codes per dish.">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-amber-50 text-stone-900 min-h-screen">
    <header class="bg-red-700 text-white sticky top-0 z-50 shadow-lg">
        <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between gap-4">
            <a href="{{ route('menu.index') }}" class="flex items-center gap-3">
                <span class="text-3xl">🍗</span>
                <span>
                    <span class="block font-extrabold text-lg leading-tight tracking-tight">AYAM GEPUK GAD</span>
                    <span class="block text-xs text-amber-200">Sedap Giler • MYR Prices • QR Order</span>
                </span>
            </a>
            <nav class="flex items-center gap-2 text-sm">
                <a href="{{ route('menu.index') }}#menu" class="hidden sm:inline-block px-3 py-2 rounded-lg hover:bg-red-600 font-semibold">Menu</a>
                <a href="{{ route('menu.index') }}#payments" class="hidden sm:inline-block px-3 py-2 rounded-lg hover:bg-red-600 font-semibold">Bayaran</a>
                <a href="{{ route('menu.index') }}#qr" class="px-4 py-2 bg-amber-400 text-stone-900 rounded-lg font-bold hover:bg-amber-300">Scan & Order</a>
            </nav>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-stone-900 text-stone-300 mt-12">
        <div class="max-w-6xl mx-auto px-4 py-10 grid sm:grid-cols-3 gap-8">
            <div>
                <p class="font-extrabold text-white text-lg">AYAM GEPUK GAD</p>
                <p class="text-sm mt-2">{{ config('gad.shop.address') }}</p>
                <p class="text-sm mt-1">{{ config('gad.shop.hours') }}</p>
                <p class="text-sm mt-1">📞 {{ config('gad.shop.phone') }}</p>
            </div>
            <div>
                <p class="font-bold text-white">Bayaran Diterima (MYR)</p>
                <ul class="text-sm mt-2 flex flex-col gap-1">
                    @foreach(config('gad.payments', []) as $p)
                        <li>• {{ $p['name'] }}</li>
                    @endforeach
                </ul>
            </div>
            <div>
                <p class="font-bold text-white">Nota</p>
                <p class="text-sm mt-2">Semua harga dalam Ringgit Malaysia (MYR), termasuk SST di mana berkenaan. QR setiap hidangan membuka halaman item awam untuk order & bayaran.</p>
                <p class="text-xs mt-3 text-stone-500">DuitNow demo ID: {{ config('gad.shop.duitnow_id') }} — tukar dalam config/gad.php / .env GAD_DUITNOW_ID</p>
            </div>
        </div>
        <div class="border-t border-stone-800 py-4 text-center text-xs">© {{ date('Y') }} Ayam Gepuk GAD • Made with 🔥 in Malaysia</div>
    </footer>
</body>
</html>
