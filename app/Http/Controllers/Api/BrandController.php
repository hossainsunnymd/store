<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    public function brandList()
{
    return Cache::remember('brandList', 3600, function () {
        return Brand::all();
    });


}

}
