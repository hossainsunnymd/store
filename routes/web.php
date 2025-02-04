<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\MaintenenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/brand-list',[BrandController::class,'brandList']);
Route::get('/clear-cache',[MaintenenceController::class,'clearAppCache']);
