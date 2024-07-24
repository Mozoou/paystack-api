<?php

use App\Http\Controllers\Api\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/pay', [PaymentController::class, 'initialize']);
Route::get('/pay/callback', [PaymentController::class, 'callback']);