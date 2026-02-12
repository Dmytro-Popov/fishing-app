<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatchController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('catches', CatchController::class);
