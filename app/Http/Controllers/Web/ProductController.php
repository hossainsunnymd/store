<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use App\Models\Product;
use App\Models\ProductCart;
use App\Models\ProductDetail;
use App\Models\ProductReview;
use App\Models\ProductSlider;
use App\Models\ProductWish;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function listProductByCategory(Request $request)
    {
        $id = $request->id;
        return Cache::remember('listProductByCategory' . $id, 3600, function () use ($id) {
            return Product::where('category_id', $id)->get();
        });
    }

    public function listProductByBrand(Request $request)
    {
        $id = $request->id;
        return Cache::remember('listProductByBrand' . $id, 3600, function () use ($id) {
            return Product::where('brand_id', $id)->get();
        });
    }

    public function listProductByRemark(Request $request)
    {
        $remark = $request->remark;
        return Cache::remember('listProductByRemark' . $remark, 3600, function () use ($remark) {
            return Product::where('remark', $remark)->get();
        });
    }

    public function productDetailsById(Request $request)
    {
        $id = $request->id;
        return Cache::remember('productDetailsById' . $id, 3600, function () use ($id) {
            return ProductDetail::where('product_id', $id)->with('product', 'product.category', 'product.brand')->first();
        });
    }

    public function listProductSlider(Request $request)
    {
        return Cache::remember('listProductSlider', 3600, function () {
            return ProductSlider::all();
        });
    }

    public function listProductReview(Request $request)
    {
        $product_id = $request->id;

            return ProductReview::where('product_id', $product_id)->with(['customerProfile' => function ($query) {
                $query->select('id', 'cus_name');
            }])->get();

    }

    public function createProductReview(Request $request)
    {

        $user_id = $request->header('id');
        $profile = CustomerProfile::where('user_id', $user_id)->first();
        if ($profile) {
            ProductReview::updateOrCreate(
                ['customer_profile_id' => $profile->id, 'product_id' => $request->input('product_id')],
                $request->input()
            );
            return response()->json(['status' => 'success', 'message' => 'Review created successfully']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Something went wrong.']);
        }
    }

    public function createWishList(Request $request)
    {
        try {
            $user_id = $request->header('id');
            ProductWish::updateOrCreate(
                ['user_id' => $user_id, 'product_id' => $request->query('product_id')],
            );
            return response()->json(['status' => 'success', 'message' => 'WishList created successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'fail', 'message' => 'Something went wrong.']);
        }
    }

    public function productWishList(Request $request)
    {
        $user_id = $request->header('id');
        return Cache::remember('listWishList' . $user_id, 3600, function () use ($user_id) {
            return ProductWish::where('user_id', $user_id)->with('product')->get();
        });
    }

    public function deleteWishList(Request $request)
    {
        $user_id = $request->header('id');
        ProductWish::where('user_id', $user_id)->where('product_id', $request->query('product_id'))->delete();
        return response()->json(['status' => 'success', 'message' => 'WishList deleted successfully']);
    }

    public function createCartList(Request $request){
        try{
            $user_id=$request->header('id');
            $product_id=$request->input('product_id');
            $color=$request->input('color');
            $size=$request->input('size');
            $qty=$request->input('qty');

            $unitPrice=0;

            $product=Product::where('id',$product_id)->first();
            if($product->discount==1){
                $unitPrice=$product->discount_price;
            }else{
                $unitPrice=$product->price;
            }

            $totalPrice=$unitPrice*$qty;

            ProductCart::updateOrCreate(
            ['user_id'=>$user_id,'product_id'=>$product_id],
                ['qty'=>$qty,'total'=>$totalPrice,'color'=>$color,'size'=>$size]
            );
            return response()->json(['status'=>'success','message'=>'Product added to cart successfully']);
        }catch(Exception $e){
            return response()->json(['status'=>'fail','message'=>'Something went wrong.']);
        }
    }

    public function productCartList(Request $request){
        $user_id=$request->header('id');
            return ProductCart::where('user_id',$user_id)->with('product')->get();
    }

    public function deleteCartList(Request $request){
        $user_id=$request->header('id');
        $product_id=$request->query('product_id');
        ProductCart::where('user_id',$user_id)->where('product_id',$product_id)->delete();
        return response()->json(['status'=>'success','message'=>'Product deleted from cart successfully']);
    }
}
