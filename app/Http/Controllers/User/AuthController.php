<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use GuzzleHttp\Utils;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function store(AuthRequest $request)
    {

        $data = $request->validated();

        $url = route('passport.token');

        $data = [
            "client_secret" => config('passport.password_client.secret'),
            "client_id" => config('passport.password_client.id'),
            "grant_type" => 'password',
            "username" => $data['username'],
            "password" => $data['password'],
        ];

        $request = Request::create($url, 'POST', $data);
        $response = App::handle($request);
        $token = Utils::jsonDecode($response->getContent(), true);

        if (data_get($token, 'error')) {
            return response()->json([
                'error' => data_get($token, 'error'),
                'message' => data_get($token, 'message'),
            ], 401);
        }

        $user = User::query()
            ->where('email', $request->username)
            ->with('roles')
            ->get()
            ->toArray();

        return response()->json([
            ...$token,
            'user' => $user,
        ]);
    }

}
