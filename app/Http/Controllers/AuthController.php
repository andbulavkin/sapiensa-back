<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        dd($request->all());
        if (Auth::attempt(array('email' => $request->email, 'password' => $request->password))) {
            return response()
                ->json([
                    'authenticated' => true
                ]);
        }
    }


    public function logout()
    {
        Auth::logout();
        return response()
            ->json([
                'logout' => true
            ]);
    }
}
