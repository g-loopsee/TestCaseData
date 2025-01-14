<?php

use App\Http\Controllers\IncomesController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StocksController;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $incomesController = app(IncomesController::class);
    $ordersController = app(OrdersController::class);
    $salesController = app(SalesController::class);
    $stocksController = app(StocksController::class);
    $incomesController->index();
    Log::info('Incomes done!');
    $ordersController->index();
    Log::info('Orders done!');
    $salesController->index();
    Log::info('Sales done!');
    $stocksController->index();
    Log::info('Stocks done!');

})->twiceDaily(10, 20);;
