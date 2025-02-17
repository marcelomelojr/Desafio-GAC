<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class GetAllTrasactionController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        $transactions = Transaction::query()
            ->select('transactions.*', 'payee.name as payee_name', 'payer.name as payer_name')
            ->where('payer_id', $user->id)
            ->orWhere('payee_id', $user->id)
            ->join('users as payee', 'payee.id', '=', 'transactions.payee_id')
            ->join('users as payer', 'payer.id', '=', 'transactions.payer_id')
            ->orderBy('created_at', 'desc')
            ->get();


        foreach ($transactions as $transaction) {
            $transaction->type = $transaction->payer_id === $user->id ? 'DEBIT' : 'CREDIT';
        }
//        dd($transactions);

        return response()->json([
            'transactions' => $transactions,
        ]);


    }
}
