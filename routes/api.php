<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DetailTransaksiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/Register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

    Route::group(['middleware' => ['api.admin']], function(){

        Route::post('/User', [UserController::class, 'store']);
        Route::get('/User', [UserController::class, 'show']);
        Route::get('/User/{id}', [UserController::class, 'detail']);
        Route::put('/User/{id}', [UserController::class, 'update']);
        Route::delete('/User/{id}', [UserController::class, 'destroy']);
        Route::get('/filteringuser',[UserController::class, 'get']);

        Route::post('/meja', [MejaController::class, 'store']);
        Route::get('/meja', [MejaController::class, 'show']);
        Route::get('/meja/{id}', [MejaController::class, 'detail']);
        Route::put('/meja/{id}', [MejaController::class, 'update']);
        Route::delete('/meja/{id}', [MejaController::class, 'destroy']);
        //Route::get('/filteringmeja',[MejaController::class, 'get']);
        
        Route::post('/menu', [MenuController::class, 'store']);
        Route::get('/menu', [MenuController::class, 'show']);
        Route::get('/menu/{id}', [MenuController::class, 'detail']);
        Route::put('/menu/{id}', [MenuController::class, 'update']);
        Route::delete('/menu/{id}', [MenuController::class, 'destroy']);
        Route::get('/filteringmenu',[MenuController::class, 'get']);
    });

      Route::group(['middleware' => ['api.kasir']], function(){

         Route::post('/transaksi', [TransaksiController::class, 'store']);
         Route::get('/transaksi', [TransaksiController::class, 'show']);
         Route::get('/transaksi/{id}', [TransaksiController::class, 'detail']);
         Route::put('/transaksi/{id}', [TransaksiController::class, 'update']);
         Route::delete('/transaksi/{id}', [TransaksiController::class, 'destroy']);

         Route::post('/detail_transaksi', [DetailTransaksiController::class, 'store']);
         Route::put('/detail_transaksi/{id}', [DetailTransaksiController::class, 'update']);
         Route::delete('/detail_transaksi/{id}', [DetailTransaksiController::class, 'destroy']);
      });

         Route::group(['middleware' => ['api.manajer']], function(){

            Route::get('/filteringtransaksi',[TransaksiController::class, 'get']);

            Route::get('/filteringdetailtransaksi',[DetailTransaksiController::class, 'get']);
            Route::get('/detail_transaksi', [DetailTransaksiController::class, 'show']);
            Route::get('/detail_transaksi/{id}', [DetailTransaksiController::class, 'detail']);
      });
