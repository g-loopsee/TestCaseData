<?php

use Illuminate\Support\Facades\Route;
use function Termwind\parse;

Route::get('/get_stocks', [\App\Http\Controllers\StocksController::class, 'index']);
Route::get('/get_incomes', [\App\Http\Controllers\IncomesController::class, 'index']);
Route::get('/get_sales', [\App\Http\Controllers\SalesController::class, 'index']);
Route::get('/get_orders', [\App\Http\Controllers\OrdersController::class, 'index']);
