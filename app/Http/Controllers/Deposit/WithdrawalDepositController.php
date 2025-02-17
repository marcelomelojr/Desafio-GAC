<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalDepositController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

            $request->validate([
                'amount' => 'required|numeric|min:1',
            ]);

            $user = auth()->user();

            if ($user->wallet->balance < $request->amount) {
                return response()->json([
                    'error' => 'Insufficient funds',
                ], 400);
            }

            $user->wallet->debit($request->amount);

            return response()->json([
                'message' => 'Withdrawal successful',
                'balance' => $user->wallet->balance,
            ]);

    }
}
