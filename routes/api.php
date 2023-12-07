<?php

use App\Http\Controllers\Api\ApplicationController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);
Route::post('/password/reset', [ForgotPasswordController::class, 'resetPassword']);


Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/index/application',[ApplicationController::class,'index']);
    Route::post('/create/application',[ApplicationController::class,'create']);
    Route::post('/status/delete',[ApplicationController::class,'status_delete']);
    Route::post('/status/by_store',[ApplicationController::class,'status_by_store']);
    Route::post('/status/by_other_store',[ApplicationController::class,'status_by_other_store']);

});
