<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('authorize', [AuthorizationController::class, "auth"]);
Route::middleware("auth:api")->group(function () {
    Route::post('module', [ModuleController::class, "create"]);
});
