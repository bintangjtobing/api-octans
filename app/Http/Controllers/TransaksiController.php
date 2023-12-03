<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helper\DatabaseHelper;
use App\Models\User;
use App\Models\Anggaran;
use App\Models\Kategori_transaksi;
use Dflydev\DotAccessData\Data;

class TransaksiController extends Controller
{
    // tampilkan semua transaksi untuk user yang sedang login
    public function index()
    {
        return Transaksi::where('user_id', Auth::user()->id)->where('void', 0)->get();
    }

    // create transaksi
    public function store(Request $request)
    {
        $validate = $request->validate([
            'tanggal' => 'required|max:255',
            'jumlah' => 'required|max:255',
            'kategori_transaksi_id' => 'required',
            'suppliers_or_customers_id' => 'max:255',
            'jenis_transaksi_id' => 'required',
            'deskripsi' => 'max:255'
        ]);

        $validate['user_id'] = Auth::user()->id;

        // Ambil ID terakhir dari tabel Transaksi
        $lastTransaction = Transaksi::where('user_id', auth()->user()->id)->where('void', false)->count();

        if ($lastTransaction) {
        $lastTransactionId = $lastTransaction;
        } else {
            $lastTransactionId = 0;
        };

         // Tetapkan $no_transaksi berdasarkan jenis transaksi dan nomor ID terakhir
         if ($validate['jenis_transaksi_id'] == 1) {
            $validate['no_transaksi'] = 'ITR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        } elseif ($validate['jenis_transaksi_id'] == 2) {
            $validate['no_transaksi'] = 'OTR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        } else {
            $validate['no_transaksi'] = 'STR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        }

        $data_transaksi = Transaksi::where('kategori_transaksi_id', $validate['kategori_transaksi_id'])
        ->where('user_id', auth()->user()->id)
        ->whereMonth('created_at', DatabaseHelper::getMonth())
        ->select('kategori_transaksi_id')
        ->selectRaw('SUM(jumlah) as total_jumlah')
        ->groupBy('kategori_transaksi_id')
        ->get();

        if(count($data_transaksi) > 0){
        $total_jumlah = $data_transaksi[0]->total_jumlah += intval($validate['jumlah']);
        }else(
        $total_jumlah = 0
        );

        $data_anggaran = Anggaran::where('user_id', auth()->user()->id)
                                ->where('kategori_transaksi_id', $validate['kategori_transaksi_id'])
                                ->whereMonth('created_at', DatabaseHelper::getMonth())
                                ->get();

        if($validate['suppliers_or_customers_id'] === 'Select Supplier/Customer') {
            $validate['suppliers_or_customers_id'] = 0;
        }

        $user = DatabaseHelper::getUserNow();

        if($user->payment_id != null && $user->payment != null){
            if($user->payment->status == 'pending') {
                 if(Transaksi::where('user_id', auth()->user()->id)->count() > 5) {
                     return response()->json([
                        'status' => 403,
                        'message' => 'anda tidak memiliki akses untuk menambah data ini'
                     ]);
                 }else{
                     if(empty($data_anggaran[0]['jumlah'])){
                         $validate['anggaran'] = false;
                         Transaksi::create($validate);
                         Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                        return response()->json([
                        'status' => 201,
                        'message' => 'data transaksi berhasil ditambahkan'
                     ]);
                     }else if($total_jumlah <= $data_anggaran[0]['jumlah']){
                         $validate['anggaran'] = true;
                         Transaksi::create($validate);
                         Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                        return response()->json([
                        'status' => 201,
                        'message' => 'data transaksi berhasil ditambahkan'
                     ]);
                     }else{
                        return response()->json([
                            'status' => 400,
                            'message' => 'data gagal ditambahkan'
                         ]);
                     }
             }
            }else if($user->payment->status == 'successful'){
                if(empty($data_anggaran[0]['jumlah'])){
                    $validate['anggaran'] = false;
                    Transaksi::create($validate);
                    Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                   return response()->json([
                   'status' => 201,
                   'message' => 'data transaksi berhasil ditambahkan'
                ]);
                }else if($total_jumlah <= $data_anggaran[0]['jumlah']){
                    $validate['anggaran'] = true;
                    Transaksi::create($validate);
                    Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                   return response()->json([
                   'status' => 201,
                   'message' => 'data transaksi berhasil ditambahkan'
                ]);
                }else{
                   return response()->json([
                       'status' => 400,
                       'message' => 'data gagal ditambahkan'
                    ]);
                }
            }
         }else if($user->payment_id == null){
             if(Transaksi::where('user_id', auth()->user()->id)->count() > 5) {
                return response()->json([
                    'status' => 403,
                    'message' => 'anda tidak memiliki akses untuk menambah data ini'
                 ]);
             }else{
                 if(empty($data_anggaran[0]['jumlah'])){
                     $validate['anggaran'] = false;
                     Transaksi::create($validate);
                     Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                     return response()->json([
                        'status' => 201,
                        'message' => 'data transaksi berhasil ditambahkan'
                     ]);
                 }else if($total_jumlah <= $data_anggaran[0]['jumlah']){
                     $validate['anggaran'] = true;
                     Transaksi::create($validate);
                     Kategori_transaksi::where('id', $validate['kategori_transaksi_id'])->update(['show' => false]);
                     return response()->json([
                        'status' => 201,
                        'message' => 'data transaksi berhasil ditambahkan'
                     ]);
                 }else{
                     return response()->json([
                        'status' => 400,
                        'message' => 'data gagal ditambahkan'
                     ]);
                 }
             }
         }

    }

    public function getTransaksiByUuid(Request $request)
    {
        $transaksi = Transaksi::where('user_id', Auth::user()->id)->where('uuid', $request->uuid)->where('void', 0)->first();
        if($transaksi){
            return response()->json([
                'status' => 200,
                'data' => $transaksi
            ]);
        }else{
            return response()->json([
                'status' => 404,
                'data' => []
            ]);
        }
    }

    public function update(Request $request)
    {
        $void['void'] = request()->void = true;

        Transaksi::where('user_id', auth()->user()->id)
                    ->where('uuid', $request->uuid)
                    ->update($void);

        $validate = $request->validate([
            'tanggal' => 'required|max:255',
            'jumlah' => 'required|max:255',
            'kategori_transaksi_id' => 'required',
            'suppliers_or_customers_id' => 'max:255',
            'jenis_transaksi_id' => 'required',
            'deskripsi' => 'max:255'
        ]);

        $data_anggaran = Anggaran::where('user_id', auth()->user()->id)->where('kategori_transaksi_id', request('old_kategori_transaksi_id'))->get();

        $validate['user_id'] = auth()->user()->id;

        $validate['anggaran'] = request()->anggaran;

        $lastTransaction = Transaksi::where('user_id', auth()->user()->id)->where('void', false)->count();

        if ($lastTransaction) {
            $lastTransactionId = $lastTransaction;
        } else {
            $lastTransactionId = 0;
        }

        // Tetapkan $no_transaksi berdasarkan jenis transaksi dan nomor ID terakhir
        if ($validate['jenis_transaksi_id'] == 1) {
            $validate['no_transaksi'] = 'ITR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        } elseif ($validate['jenis_transaksi_id'] == 2) {
            $validate['no_transaksi'] = 'OTR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        } else {
            $validate['no_transaksi'] = 'STR-' . DatabaseHelper::getYear() . DatabaseHelper::getMonth() . '-00000' . ($lastTransactionId + 1);
        }

        $updateTransaksi = Transaksi::where('user_id', auth()->user()->id)
                    ->where('uuid', request()->uuid)
                    ->create($validate);


        if($updateTransaksi){
            return response()->json([
                'status' => 201,
                'message' => 'update berhasil'
            ]);
        }else{
            return response()->json([
                'status' => 201,
                'message' => 'update berhasil'
            ]);
        }

    }

    public function getTransaksiByMonth(Request $request)
    {
        $transaksi = Transaksi::with(['kategori_transaksi'])
                            ->where('user_id', auth()->user()->id)
                            ->where('void', false)
                            ->orderBy('created_at', 'desc');

        if (request()->id == '0') {
            $transaksi = $transaksi->get();
        } else {
            $transaksi = $transaksi->whereMonth('tanggal', request()->id)->get();
        }

        return $transaksi;
    }

    public function getTransaksiByJenisTransaksi(Request $request)
    {
       if($request->id == 'all'){
        $transaksi = DatabaseHelper::getTransaksi()->get();
       }else{
        $transaksi = DatabaseHelper::getTransaksi()->where('jenis_transaksi_id', $request->id)->get();
       }

        return $transaksi;
    }
}
