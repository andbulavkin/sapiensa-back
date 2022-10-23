<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\GeneratesApiToken;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LoginController extends Controller
{

    use GeneratesApiToken;

    // Login user
    public function index(Request $request){
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
        $user = User::where('email',$request->email)
        ->first();
        if (is_null($user)) {
            throw new UnauthorizedHttpException('', 'Incorrect email or username or password');
        }
        $tokens = $this->requestAccessToken($user->email, $request->password);
        $user->token = $tokens;
        return (new UserResource($user))->additional([ 'data' => [ 'auth' => $tokens ] ]);
    }
}
