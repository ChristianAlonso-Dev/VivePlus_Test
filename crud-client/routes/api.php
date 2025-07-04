<?php

use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\user\UserController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/get_token', [AuthController::class, 'getToken']);

Route::post('/create_user', [UserController::class, 'create']);

Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update_user', [UserController::class, 'update']);
    Route::delete('/delete_user/{id}', [UserController::class, 'delete']);
});