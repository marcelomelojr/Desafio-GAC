<?php

namespace App\Actions;

use App\Models\User;

class CreateWalletAction
{

    public static function run($user_id)
    {

        $user = User::query()
            ->findOrFail($user_id);

        if ($user->wallet) {
            return response()->json([
                'message' => 'User already has a wallet'
            ]);
        }

        $wallet = $user->wallet()->create([
            'balance' => 0,
        ]);

        if (!$wallet) {
            return response()->json([
                'message' => 'Error creating wallet'
            ]);
        }

        return 'Wallet created';
    }

}
