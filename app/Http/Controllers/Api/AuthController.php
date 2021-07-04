<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\RestController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends RestController
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except([
            'login'
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::guard('web')->validate($request->only('login', 'password'))) {
            return $this->error(trans('auth.failed'), 401);
        }

        $user = User::where('login', $request['login'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'token_type' => "Bearer",
            'token' => $token,
        ], trans('auth.success'));
    }
}
