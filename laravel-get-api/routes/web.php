<?php

use Illuminate\Support\Facades\Route;
use function Termwind\parse;

Route::get('/get_data', [\App\Http\Controllers\DataController::class, 'index']);
