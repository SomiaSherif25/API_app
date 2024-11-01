<?php

namespace App\Http\Traits;

trait ApiHandler{
    public function successMessage($msg){
        return response()->json([
            'status' => true,
            'msg' => $msg
        ]);
    }

    public function errorMessage($msg){
        return response()->json([
            'status' => false,
            'msg' => $msg
        ]);
    }

    public function returnData($key,$value,$msg){
        return response()->json([
            'status' => true,
            $key => $value,
           'msg' => $msg
        ]);
    }
}

