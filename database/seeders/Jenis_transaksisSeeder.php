<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Jenis_transaksisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_transaksis')->insert([
            'nama' => 'Pemasukan',
        ]);
        DB::table('jenis_transaksis')->insert([
            'nama' => 'Pengeluaran',
        ]);DB::table('jenis_transaksis')->insert([
            'nama' => 'Tabungan',
        ]);
    }
}
