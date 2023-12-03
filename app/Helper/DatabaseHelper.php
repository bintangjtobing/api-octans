<?php

namespace App\Helper;

use App\Models\Transaksi;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
}
