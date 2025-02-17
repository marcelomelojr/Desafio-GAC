<?php

namespace App\Http\Controllers\Transactions;

use App\Actions\FindUserAction;
use App\Enums\StatusTransactionEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\ReceiveTransaction;
use App\Notifications\SenderTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MakeTransationController extends Controller
{

    public function __invoke(Request $request)
    {

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payee' => 'required',
        ]);

        $payer = User::findOrFail(auth()->user()->id)->load('wallet');

        $payee = FindUserAction::run($request->payee);

        if (data_get($payee, 'id') === data_get($payer, 'id')) {
            return response()->json([
                'error' => 'You cannot transfer to yourself',
            ], 400);
        }

        if ($payer->wallet->balance < $request->amount) {
            return response()->json([
                'error' => 'Insufficient funds',
            ], 400);
        }

        $transaction = DB::transaction(function () use ($payer, $payee, $request) {

            // Debit payer and credit payee
            $payer->wallet->debit($request->amount);
            $payee->wallet->credit($request->amount);

            // Create transaction
            $transaction = Transaction::query()->create([
                'payer_id' => $payer->id,
                'payee_id' => $payee->id,
                'amount' => $request->amount,
                'type' => "TRANSFER",
                'status' => StatusTransactionEnum::COMPLETED,
            ]);

            return $transaction;
        });

        $transaction->payer = $payer->name;
        $transaction->payee = $payee->name;

        $payload = [
            ...$transaction->toArray(),
            'payer' => $payer->name,
            'payee' => $payee->name,
        ];

        $payee->notify(new ReceiveTransaction(
            [
                ...$payload,
                'transaction_type' => 'CREDIT',
            ]
        ));

        $payer->notify(new SenderTransaction(
            [
                ...$payload,
                'transaction_type' => 'DEBIT',
            ]
        ));

        return response()->json([
            'message' => 'Transaction completed successfully',
            'transaction' => $transaction,

        ]);

    }
}
