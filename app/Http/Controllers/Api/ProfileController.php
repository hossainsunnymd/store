<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CustomerProfile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function createProfile(Request $request){

         $user_id=$request->header('id');

         CustomerProfile::updateOrCreate(
            ['user_id'=>$user_id],
            $request->input()
         );

         return response()->json([
            'status'=>'success',
            'message'=>'Profile created successfully'
         ]);

    }

    public function readProfile(Request $request){
        $user_id=$request->header('id');
         return CustomerProfile::where('user_id',$user_id)->first();
    }
}
