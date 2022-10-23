<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{

    // Logout user
    public function index()
    {
        $accessToken = Auth::user()->token()->delete();
        return ['message' => 'Logged out successfully'];
    }
}
