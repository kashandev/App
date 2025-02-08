<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantUserLoginController;
use App\Http\Controllers\RestaurantUserController;

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


Route::post('/login', [RestaurantUserLoginController::class, 'login']);
Route::post('/logout', [RestaurantUserLoginController::class, 'logout']);
Route::post('/showmessage', [RestaurantUserLoginController::class, 'showmessage']);
Route::post('/hidemessage', [RestaurantUserLoginController::class, 'hidemessage']);
Route::post('/adduser', [RestaurantUserController::class, 'adduser']);
Route::get('/getusers', [RestaurantUserController::class, 'getusers']);