<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// public routes
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'signin']);

//hmm where

// // admin routes
// Route::group(['middleware' => ['auth:sanctum', 'admin'], 'prefix' => 'admin'], function () {
//     Route::get('/dashboard', [AdminController::class, 'dashboard']);
// });


// // authenicated routes
// Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
//     Route::get('/profile', [UserController::class, 'profile']);
//     Route::get('/dashboard', [UserController::class, 'dashboard']);
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::get('/', function (Request $request) {
//         return $request->user();
//     });
// });
