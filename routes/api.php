<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Like\LikeController;
use App\Http\Controllers\User\UserController;
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
// public auth routes
Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup']);
    Route::post('/login', [AuthController::class, 'signin']);
});

// USER ROUTES
// authenicated routes
Route::group(['middleware' => ['auth:api'], 'prefix' => 'users'], function () {
    Route::get('/profile', function (Request $request) {
        return $request->user();
    });
    Route::get('/{id}/agent', [UserController::class, 'getAgentProfile']);
    Route::put('/{id}/agent', [UserController::class, 'updateProfile']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
// authenicated routes | agent only
Route::group(['middleware' => ['auth:api', 'agent'], 'prefix' => 'users'], function () {
    Route::get('/{id}/user', [UserController::class, 'getUserProfile']);
});

// LISTINGS ROUTES
// public listing routes
Route::prefix('listings')->group(function () {
    Route::get('/', [ListingController::class, 'index']);
    Route::get('/{id}', [ListingController::class, 'show']);
});
// authenticated listing routes | agent only
Route::group(['middleware' => ['auth:api', 'agent'], 'prefix' => 'listings'], function () {
    Route::post('/', [ListingController::class, 'store']);
    Route::put('/{id}', [ListingController::class, 'update']);
    Route::patch('/{id}/update_field', [ListingController::class, 'updateField']);
    Route::delete('/{id}', [ListingController::class, 'destroy']);
});

// LIKE LISTINGS ROUTES
// authenicated Likes listing routes
Route::group(['middleware' => ['auth:api'], 'prefix' => 'likes'], function () {
    Route::post('/{id}', [LikeController::class, 'likeListing']);
    Route::get('/', [LikeController::class, 'likedListings']);
    Route::delete('/{id}', [LikeController::class, 'unlikeListing']);
});
