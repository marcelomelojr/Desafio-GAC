<?php

namespace App\Http\Controllers\Transactions;

use App\Enums\StatusTransactionEnum;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RollbackTrasactionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $request->validate([
            'transaction_id' => 'required|exists:transactions,id',
        ]);

        $transaction = Transaction::query()->find($request->transaction_id);

        if (!$transaction) {
            return response()->json([
                'error' => 'Transaction not found',
            ], 404);
        }

        if ($transaction->status !== StatusTransactionEnum::COMPLETED) {
            return response()->json([
                'error' => 'Transaction cannot be rolled back',
            ], 400);
        }

        DB::transaction(function () use ($transaction) {

            $rollback = $transaction->rollback()->create([
                'user_id' => auth()->id(),
                'transaction_id' => $transaction->id,
                'status' => StatusTransactionEnum::PENDING,
            ]);

            $transaction->update([
                'status' => StatusTransactionEnum::PENDING_ROLLBACK,
            ]);

        });

        return response()->json([
            'message' => 'Transaction rolled back solicited successfully',
        ]);
    }
}
