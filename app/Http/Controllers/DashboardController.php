<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Notifications\BalanceIsLow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class DashboardController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $wallet = $user->wallet()->getModel();

        $transactions = $wallet->transactions()->with('transfer')->orderByDesc('id')->get();
        $balance = $user->wallet->balance;

        if ($balance < 1000) {
            Notification::sendNow($user, new BalanceIsLow($wallet));
        }

        return view('dashboard', compact('transactions', 'balance'));
    }
}
