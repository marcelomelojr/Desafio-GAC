<?php

namespace App\Http\Controllers\Deposit;

use App\Http\Controllers\Controller;
use App\Models\Deposit;
use Illuminate\Http\Request;

class GetAllDepositController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        $deposits = Deposit::query()
            ->where('wallet_id', $user->wallet->id)
            ->orderBy('created_at', 'desc')
            ->get();


        return response()->json([
            'deposits' => $deposits,
        ]);

    }
}
