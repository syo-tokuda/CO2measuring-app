<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeasuringController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('measuring',[MeasuringController::class,'index']);
Route::post('measuring',[MeasuringController::class,'store'])->name('user.profile');