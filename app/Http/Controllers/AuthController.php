<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validate = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' =>'required',
        ], [
            'username.required' => 'Kolom username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'email.required' => 'Kolom email wajib diisi.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Kolom password wajib diisi.',
        ]);

        if($validate['password'] === request('confirm-password')){
            $validate['password'] = bcrypt($validate['password']);

            $user = User::create($validate);

            event(new Registered($user));

            Auth::login($user);
            $token = auth()->user()->createToken('your-token-name');
            if($user){
                return response()->json([
                    'status' => 201,
                    'message' => 'registrasi berhasil',
                    'token' => $token->plainTextToken,
                ]);
            }else{
                return response()->json([
                    'status' => 400,
                    'message' => 'registrasi gagal',
                ]);
            }
        }

    }

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
