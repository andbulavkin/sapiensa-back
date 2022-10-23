<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSetYourProfileRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class UserController extends Controller
{
    // Change password
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);
        $user = User::find(Auth::id());
        // check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'The old password does not match'], 400);
            // throw new UnprocessableEntityHttpException('The old password does not match');
        }
        // update
        $user->password = bcrypt($request->password);
        $user->save();
        // Revoke tokens
        $tokenRepository = app(TokenRepository::class);
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        return ['message' => 'Password changed successfully'];
    }

    // Edit profile
    public function editProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        $user = User::whereId(Auth::id())->first();
        if ($request->hasFile('profile')) {
            if (isset($user->profile) && !empty($user->profile)) {
                Storage::delete('public/' . $user->profile);
            }
            $user->profile = $request->profile->store('profile', ['disk' => 'public']);
        }
        $user->name = $request->name;
        $user->save();
        return ['message' => 'Profile changed successfully'];
    }

    // Set profile
    public function setProfile(CreateSetYourProfileRequest $request)
    {
        User::whereId(Auth::id())->update($request->validated());
        return ['message' => 'Set profile successfully'];
    }

    // User details
    public function details()
    {
        $user = User::whereId(Auth::id())->first();
        return (new UserResource($user));
    }
}
