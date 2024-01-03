<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;


class AddressController extends Controller
{
    public function addAddress(Request $request){
        $validator = Validator::make($request->all(), [
           'id_user' => 'required',
            'name'=>'required',
            'Latitude' =>'required',
            'Longitude'=>'required',

        
        ]);
        if($validator->fails()){

            return response(['statues'=>404,'error'=>$validator->errors()]);
        }else{
            $res= Address::create([
                'id_user' =>$request->id_user,
                'name'=>$request->name,
               'Latitude'=> $request->Latitude,
               'Longitude'=>$request->Longitude,
               'phone_addres'=>$request->phone_addres,
               'nots_addres'=>$request->nots_addres,
            ]);
            if($res){
                return response(['message'=>'It has been added successfully','statues'=>200]);
            }else{
                return response(['statues'=>404,'error'=>'failed']);
            }

    }
}

public function getAddress(Request $request){
    $validator = Validator::make($request->all(), [
         'id_user' => 'required',
    ]);
    if($validator->fails()){
        return response(['statues'=>'404','error'=>$validator->errors()]);
    }else{
       $checkUser = User::find($request->id_user);
       if($checkUser){
        $checkAddress =Address::where('id_user','=',$request->id_user)
        ->select('addresses.*')->get();
       
        if($checkAddress){
            return response(['data'=>$checkAddress,'statues'=>200]);
        }else{
            return response(['statues'=>404,'error'=>'failed']);
        }
       }else{
        return response(['statues'=>404,'error'=>' not found user']);
       }
     
    }
  }


  public function deleteAddress(Request $request){

    $validator = Validator::make($request->all(), [
        'id_user' => 'required',
        'id_addres'=>'required',
   ]);
   if($validator->fails()){
    return response(['statues'=>'404','error'=>$validator->errors()]);
   }else{
    $checkUser= User::find($request->id_user);
    if($checkUser){
        $res=  Address::where([['id_user','=',$request->id_user],['id_addres','=',$request->id_addres]])->delete();
if($res){
    return response(['message'=>'Deleted successfully','status'=>200]);
    
    }
return response(['statues'=>'404','error'=>'error']);

}
return response(['statues'=>'404','error'=>'user not fonde']);

        }
    
}
}

  

