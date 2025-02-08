<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
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

            $customerProfile=CustomerProfile::where('user_id',$user_id)->first();

        } catch (Exception $e) {
        }
    }
}
