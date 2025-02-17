<?php

use App\Http\Controllers\Deposit\GetAllDepositController;
use App\Http\Controllers\Deposit\MakeDepositController;
use App\Http\Controllers\Deposit\WithdrawalDepositController;
use App\Http\Controllers\GetAllRollbackPendingController;
use App\Http\Controllers\Notifications\GetAllNotificationsController;
use App\Http\Controllers\Notifications\MarkReadNotificationsController;
use App\Http\Controllers\Transactions\GetAllTrasactionController;
use App\Http\Controllers\Transactions\MakeTransationController;
use App\Http\Controllers\Transactions\RollbackTransactionApprovalController;
use App\Http\Controllers\Transactions\RollbackTrasactionController;
use App\Http\Controllers\User\AuthController;
use App\Http\Controllers\User\CreateUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post("/auth", [AuthController::class, 'store']);

Route::post('/user', CreateUserController::class);


Route::group(["middleware" => "auth:api"], function () {

    Route::get('/user', function (Request $request) {
        return \App\Models\User::all();
    });

    Route::get('/teste', RollbackTransactionApprovalController::class);

    Route::get('/user/get-balance', function (Request $request) {

        $user = auth()->user();

        return response()->json([
            'balance' => $user->wallet->balance,
        ]);
    });

    Route::group(["prefix" => "deposit"], function () {
        Route::post('/', MakeDepositController::class);
        Route::post('withdrawal', WithdrawalDepositController::class);
        Route::get('/all', GetAllDepositController::class);
    });

    Route::group(["prefix" => "transaction"], function () {
        Route::post('/', MakeTransationController::class);
        Route::post('rollback', RollbackTrasactionController::class);
        Route::get('/all', GetAllTrasactionController::class);


        Route::post('rollback/approval', RollbackTransactionApprovalController::class);
        Route::get('rollback/all', GetAllRollbackPendingController::class);

    });



    Route::group(["prefix" => "notifications"], function () {
        Route::get('/', GetAllNotificationsController::class);
        Route::get('/read', MarkReadNotificationsController::class);
    });

});







