<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriTransaksiController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::get('unauthorized', function() {
    return response()->json([
        'status' => 401,
        'message' => 'invalid kredensial'
    ]);
})->name('unauthorized');


Route::middleware('auth:sanctum')->group(function()
{
    Route::controller(UserController::class)->group(function()
    {
        Route::get('all-user', 'index');
        Route::get('/user', 'userNow');
    });


    Route::controller(TransaksiController::class)->group(function(){
        Route::get('all-transaksi', 'index');
        Route::post('transaksi', 'store');
        Route::get('transaksi-by-uuid', 'getTransaksiByUuid');
        Route::put('transaksi-update', 'update');
        Route::get('transaksi-by-month', 'getTransaksiByMonth');
        Route::get('transaksi-by-jenis-transaksi', 'getTransaksiByJenisTransaksi');
    });

    Route::controller(KategoriTransaksiController::class)->group(function(){
        Route::get('kategori-transaksi', 'index');
        Route::post('kategori-transaksi', 'store');
        Route::put('kategori-transaksi', 'update');
        Route::delete('kategori-transaksi', 'destroy');
    });

    Route::controller(AnggaranController::class)->group(function()
    {
        Route::get('anggran', 'index');
        Route::post('anggran', 'store');
        Route::get('anggran-by-id', 'getAnggaranById');
        Route::put('anggran', 'update');
    });
});

