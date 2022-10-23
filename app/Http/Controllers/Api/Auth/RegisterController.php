<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateRegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\GeneratesApiToken;

class RegisterController extends Controller
{
    use GeneratesApiToken;

    // Register User
    public function store(CreateRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $tokens = $this->requestAccessToken($request->email, $request->password);
        $user->token = $tokens;
        return (new UserResource($user));
    }
}
