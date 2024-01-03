<?php


if(!function_exists('responseData')){
    function responseData($data,$message='',$status=200){
   return response(
        [
            'data'=>$data,
            'message'=>$message,
            'status'=>$status,
        ]

        );
    }
};