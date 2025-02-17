<?php

namespace App\Http\Controllers\User;

use App\Actions\CreateWalletAction;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CreateUserController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'document' => 'required',
        ]);

         $user = DB::transaction(function() use ($request) {

             $user = User::query()->create([
                 'name' => $request->name,
                 'email' => $request->email,
                 'password' => bcrypt($request->password),
                 'document' => $request->document,
             ]);

             if (!$user) {
                 DB::rollBack();

                 return response()->json([
                     'error' => 'Error creating user',
                 ], 500);
             }

             $user->roles()->attach(2);

             CreateWalletAction::run($user->id);

             return $user;
        });

        return response()->json([$user->load('wallet')], 201);
    }
}
