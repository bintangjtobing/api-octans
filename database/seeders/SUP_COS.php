<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SUP_COS extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers_or_customers')->insert([
            'nama_bisnis' => 'PT Boxity Central Indonesia',
            'alamat' => 'Grand silipi tower',
            'email' => 'boxity@gmail.com',
            'jenis_transaksi_id' => 1,
            'no_hp' => '08317654329',
            'user_id' => 1
        ]);
        DB::table('suppliers_or_customers')->insert([
            'nama_bisnis' => 'PT Unilever',
            'alamat' => 'Grand silipi tower',
            'email' => 'unilever@gmail.com',
            'jenis_transaksi_id' => 1,
            'no_hp' => '083176347853',
            'user_id' => 1
        ]);
        DB::table('suppliers_or_customers')->insert([
            'nama_bisnis' => 'PT Pevindo',
            'alamat' => 'Grand silipi tower',
            'email' => 'pevindo@gmail.com',
            'jenis_transaksi_id' => 2,
            'no_hp' => '083196821894',
            'user_id' => 1,
        ]);
        DB::table('suppliers_or_customers')->insert([
            'nama_bisnis' => 'PT Maju Bersama',
            'alamat' => 'Grand silipi tower',
            'email' => 'pevindo@gmail.com',
            'jenis_transaksi_id' => 2,
            'no_hp' => '083184504329',
            'user_id' => 1,
        ]);
    }
}
