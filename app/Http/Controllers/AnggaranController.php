<?php

namespace App\Http\Controllers;

use App\Helper\DatabaseHelper;
use Illuminate\Http\Request;
use App\Models\Anggaran;
use Illuminate\Support\Facades\Auth;

class AnggaranController extends Controller
{
    public function index()
    {
        $anggran = DatabaseHelper::getPersentaseAnggaran();

        if($anggran){
            return response()->json([
                'status' => 200,
                'message' => 'oke',
                'data' => $anggran
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'error'
            ]);
        }
    }

    public function store(Request $request)
    {
        $validateRules = [
            'jumlah' => 'required',
            'kategori_transaksi_id' => 'required',
        ];

        $kategoriAnggaranId = $request->input('kategori_anggaran_id');

        // Check if 'kategori_anggaran_id' is empty or contains "Select category"
        if (empty($kategoriAnggaranId) || $kategoriAnggaranId === "Select category") {
            $kategoriAnggaranId = 0; // Set default value to 0
        } else {
            $validateRules['kategori_anggaran_id'] = 'required|integer';
        }

        $validate = $request->validate($validateRules);
        $validate['kategori_anggaran_id'] = $kategoriAnggaranId;
        $validate['user_id'] = auth()->user()->id;

        $createAnggran = Anggaran::create($validate);

        if($createAnggran) {
            return response()->json([
                'status' => 201,
                'mesage' => 'data berhasil ditambah'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'mesage' => 'data gagal ditambah'
            ]);
        }
    }
}
