<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\ProductCart;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function createInvoice(Request $request)
    {

        DB::beginTransaction();
        try {
            $user_id=$request->header('id');
            $user_email=$request->header('email');

            $tran_id=uniqid();
            $delivery_statusj='Pending';
            $payment_status='Pending';
            $customerProfile=CustomerProfile::where('user_id',$user_id)->first();

            $cus_details="Name:$customerProfile->cus_name,Address:$customerProfile->cus_add,City:$customerProfile->cus_city,Phone:$customerProfile->cus_phone";
            $ship_details="Name:$customerProfile->ship_name,Address:$customerProfile->ship_add,City:$customerProfile->ship_city,Phone:$customerProfile->ship_phone";
            $vatP=$request->input('vat');
            $cartList=ProductCart::where('user_id',$user_id)->get();
            $total=$cartList->sum('total');
            if($vatP>0){
               $vat=($total*$vatP)/100;
            }else{
                $vat=0;
            }
            $payable=$total+$vat;

            $invoice=Invoice::create([
                'user_id'=>$user_id,
                'total'=>$total,
                'vat'=>$vat,
                'payable'=>$payable,
                'cus_details'=>$cus_details,
                'ship_details'=>$ship_details,
                'tran_id'=>$tran_id,
                'delivery_status'=>$delivery_statusj,
                'payment_status'=>$payment_status,
            ]);
            foreach ($cartList as $cart){
                InvoiceProduct::create([
                    'invoice_id'=>$invoice->id,
                    'user_id'=>$user_id,
                    'product_id'=>$cart->product['id'],
                    'qty'=>$cart->qty,
                    'sale_price'=>$cart->total,
                ]);
            }
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Invoice created successfully']);


        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status'=>'error','message'=>$e->getMessage()]);
        }
    }
}
