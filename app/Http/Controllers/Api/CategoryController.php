<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CategoryController extends Controller
{
    public function categoryList(){
        $data=Cache::remember('categoryList', 3600, function () {
            return Category::all();
        });

        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);

    }
}
