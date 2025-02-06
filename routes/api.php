<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PolicyController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//Brand List
Route::get('/brand-list',[BrandController::class,'brandList']);

//Category List
Route::get('/category-list',[CategoryController::class,'categoryList']);

//Product List By Category
Route::get('/list-product-by-category/{id}',[ProductController::class,'listProductByCategory']);

//Product List By Brand
Route::get('/list-product-by-brand/{id}',[ProductController::class,'listProductByBrand']);

//Product List By Remark
Route::get('/list-product-by-remark/{remark}',[ProductController::class,'listProductByRemark']);

//Product Slider
Route::get('/list-product-slider',[ProductController::class,'listProductSlider']);

//Product details
Route::get('/product-details-by-id/{id}',[ProductController::class,'productDetailsById']);

//Product Reviews
Route::get('/list-product-review',[ProductController::class,'listProductReview']);

//policy
Route::get('/policy-by-type/{type}',[PolicyController::class,'policyByType']);

//user auth
Route::get('/user-login',[UserController::class,'userLogin']);
Route::post('/verify-login',[UserController::class,'verifyLogin']);
Route::get('/user-logout',[UserController::class,'userLogout']);


//user Profile
Route::post('/create-profile',[ProfileController::class,'createProfile'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/read-profile',[ProfileController::class,'readProfile'])->middleware([TokenVerificationMiddleware::class]);

//product review
Route::post('/create-product-review',[ProductController::class,'createProductReview'])->middleware([TokenVerificationMiddleware::class]);
