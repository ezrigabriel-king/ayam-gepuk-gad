@extends('layouts.gad')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <a href="{{ route('menu.index') }}" class="text-sm font-semibold text-red-700 hover:underline">← Kembali ke Menu</a>

    <div class="mt-4 bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden">
        <div class="p-6 md:p-8 grid md:grid-cols-2 gap-8">
            <div>
                <p class="text-5xl">{{ $item['emoji'] }}</p>
                <p class="mt-2 inline-block text-xs font-bold px-2 py-1 bg-stone-900 text-white rounded-full">{{ $item['category'] }}</p>
                <h1 class="text-3xl font-extrabold mt-2 leading-tight">{{ $item['name'] }}</h1>
                <p class="text-sm text-stone-600 mt-2">{{ $item['desc'] }}</p>
                <p class="mt-4 text-4xl font-extrabold text-red-700">RM{{ number_format($item['price'], 2) }} <span class="text-sm font-normal text-stone-500">MYR</span></p>

                <div class="mt-5 bg-amber-50 border border-amber-200 rounded-xl p-4">
                    <p class="text-xs font-bold tracking-wide text-stone-500">ORDER URL (public — kongsi / cetak):</p>
                    <p class="text-sm font-mono break-all mt-1 text-stone-800">{{ $itemUrl }}</p>
                </div>

                <h2 class="font-extrabold mt-6 mb-3">💳 Bayar Cara Malaysia (MYR)</h2>
                <div class="flex flex-col gap-2">
                    @foreach($payments as $p)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-stone-50 border border-stone-200">
                            <span class="text-[10px] font-bold px-2 py-1 rounded-full bg-stone-900 text-white whitespace-nowrap mt-0.5">{{ $p['badge'] }}</span>
                            <span>
                                <span class="block text-sm font-bold">{{ $p['name'] }}</span>
                                <span class="block text-xs text-stone-500">{{ $p['desc'] }}</span>
                            </span>
                        </div>
                    @endforeach
                </div>
                <p class="text-xs text-stone-500 mt-3">DuitNow ID kedai: <strong>{{ $shop['duitnow_id'] }}</strong> • Rujukan: {{ $item['slug'] }}-RM{{ number_format($item['price'], 2) }}</p>
            </div>

            <div class="flex flex-col gap-5">
                <div class="bg-stone-900 text-white rounded-2xl p-5 text-center">
                    <p class="font-bold text-sm">📷 QR HIDANGAN — scan untuk buka halaman ini</p>
                    <img src="{{ $itemQr }}" alt="QR order {{ $item['name'] }}" class="w-64 h-64 mx-auto mt-3 rounded-xl bg-white p-2">
                    <div class="mt-3 flex gap-2 justify-center">
                        <a href="{{ route('menu.qr', $item['slug']) }}" download class="px-4 py-2 bg-amber-400 text-stone-900 rounded-lg text-sm font-bold">⬇ QR Order (PNG)</a>
                    </div>
                </div>

                <div class="bg-red-700 text-white rounded-2xl p-5 text-center">
                    <p class="font-bold text-sm">💰 QR BAYARAN — RM{{ number_format($item['price'], 2) }} MYR</p>
                    <img src="{{ $paymentQr }}" alt="QR bayar {{ $item['name'] }}" class="w-64 h-64 mx-auto mt-3 rounded-xl bg-white p-2">
                    <p class="text-xs mt-2 text-amber-200 font-mono break-all">{{ $paymentText }}</p>
                    <div class="mt-3 flex gap-2 justify-center">
                        <a href="{{ route('menu.qr.pay', $item['slug']) }}" download class="px-4 py-2 bg-white text-red-700 rounded-lg text-sm font-bold">⬇ QR Bayar (PNG)</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
