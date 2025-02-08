<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\MaintenenceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/clear-app-cache', [MaintenenceController::class,'clearAppCache']);
