<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function listProductByCategory(Request $request){
        $id = $request->id;
         return Cache::remember('listProductByCategory'.$id, 3600, function () use ($id) {
             return Product::where('category_id', $id)->get();
         });
    }

    public function listProductByBrand(Request $request){
        $id = $request->id;
         return Cache::remember('listProductByBrand'.$id, 3600, function () use ($id) {
             return Product::where('brand_id', $id)->get();
         });
    }

    public function listProductByRemark(Request $request){
        $remark = $request->remark;
         return Cache::remember('listProductByRemark'.$remark, 3600, function () use ($remark) {
             return Product::where('remark', $remark)->get();
         });
    }

    public function productDetailsById(Request $request){
        $id = $request->id;
         return Cache::remember('productDetailsById'.$id, 3600, function () use ($id) {
             return ProductDetail::where('product_id', $id)->with('product','product.category','product.brand')->first();
         });
    }

    public function listProductSlider(Request $request){
        return Cache::remember('listProductSlider', 3600, function () {
            return ProductSlider::all();
        });
    }

    public function listProductReview(Request $request){
        $id = $request->id;
        return Cache::remember('listProductReview'.$id, 3600, function () use ($id) {
            return ProductReview::where('product_id', $id)->with(['profile'=>function($query){
                $query->select('id','name');
            }])->get();
        });
    }


}
