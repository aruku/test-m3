<?php

use App\Services\CurrencyConverterInterface;
use Illuminate\Support\Facades\Route;

// TODO PROPERLY HANDLE $amount NOT BEING A FLOAT OR EITHER CURRENCY MISSING
Route::get('/convert/{amount}/{from}/{to}/', function (CurrencyConverterInterface $currencyConverter, float $amount, string $from, string $to) {
    return response()
        ->json($currencyConverter($amount, $from, $to));
});
