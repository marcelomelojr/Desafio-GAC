<?php

namespace App\Http\Controllers;

use App\Enums\StatusTransactionEnum;
use App\Models\Rollback;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class GetAllRollbackPendingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $rollbacks = Rollback::query()
            ->where('status', StatusTransactionEnum::PENDING)
            ->with('transaction')
            ->get()

        ;

        foreach ($rollbacks as $rollback) {
            $rollback->payee = $this->getUser($rollback->transaction->payee_id);
            $rollback->payer = $this->getUser($rollback->transaction->payer_id);
        }

        return response()->json(
            $rollbacks
        );
    }

    public function getUser($id)
    {

        $user = User::query()
            ->select('users.name')
            ->where('users.id', $id)
            ->get();

        return $user->first();
    }
}

