<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CashRegisterController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

	Route::prefix('caja')->group(function () {
		Route::post('cargarBase', [CashRegisterController::class, 'loadBase']);
		Route::get('vaciar', [CashRegisterController::class, 'emptyCash']);

		/*TODO*/
		Route::post('estado', [CashRegisterController::class, 'getStatusCash']);

		Route::post('movimientos', [CashRegisterController::class, 'getMovements']);
		Route::post('realizarPago', [CashRegisterController::class, 'makePayment']);
	});

});