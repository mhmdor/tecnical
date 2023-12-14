<?php
namespace App\Traits;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
trait RestfulTrait{

    public function apiResponse($data = null  , $code = 200 , $message = null ){
        $arrayResponse = [
            'data' => $data ,
            'status' => $code == 200 || $code==201 || $code==204 || $code==205 ,
            'message' => $message ,
            'code' => $code ,
        ];
       
        //return with header response accept application/json

        // return response()->json($arrayResponse,$code);
        return response($arrayResponse,$code)->withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ]);
    }
    public function apiValidation($request , $array){
        $validator = Validator::make($request->all(), $array);
        if ($validator->fails()) {
            return $this->apiResponse(null, ApiController::STATUS_VALIDATION, $validator->messages());
        }
        return $validator->valid();
    }
}
