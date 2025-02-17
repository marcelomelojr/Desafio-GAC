<?php

namespace App\Http\Controllers\Transactions;

use App\Enums\StatusTransactionEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RollbackTransactionApprovalController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $user = auth()->user();

        if (!$user->roles->contains('name', 'Admin')) {
            return response()->json([
                'error' => 'You are not allowed to approve transaction rollback',
            ], 403);
        }

        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        $transaction = Transaction::query()->find($request->transaction_id);


        if ($transaction->status !== StatusTransactionEnum::PENDING_ROLLBACK) {
            return response()->json([
                'error' => 'Transaction cannot be rolled back',
            ], 400);
        }

        $transaction = DB::transaction(function () use ($transaction) {

            $payer = User::query()->find($transaction->payer_id);
            $payee = User::query()->find($transaction->payee_id);

            // Credit payer and debit payee
            $payer->wallet->credit($transaction->amount);
            $payee->wallet->debit($transaction->amount);

            // Update transaction status
            $transaction->update([
                'status' => StatusTransactionEnum::ROLLED_BACK,
            ]);

            $rollback = $transaction->rollback()->update([
                'transaction_id' => $transaction->id,
                'status' => StatusTransactionEnum::COMPLETED,
            ]);

            return $transaction;
        });

        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Transaction rolled back successfully',
        ]);

    }
}
