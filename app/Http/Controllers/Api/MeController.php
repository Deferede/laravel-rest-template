<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\RestController;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class MeController extends RestController
{
    public function __invoke()
    {
        $user = Auth::user();

        return $this->success(UserResource::make($user));
    }
}
