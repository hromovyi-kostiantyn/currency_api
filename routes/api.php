<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;


Route::post('/subscribe', [CurrencyController::class, 'subscribe']);

Route::get('/rate', [CurrencyController::class, 'getCurrentCurrency']);
