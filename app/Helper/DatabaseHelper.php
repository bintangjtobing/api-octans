<?php

namespace App\Helper;

use App\Models\Anggaran;
use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseHelper
{
    public static function getMonth()
    {
        // Mengatur zona waktu menjadi "Asia/Jakarta"
        $tanggalSaatIni = Carbon::now();

        // Mengatur zona waktu "Asia/Jakarta"
        $tanggalSaatIni->setTimezone('Asia/Jakarta');

        // Format tanggal sesuai dengan kebutuhan Anda
        $tanggalSaatIniFormatted = $tanggalSaatIni->format('Y-m-d H:i:s');

        // Mendapatkan bulan saat ini dalam bentuk nomor (1-12)
        return $tanggalSaatIni->month;

    }

    public static function getYear()
    {
        // Mengatur zona waktu menjadi "Asia/Jakarta"
        $tanggalSaatIni = Carbon::now();

        // Mengatur zona waktu "Asia/Jakarta"
        $tanggalSaatIni->setTimezone('Asia/Jakarta');

        // Format tanggal sesuai dengan kebutuhan Anda
        $tanggalSaatIniFormatted = $tanggalSaatIni->format('Y-m-d H:i:s');

        // Mendapatkan bulan saat ini dalam bentuk nomor (1-12)
        return $tanggalSaatIni->year;

    }

    public static function getUserNow()
    {
        return User::where('id', Auth::user()->id)->with('payment')->first();
    }

    public static function getTransaksi()
    {
        return Transaksi::where('user_id', Auth::user()->id)->where('void', false);
    }

    public static function getAnggaran()
    {
        return Anggaran::where('user_id', Auth::user()->id);
    }

    public static function getPersentaseAnggaran()
    {
        $persentaseAnggarans = Transaksi::join('anggarans', 'transaksis.kategori_transaksi_id', '=', 'anggarans.kategori_transaksi_id')
                                ->where('transaksis.user_id', auth()->user()->id)
                                ->where('transaksis.void', false)
                                ->where('anggarans.user_id', auth()->user()->id)
                                ->whereMonth('transaksis.tanggal', DatabaseHelper::getMonth())
                                ->select(
                                    'anggarans.kategori_transaksi_id',
                                    DB::raw('SUM(transaksis.jumlah) / anggarans.jumlah * 100 AS persentase')
                                )
                                ->groupBy('transaksis.kategori_transaksi_id', 'anggarans.kategori_transaksi_id', 'anggarans.jumlah', 'transaksis.kategori_transaksi_id')
                                ->get();


        $anggaran = Anggaran::where('user_id', auth()->user()->id)->get();

        $persentaseAnggaransArray = $persentaseAnggarans->keyBy('kategori_transaksi_id')->map(function ($item) {
            return floatval($item->persentase); // Mengonversi persentase ke float
        })->toArray();


        $anggaranDenganPersentase = $anggaran->map(function ($item) use ($persentaseAnggaransArray) {
            $kategori_transaksi_id = $item->kategori_transaksi_id;
            $persentase = $persentaseAnggaransArray[$kategori_transaksi_id] ?? 0; // Default 0 jika tidak ada persentase yang cocok
            $item->persentase = $persentase;
            return $item;
        });

        return $anggaranDenganPersentase;

    }
}
