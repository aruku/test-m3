<?php

use App\Http\Controllers\UserAuthController;
use App\Services\CurrencyConverterInterface;
use Illuminate\Support\Facades\Route;

Route::post('register', [UserAuthController::class, 'register']);
Route::post('login', [UserAuthController::class, 'login'])->name('login');
Route::post('logout', [UserAuthController::class, 'logout'])->middleware('auth:sanctum');

// TODO PROPERLY HANDLE $amount NOT BEING A FLOAT OR EITHER CURRENCY MISSING
Route::get('/convert/{amount}/{from}/{to}/', function (CurrencyConverterInterface $currencyConverter, float $amount, string $from, string $to) {
    return response()
        ->json($currencyConverter($amount, $from, $to));
})->middleware('auth:sanctum');
