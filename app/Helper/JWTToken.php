<?php

namespace App\Helper;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTToken{

    public static function createToken($userEmail,$userId){
        $key=env('JWT_KEY');
        $payload=[
                'iss'=>'laravel',
                'iat'=>time(),
                'exp'=>time()+60*60,
                'userEmail'=>$userEmail,
                'userId'=>$userId
        ];
        return JWT::encode($payload,$key,'HS256');
    }

    public static function verifyToken($token){
      try{
        if($token==null){
            return 'unauthorize';
        }
        $key=env('JWT_KEY');
        $decode=JWT::decode($token,new Key($key,'HS256'));
        return $decode;
      }catch(Exception $e){
        return 'unauthorize';
      }
    }

}
