<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;

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

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'signin']);
});


// admin routes
Route::group(['middleware' => ['auth:api', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);
});


// authenicated routes
Route::group(['middleware' => ['auth:api'], 'prefix' => 'user'], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/', function (Request $request) {
        return $request->user();
    });
});
