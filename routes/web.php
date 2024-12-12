<?php

declare(strict_types=1);

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SendMoneyController;
use App\Models\Wallet;
use App\Notifications\BalanceIsLow;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');
    Route::post('/send-money', [SendMoneyController::class, '__invoke'])->name('send-money');
});

require __DIR__.'/auth.php';

Route::get('/notification', function () {
    // tom's id
    $wallet = Wallet::find(3);

    return (new BalanceIsLow($wallet))->toMail();
});
