<?php

namespace App\Http\Controllers\Deposit;

use App\Enums\StatusTransactionEnum;
use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MakeDepositController extends Controller
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

        $user->wallet->credit($request->amount);



        DB::transaction(function () use ($user, $request) {

            Deposit::query()->create([
                'wallet_id' => $user->wallet->id,
                'amount' => $request->amount,
                'status' => StatusTransactionEnum::COMPLETED,
            ]);


        });

        return response()->json([
            'message' => 'Deposit successful',
            'balance' => $user->wallet->balance,
        ]);

    }
}
