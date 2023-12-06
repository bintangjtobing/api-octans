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

    public function updateUserProfile(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required',
            'email' => 'required|email',
            'alamat' => 'required',
            'username' => 'required',
            'no_handphone' => 'required',
        ]);

        if ($request->file('profile-image')) {
            // if ($request->oldImage) {
            //     Storage::delete($request->oldImage);
            // }
             // upload ke server cloud [CDN]
             $validate['foto'] = cloudinary()->upload(request()->file('profile_image')->getRealPath())->getSecurePath();
        }
        $updateUser = User::where('id', auth()->user()->id)->update($validate);

        if($updateUser) {
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil diubah',
            ]);
        }else{
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil diubah',
            ]);
        }
    }
}
