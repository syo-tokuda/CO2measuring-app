<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MeasuringController;


Route::get('/a', function () {
    return view('welcome');
});

Route::get('/',[MeasuringController::class,'index']);
Route::post('/re',[MeasuringController::class,'store'])->name('user.profile');