<?php

use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FeedbackCenterController;
use App\Http\Controllers\FeedbackManageController;
use App\Http\Controllers\InformasiBisnisController;
use App\Http\Controllers\KategoriTransaksiController;
use App\Http\Controllers\SuppliersOrCustomersController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use Illuminate\Contracts\Database\Eloquent\SupportsPartialRelations;
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
Route::post('/register', [AuthController::class, 'register']);

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
        Route::put('profile', 'updateUserProfile');
    });


    Route::controller(TransaksiController::class)->group(function(){
        Route::get('all-transaksi', 'index');
        Route::post('transaksi', 'store');
        Route::get('transaksi-by-uuid', 'getTransaksiByUuid');
        Route::put('transaksi-update', 'update');
        Route::get('transaksi-by-month', 'getTransaks`iByMonth');
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
        Route::get('anggaran', 'index');
        Route::post('anggaran', 'store');
        Route::get('anggaran-by-id', 'getAnggaranById');
        Route::put('anggaran', 'update');
        Route::delete('anggaran', 'destroy');
    });

    Route::controller(SuppliersOrCustomersController::class)->group(function()
    {
        Route::get('supplier' , 'index');
        Route::get('supplier-by-id' , 'getSupplierById');
        Route::post('supplier', 'store');
        Route::put('supplier', 'update');
        Route::delete('supplier', 'destroy');
    });

    Route::controller(InformasiBisnisController::class)->group(function()
    {
        Route::get('user/info-bisnis', 'index');
        Route::post('user/info-bisnis', 'store');
    });

    Route::controller(FeedbackCenterController::class)->group(function()
    {
        Route::post('feedback', 'store');
    });

    Route::controller(FeedbackManageController::class)->group(function()
    {
        Route::get('feedback-manage', 'index');
        Route::get('feedback-manage/detail', 'getFeedbackManageById');
    });
});

