<?php

namespace App\Http\Controllers;

use App\Models\Kategori_transaksi;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class KategoriTransaksiController extends Controller
{
    public function index()
    {
        $kategoriTransaksi = Kategori_transaksi::where('default', true)->orWhere('user_id', auth()->user()->id)->paginate(20);

        if($kategoriTransaksi){
            return response()->json([
                'status' => 200,
                'message' => 'sukses',
                'data' => $kategoriTransaksi,
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'error',
            ]);
        }
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|max:255',
            'jenis_transaksi_id' => 'required',
        ]);

        $validate['user_id'] = auth()->user()->id;

        $createTransaksi = Kategori_transaksi::create($validate);

        if($createTransaksi) {
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil ditambahkan'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'error' => 'periksa data kembali',
            ]);
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|max:255',
            'jenis_transaksi_id' => 'required',
        ]);

        $updateTransaksi = Kategori_transaksi::where('id', request()->id)
                            ->update($validate);

       if($updateTransaksi){
        return response()->json([
            'status' => 201,
            'message' => 'data berhasil di ubah',
        ]);
       }else {
        return response()->json([
            'status' => 400,
            'message' => 'gagal mengubah data'
        ]);
       }
    }

    public function destroy()
    {
        $deleteKategori = Kategori_transaksi::destroy(request()->id);

        if($deleteKategori){
            return response()->json([
                'status' => 200,
                'message' => 'data berhasil dihapus'
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'data gagal di hapus'
            ]);
        }
    }
}
