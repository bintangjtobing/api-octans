<?php

namespace App\Http\Controllers;

use App\Models\suppliers_or_customers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuppliersOrCustomersController extends Controller
{
    public function index()
    {
        $supplier = suppliers_or_customers::where('user_id', Auth::user()->id)->paginate(15);

        if($supplier) {
            return response()->json([
                'status' => 200,
                'message' => 'oke',
                'data' => $supplier
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'error',
                'data' => null
            ]);
        }
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama_bisnis' => 'required',
            'alamat' => 'required',
            'email' => 'email|required',
            'no_hp' => 'required',
            'jenis_transaksi_id' => 'required'
        ]);

        $validate['user_id'] = auth()->user()->id;

        $createSupplier = suppliers_or_customers::create($validate);

        if($createSupplier) {
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil ditamabah',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'data gagal ditamabah',
            ]);
        }

    }

    public function getSupplierById(Request $request)
    {
        $supplier = suppliers_or_customers::where('user_id', Auth::user()->id)->where('id', $request->id)->first();

        if($supplier) {
            return response()->json([
                'status' => 200,
                'message' => 'oke',
                'data' => $supplier
            ]);
        }else{
            return response()->json([
                'status' => 203,
                'message' => 'data tidak ditemukan',
                'data' => null
            ]);
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'nama_bisnis' => 'required',
            'alamat' => 'required',
            'email' => 'email|required',
            'no_hp' => 'required',
            'jenis_transaksi_id' => 'required'
        ]);

        $updateSupplier = suppliers_or_customers::where('user_id', auth()->user()->id)
                                ->where('email', $validate['email'])
                                ->update($validate);

        if($updateSupplier) {
            return response()->json([
                'status' => 201,
                'message' => 'data berhasil diubah',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'data gagal diubah',
            ]);
        }

    }

    public function destroy(Request $request)
    {
        $deleteSupplier = suppliers_or_customers::destroy($request->id);

        if($deleteSupplier) {
            return response()->json([
                'status' => 200,
                'message' => 'data berhasil dihapus',
            ]);
        }else{
            return response()->json([
                'status' => 400,
                'message' => 'data gagal dihapus',
            ]);
        }
    }
}
