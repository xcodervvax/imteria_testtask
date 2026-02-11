<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            abort(401);
        }

        $user = $request->user();

        $token = $request->user()->createToken('web')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $request->user()
        ]);
    }
}
