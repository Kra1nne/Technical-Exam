<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('families', CrudController::class);