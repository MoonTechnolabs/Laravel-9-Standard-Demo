<?php

namespace App\Http\Traits;

trait Common {
    public static function response($data, $msg, $code)
    {
        $response = [
            'status' => $code == 200 ? true : false,
            'code' => $code,
            'msg' => $msg,
            'version' => '1.0.0',
            'data' => $data
        ];
        return response()->json($response, $code);
    }

    public static function success($data = [], $msg = 'Success', $code = 200)
    {
        return self::response($data, $msg, $code);
    }

    /* Fail Respnose */

    public static function fail($data = [], $msg = "Some thing wen't wrong!", $code = 203)
    {
        return self::response($data, $msg, $code);
    }

     /* Generate Security Code */

     public static function generateSecurityCode()
     {
         $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890@#$';
         $pass = array(); //remember to declare $pass as an array
         $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
         for ($i = 0; $i < 6; $i++) {
             $n = rand(0, $alphaLength);
             $pass[] = $alphabet[$n];
         }
         return implode($pass); //turn the array into a string
     }
}