<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController
{
    public function __invoke(Request $request)
    {
        $user = $request->user();
        $wallet = $user->wallet()->getModel();

        $transactions = $wallet->transactions()->with('transfer')->orderByDesc('id')->get();
        $balance = $user->wallet->balance;

        return view('dashboard', compact('transactions', 'balance'));
    }
}
