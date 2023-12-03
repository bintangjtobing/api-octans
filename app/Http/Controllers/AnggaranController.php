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
        $anggaran = DatabaseHelper::getPersentaseAnggaran();

        if($anggaran){
            return response()->json([
                'status' => 200,
                'message' => 'oke',
                'data' => $anggaran
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
        $validate['user_id'] = Auth::user()->id;

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

    public function getAnggaranById(Request $request)
    {
        $anggaran = DatabaseHelper::getAnggaran()->where('id', $request->id)->get();

        if($anggaran) {
            return response()->json([
                'status' => 200,
                'message' => 'oke',
                'data' => $anggaran
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'error'
            ]);
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'jumlah' => 'required',
            'kategori_transaksi_id' => 'required',
            'kategori_anggaran_id' => 'required',
        ]);

        $validate['user_id'] = auth()->user()->id;


        $updateAnggran = Anggaran::where('id', request()->id)
                ->update($validate);

        if($updateAnggran) {
            return response()->json([
                'status' => 201,
                'mesage' => 'data berhasil diubah'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'mesage' => 'data gagal diubah'
            ]);
        }
    }
}
