<?php

namespace Database\Seeders;

use App\Models\Jenis_transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JenisTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_transaksis')->insert([
            'nama' => 'Pemasukan',
        ]);
    }
}
