<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegistrationController;
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

Route::controller(AuthController::class)->group(function(){
    Route::post('/send/otp', 'store')->name('sendOtp');
    Route::post('/verify/otp', 'verify')->name('sendOtp');
    Route::post('/forget/password', 'forgetPassword')->name('forgetPassword');
    Route::post('/update/password', 'updatePassword')->name('updatePassword');
});

Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'store')->name('login');
});

Route::controller(RegistrationController::class)->group(function(){
    Route::post('/registration', 'store')->name('registration');
});

Route::middleware(['auth:sanctum'])->group(function(){
    Route::post('/logout', [LogoutController::class, 'destroy'])->name('logout');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
