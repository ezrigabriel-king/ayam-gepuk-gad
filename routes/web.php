<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/qr/pay/{slug}.png', [MenuController::class, 'qrPayment'])->name('menu.qr.pay');
Route::get('/qr/{slug}.png', [MenuController::class, 'qr'])->name('menu.qr');
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show');
