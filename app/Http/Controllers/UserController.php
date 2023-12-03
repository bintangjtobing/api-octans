<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // menampilkan semua user
    public function index()
    {
        return User::all();
    }

    // menampilkan user saat ini
    public function userNow(Request $request)
    {
        return User::where('id', Auth::user()->id)->with('payment')->get();
    }
}
