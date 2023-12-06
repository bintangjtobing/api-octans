<?php

namespace App\Http\Controllers;

use App\Models\informasiBisnis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformasiBisnisController extends Controller
{
    public function index()
    {
        $infoBisnis = informasiBisnis::where('user_id',Auth::user()->id)->first();

        if($infoBisnis) {
            return response()->json([
                'status' => 200,
                'message' => 'okee',
                'data' => $infoBisnis
            ]);
        }else{
            return response()->json([
                'status' => 203,
                'message' => 'data tidak ditemukan'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'error'
        ]);
    }

    public function store()
    {
        $validate = request()->validate([
            'nama_bisnis' => 'required',
            'alamat' => 'required',
            'jabatan' => 'required',
            'no_tax' => 'max:255',
            'website' => 'max:255',
            'email' => 'required',
            'no_handphone' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Menambahkan validasi untuk gambar
        ]);

        $validate['user_id'] = auth()->user()->id;

        if (request()->file('logo')) {
            // if (request()->oldLogo) {
            //     // Pastikan oldLogo berisi path lengkap ke file
            //     Storage::delete(request()->oldLogo);
            // }
            // $validate['logo'] = request()->file('logo')->store('logo_bisnis');
            $validate['logo'] = cloudinary()->upload(request()->file('logo')->getRealPath())->getSecurePath();
        }

        $infoBisnis = informasiBisnis::where('user_id', auth()->user()->id)->first();

        if ($infoBisnis) {
            $infoBisnis->update($validate);

            return response()->json([
                'status' => 201,
                'message' => 'data berhasil diubah'
            ]);
        } else {
            informasiBisnis::create($validate);

            return response()->json([
                'status' => 201,
                'message' => 'data berhasil ditambah'
            ]);
        }

        return response()->json([
            'status' => 400,
            'message' => 'error'
        ]);
    }
}
