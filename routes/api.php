<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Agent\AgentController;
use App\Http\Controllers\Listing\ListingController;

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


// agent routes
Route::group(['middleware' => ['auth:api', 'agent'], 'prefix' => 'agent'], function () {
    Route::get('/dashboard', [AgentController::class, 'dashboard']);
});

// authenicated routes
Route::group(['middleware' => ['auth:api'], 'prefix' => 'user'], function () {
    Route::get('/dashboard', [UserController::class, 'dashboard']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/', function (Request $request) {
        return $request->user();
    });
});

// public listing routes
Route::prefix('listings')->group(function () {
    Route::get('/', [ListingController::class, 'index']);
    Route::get('/{id}', [ListingController::class, 'show']);
});

// protected listing routes
Route::group(['middleware' => ['auth:api', 'agent'], 'prefix' => 'listings'], function () {
    Route::post('/', [ListingController::class, 'store']);
    Route::put('/{id}', [ListingController::class, 'update']);
    Route::patch('/{id}/update_field', [ListingController::class, 'updateField']);
    Route::delete('/{id}', [ListingController::class, 'destroy']);
});

// Route::apiResource('listings', ListingController::class)->middleware('auth:api');
