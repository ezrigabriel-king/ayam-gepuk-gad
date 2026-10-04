@extends('layouts.gad')

@section('content')
{{-- HERO --}}
<section class="bg-gradient-to-br from-red-700 via-red-600 to-amber-500 text-white">
    <div class="max-w-6xl mx-auto px-4 py-12 grid md:grid-cols-2 gap-8 items-center">
        <div>
            <p class="inline-block bg-black/20 px-3 py-1 rounded-full text-xs font-bold tracking-widest">RESTORAN • KUALA LUMPUR • MYR</p>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 leading-tight">Ayam Gepuk GAD<br><span class="text-amber-300">Pedas. Rangup. Gepuk!</span></h1>
            <p class="mt-4 text-amber-100 max-w-md">Nasi Ayam Gepuk dengan sambal tumbuk segar. Pilih hidangan, scan QR untuk order, bayar dengan Cash, DuitNow QR, TNG, GrabPay, Boost, ShopeePay, FPX atau Kad.</p>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#menu" class="px-5 py-3 bg-white text-red-700 rounded-xl font-bold hover:bg-amber-100">Lihat Menu (MYR)</a>
                <a href="#payments" class="px-5 py-3 bg-stone-900 rounded-xl font-bold hover:bg-stone-800">Cara Bayar</a>
            </div>
            <p class="mt-4 text-xs text-amber-200">⏰ {{ $shop['hours'] }} • 📍 {{ $shop['address'] }}</p>
        </div>
        <div class="bg-white text-stone-900 rounded-2xl p-6 shadow-2xl">
            <p class="font-extrabold text-lg">🔥 Paling Laris (MYR)</p>
            <div class="mt-3 flex flex-col gap-3">
                @foreach($items->where('popular', true)->take(4) as $pop)
                    <a href="{{ route('menu.show', $pop['slug']) }}" class="flex items-center justify-between gap-3 p-3 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200">
                        <span class="flex items-center gap-3">
                            <span class="text-2xl">{{ $pop['emoji'] }}</span>
                            <span>
                                <span class="block font-bold text-sm">{{ $pop['name'] }}</span>
                                <span class="block text-xs text-stone-500">{{ $pop['category'] }}</span>
                            </span>
                        </span>
                        <span class="font-extrabold text-red-700 whitespace-nowrap">RM{{ number_format($pop['price'], 2) }}</span>
                    </a>
                @endforeach
            </div>
            <p class="text-xs text-stone-500 mt-3">Klik untuk QR + bayaran setiap hidangan.</p>
        </div>
    </div>
</section>

{{-- MENU --}}
<section id="menu" class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-extrabold">📋 Menu Penuh — Harga MYR Standard</h2>
    <p class="text-sm text-stone-600 mt-1">Setiap hidangan ada QR unik. Scan untuk buka halaman order awam. Klik gambar QR untuk muat turun PNG.</p>

    @foreach($grouped as $category => $list)
        <h3 class="mt-8 mb-4 text-lg font-bold flex items-center gap-2">
            <span class="px-3 py-1 bg-stone-900 text-white rounded-full text-sm">{{ $category }}</span>
            <span class="text-sm font-normal text-stone-500">{{ $list->count() }} item</span>
        </h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($list as $item)
                <article class="bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden flex flex-col">
                    <div class="p-5 flex gap-4">
                        <div class="text-4xl">{{ $item['emoji'] }}</div>
                        <div class="flex-1">
                            <h4 class="font-bold leading-snug">{{ $item['name'] }}</h4>
                            <p class="text-xs text-stone-500 mt-1">{{ $item['desc'] }}</p>
                            <p class="mt-2 font-extrabold text-lg text-red-700">RM{{ number_format($item['price'], 2) }} <span class="text-xs font-normal text-stone-500">MYR</span></p>
                            @if($item['spice'] > 0)
                                <p class="text-xs mt-1">🌶️ Pedas: {{ str_repeat('●', $item['spice']) }}{{ str_repeat('○', 3 - $item['spice']) }}</p>
                            @endif
                        </div>
                    </div>
                    <div class="px-5 pb-4 flex gap-4 items-center bg-amber-50/60 border-t border-amber-100 py-4">
                        <a href="{{ route('menu.qr', $item['slug']) }}" download title="Download QR PNG">
                            <img src="{{ $qrMap[$item['slug']] }}" alt="QR {{ $item['name'] }}" class="w-20 h-20 rounded-lg border border-stone-200 bg-white p-1 hover:scale-105 transition">
                        </a>
                        <div class="flex-1 flex flex-col gap-2">
                            <a href="{{ route('menu.show', $item['slug']) }}" class="text-center px-3 py-2 bg-red-700 text-white rounded-lg text-sm font-bold hover:bg-red-600">Order + QR Bayar</a>
                            <a href="{{ route('menu.qr', $item['slug']) }}" download class="text-center px-3 py-2 bg-white border border-stone-300 rounded-lg text-xs font-semibold hover:bg-stone-100">⬇ Muat Turun QR</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    @endforeach
</section>

{{-- PAYMENTS --}}
<section id="payments" class="bg-stone-900 text-white mt-6">
    <div class="max-w-6xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-extrabold">💳 Kaedah Pembayaran (Malaysia)</h2>
        <p class="text-sm text-stone-400 mt-1">Semua transaksi dalam MYR. Tunjuk QR hidangan anda di kaunter untuk pengesahan.</p>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 mt-6">
            @foreach($payments as $p)
                <div class="bg-stone-800 rounded-2xl p-4 border border-stone-700">
                    <span class="text-[11px] font-bold px-2 py-1 rounded-full bg-amber-400 text-stone-900">{{ $p['badge'] }}</span>
                    <p class="font-bold mt-2">{{ $p['name'] }}</p>
                    <p class="text-xs text-stone-400 mt-1">{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-6 bg-white text-stone-900 rounded-2xl p-5 flex flex-col md:flex-row gap-4 items-start md:items-center">
            <div class="flex-1">
                <p class="font-extrabold">🏦 DuitNow / Bank Transfer (MYR)</p>
                <p class="text-sm mt-1">DuitNow ID: <strong>{{ $shop['duitnow_id'] }}</strong> • Tel: {{ $shop['phone'] }}</p>
                <p class="text-xs text-stone-500 mt-1">Terima semua bank Malaysia via DuitNow QR & FPX. Letak nama hidangan sebagai reference.</p>
            </div>
            <a href="#qr" class="px-4 py-2 bg-red-700 text-white rounded-lg font-bold text-sm">Lihat QR Hidangan ↓</a>
        </div>
    </div>
</section>

{{-- QR WALL --}}
<section id="qr" class="max-w-6xl mx-auto px-4 py-10">
    <h2 class="text-2xl font-extrabold">📷 Dinding QR — Scan Setiap Hidangan</h2>
    <p class="text-sm text-stone-600 mt-1">Cetak halaman ini & tampal di meja. Setiap QR membuka URL awam hidangan tersebut (bukan localhost).</p>
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-5">
        @foreach($items as $item)
            <a href="{{ route('menu.show', $item['slug']) }}" class="bg-white border border-stone-200 rounded-2xl p-4 text-center hover:shadow-lg hover:border-red-300">
                <img src="{{ $qrMap[$item['slug']] }}" alt="QR {{ $item['name'] }}" class="w-32 h-32 mx-auto rounded-lg">
                <p class="text-xs font-bold mt-2 leading-tight">{{ $item['name'] }}</p>
                <p class="text-xs text-red-700 font-extrabold">RM{{ number_format($item['price'], 2) }}</p>
            </a>
        @endforeach
    </div>
</section>
@endsection
