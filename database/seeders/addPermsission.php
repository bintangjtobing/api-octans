<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class addPermsission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'lihat transaksi']);
        Permission::create(['name' => 'tambah transaksi']);
        Permission::create(['name' => 'ubah transaksi']);
        Permission::create(['name' => 'hapus transaksi']);
        Permission::create(['name' => 'cetak transaksi']);


        Permission::create(['name' => 'lihat kategori transaksi']);
        Permission::create(['name' => 'tambah kategori transaksi']);
        Permission::create(['name' => 'ubah kategori transaksi']);
        Permission::create(['name' => 'hapus kategori transaksi']);


        Permission::create(['name' => 'lihat anggaran']);
        Permission::create(['name' => 'tambah anggaran']);
        Permission::create(['name' => 'ubah anggaran']);
        Permission::create(['name' => 'hapus anggaran']);

        Permission::create(['name' => 'lihat supplier']);
        Permission::create(['name' => 'tambah supplier']);
        Permission::create(['name' => 'ubah supplier']);
        Permission::create(['name' => 'hapus supplier']);

        Permission::create(['name' => 'lihat pemasukan']);
        Permission::create(['name' => 'hapus pemasukan']);
        Permission::create(['name' => 'cetak pemasukan']);

        Permission::create(['name' => 'lihat pengeluaran']);
        Permission::create(['name' => 'hapus pengeluaran']);
        Permission::create(['name' => 'cetak pengeluaran']);

        Permission::create(['name' => 'lihat laba rugi']);
        Permission::create(['name' => 'hapus laba rugi']);
        Permission::create(['name' => 'cetak laba rugi']);


        Permission::create(['name' => 'lihat user']);
        Permission::create(['name' => 'tambah user']);
        Permission::create(['name' => 'ubah user']);
        Permission::create(['name' => 'hapus user']);


        Permission::create(['name' => 'lihat feedback manage']);
        Permission::create(['name' => 'hapus feedback manage']);

        Permission::create(['name' => 'lihat akses level']);
        Permission::create(['name' => 'tambah akses level']);
        Permission::create(['name' => 'ubah akses level']);
        Permission::create(['name' => 'hapus akses level']);

    }
}
