<?php

use App\Http\Controllers\CrudController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('families.index');
});

Route::resource('families', CrudController::class);