<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookingsController;
use App\Http\Controllers\Api\V1\PaymentsController;
use App\Http\Controllers\Api\V1\RoomsController;
use App\Http\Controllers\Api\V1\CustomersController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::group([
    'prefix' => 'v1',
    'namespace' => '\App\Http\Controllers\Api\V1',
    'middleware' => 'auth:sanctum'
], function () {
    Route::apiResource('rooms', RoomsController::class);
    Route::apiResource('customers', CustomersController::class);
    Route::apiResource('bookings', BookingsController::class);
    Route::apiResource('payments', PaymentsController::class);
});

Route::post('v1/register', [AuthController::class, 'register'])->name('register');
Route::post('v1/login', [AuthController::class, 'login'])->name('login');
