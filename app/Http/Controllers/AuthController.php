<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($validated)){
            $token = auth()->user()->createToken('your-token-name');

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'token' => $token->plainTextToken,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Login gagal',
        ]);

    }
}
