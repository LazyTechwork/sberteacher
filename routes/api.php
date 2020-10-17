<?php

use App\Http\Controllers\AuthorizationController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\UserController;
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

Route::post('authorize', [AuthorizationController::class, "auth"]);
Route::middleware("auth:sanctum")->group(function () {
    Route::get('user', [UserController::class, "info"]);
    Route::post('module', [ModuleController::class, "create"]);
    Route::patch('module', [ModuleController::class, "edit"]);
    Route::get('module', [ModuleController::class, "get"]);
    Route::get('modules', [ModuleController::class, "all"]);
});
