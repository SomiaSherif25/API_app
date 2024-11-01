<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\CategoryController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(["namespace" => "API"], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(["middleware" => 'verify.token'], function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});


Route::group(["middleware" => ['verify.token','lang']], function () {

    Route::post('create', [CategoryController::class, 'create']);
    Route::post('update', [CategoryController::class, 'update']);
    Route::post('delete', [CategoryController::class, 'delete']);
    Route::post('getAll', [CategoryController::class, 'getAll'])->middleware("lang");
    Route::post('getCategoryById', [CategoryController::class, 'getCategoryById']);

});