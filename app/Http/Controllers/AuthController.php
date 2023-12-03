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

        // if(Auth::attempt($validated)){
            $auth = Auth::user();
            $token = $auth->createToken('auth_token')->plainTextToken;
            return response()->json([
                'succes' => true,
                'message' => 'login berhasil',
                'token' => $token,
            ]);
        // }

        // return response()->json([
        //     'succes' => false,
        //     'message' => 'login gagal',
        // ]);


    }
}
