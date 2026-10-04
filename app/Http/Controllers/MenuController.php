<?php

namespace App\Http\Controllers;

use App\Services\MenuQrService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class MenuController extends Controller
{
    public function index(MenuQrService $qr): View
    {
        $items = collect(config('gad.menu', []));
        $payments = config('gad.payments', []);
        $shop = config('gad.shop');

        $grouped = $items->groupBy('category');

        $qrMap = [];
        foreach ($items as $item) {
            $qrMap[$item['slug']] = $qr->dataUri($qr->itemPayload($item), 260);
        }

        return view('menu.index', [
            'shop' => $shop,
            'grouped' => $grouped,
            'items' => $items,
            'payments' => $payments,
            'qrMap' => $qrMap,
        ]);
    }

    public function show(string $slug, MenuQrService $qr): View
    {
        $item = $qr->findItem($slug);

        abort_if(! $item, 404, 'Menu item not found.');

        $shop = config('gad.shop');
        $payments = config('gad.payments', []);

        $itemUrl = $qr->itemPayload($item);
        $paymentText = $qr->paymentPayload($item);

        return view('menu.show', [
            'shop' => $shop,
            'item' => $item,
            'payments' => $payments,
            'itemQr' => $qr->dataUri($itemUrl, 320),
            'itemUrl' => $itemUrl,
            'paymentText' => $paymentText,
            'paymentQr' => $qr->dataUri($paymentText, 320),
        ]);
    }

    public function qr(string $slug, MenuQrService $qr): Response
    {
        $item = $qr->findItem($slug);

        abort_if(! $item, 404);

        $png = $qr->png($qr->itemPayload($item), 400);

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="gad-'.$slug.'-qr.png"',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    public function qrPayment(string $slug, MenuQrService $qr): Response
    {
        $item = $qr->findItem($slug);

        abort_if(! $item, 404);

        $png = $qr->png($qr->paymentPayload($item), 400);

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="gad-'.$slug.'-pay-qr.png"',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
