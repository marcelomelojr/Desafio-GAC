<?php

namespace  App\Actions;

use App\Models\User;

class FindUserAction
{
    public static function run($payee)
    {

        if (filter_var($payee, FILTER_VALIDATE_EMAIL)) {

            $payee = User::query()
                ->where('email', $payee)
                ->with('wallet')
                ->first();

            if (!$payee) {
                throw new \Exception('User not found');
            }

            return $payee;
        }

        if (preg_match('/^\d{3}\.\d{3}\.\d{3}-\d{2}$|^\d{11}$/', $payee)) {
            $payee = User::query()
                ->where('document', $payee)
                ->with('wallet')
                ->first();

            if (!$payee) {
                throw new \Exception('User not found');
            }

            return $payee;
        }

        $payee = User::query()->find($payee);

        if (!$payee) {
            throw new \Exception('User not found');
        }

        return $payee->load('wallet');
    }
}
