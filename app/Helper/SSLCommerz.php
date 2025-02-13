<?php

namespace App\Helper;

use App\Models\SslcommerzAccount;
use Exception;
use Illuminate\Support\Facades\Http;

class SSLCommerz{

    static function initiatePayment($customerProfile,$payable,$tran_id,$user_email){
        try{
            $ssl= SslcommerzAccount::first();
            // return $ssl;
            $response = Http::asForm()->post('https://sandbox.sslcommerz.com/gwprocess/v3/api.php',[
                "store_id"=>$ssl->store_id,
                "store_passwd"=>$ssl->store_pass,
                "total_amount"=>$payable,
                "currency"=>$ssl->currency,
                "tran_id"=>$tran_id,
                "success_url"=>"$ssl->success_url?tran_id=$tran_id",
                "fail_url"=>"$ssl->fail_url?tran_id=$tran_id",
                "cancel_url"=>"$ssl->cancel_url?tran_id=$tran_id",
                "ipn_url"=>$ssl->ipn_url,
                "cus_name"=>$customerProfile->cus_name,
                "cus_email"=>$user_email,
                "cus_add1"=>$customerProfile->cus_add,
                "cus_add2"=>$customerProfile->cus_add,
                "cus_city"=>$customerProfile->cus_city,
                "cus_state"=>$customerProfile->cus_city,
                "cus_postcode"=>"1200",
                "cus_country"=>$customerProfile->cus_country,
                "cus_phone"=>$customerProfile->cus_phone,
                "cus_fax"=>$customerProfile->cus_phone,
                "shipping_method"=>"YES",
                "ship_name"=>$customerProfile->ship_name,
                "ship_add1"=>$customerProfile->ship_add,
                "ship_add2"=>$customerProfile->ship_add,
                "ship_city"=>$customerProfile->ship_city,
                "ship_state"=>$customerProfile->ship_city,
                "ship_country"=>$customerProfile->ship_country ,
                "ship_postcode"=>"12000",
                "product_name"=>"Apple Shop Product",
                "product_category"=>"Apple Shop Category",
                "product_profile"=>"Apple Shop Profile",
                "product_amount"=>$payable,
            ]);

            return $response->json('desc');
        }catch (Exception $e){
            return [$ssl];
        }
    }

}
