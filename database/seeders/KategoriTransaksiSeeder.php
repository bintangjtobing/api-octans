<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kategori_transaksis')->insert([
            'nama' => 'Gaji',
            'jenis_transaksi_id' => 1,
            'user_id' => 0,
            'default' => 1
        ]);

        DB::table('kategori_transaksis')->insert([
            'nama' => 'Investasi',
            'jenis_transaksi_id' => 3,
            'user_id' => 0,
            'default' => 1
        ]);

        DB::table('kategori_transaksis')->insert([
            'nama' => 'Makanan',
            'jenis_transaksi_id' => 2,
            'user_id' => 0,
            'default' => 1
        ]);

        DB::table('kategori_transaksis')->insert([
            'nama' => 'Pendidikan',
            'jenis_transaksi_id' => 2,
            'user_id' => 0,
            'default' => 1
        ]);

        DB::table('kategori_transaksis')->insert([
            'nama' => 'Gaji karyawan',
            'jenis_transaksi_id' => 2,
            'user_id' => 0,
            'default' => 1
        ]);
    }
}
