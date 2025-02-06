<?php

namespace App\Http\Controllers\Api;

use App\Helper\JWTToken;
use App\Http\Controllers\Controller;
use App\Jobs\SendOtpJob;
use App\Mail\OtpMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userLogin(Request $request){
      try{
        $userEmail=$request->query('email');
        $otp=mt_rand(1000,9999);
        SendOtpJob::dispatch($userEmail,new OtpMail($otp));
        User::updateOrCreate(['email' => $userEmail], ['otp' => $otp] );
        return response()->json(['status'=>'success'.$otp,'message'=>'Otp has been send to your email. Please check your email.']);
      }catch(Exception $e){
        return response()->json(['status'=>'fail','message'=>'Something went wrong.']);
      }
    }
    public function verifyLogin(Request $request){

        $userEmail=$request->input('email');
        $otp=$request->input('otp');
        $verify=User::where('email',$userEmail)->where('otp',$otp)->first();
        if($verify){
            User::where('email',$userEmail)->where('otp',$otp)->update(['otp'=>'0']);
            $token=JWTToken::createToken($userEmail,$verify->id);
            return response()->json(['status'=>'success','message'=>'Login successfull','token'=>$token])->cookie('token',$token,60*24*30);
        }else{
            return response()->json(['status'=>'fail','message'=>'Login failed']);
        }
    }
}
