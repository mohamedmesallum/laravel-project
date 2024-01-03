<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Orders;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Address;



class OrdersController extends Controller
{
    public function allOrders(){
        $getOrders = Orders::all();
        return response(['Orders'=>$getOrders,'message'=>'successfully','status'=>200]);

    }
  
    public function addOrders(Request $request){
        $validator = Validator::make($request->all(), [
           'id_user' => 'required',
            'price_orders'=>'required',
            'id_address' =>'required',
            'coupon_order'=>'required',
            'payment_method'=>'required',
            'orders_typ'=>'required',
        
        ]);
        if($validator->fails()){
    
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $res= Orders::create([
                'id_user' =>$request->id_user,
                'price_orders'=>$request->price_orders,
               'id_address'=> $request->id_address,
               'coupon_order'=>$request->coupon_order,
               'payment_method'=>$request->payment_method,
               'orders_typ'=>$request->orders_typ,
            ]);
            if($res){
                $mixId= Orders::max('id_orders');
                $UpCart = Cart::where([['id_user','=',$request->id_user],['order_status','=','0']])
                ->update(['order_status'=>$mixId]);

                return response(['orders'=>$res,'message'=>'It has been added successfully','MaxId'=>$mixId,'status'=>200]);
            }
            return response(['statues'=>404,'error'=>'failed']);
        }

    }


    public function getOrders(Request $request){
        $validator = Validator::make($request->all(), [
            'id_user' => 'required',
       ]);
       if($validator->fails()){
           return response(['statues'=>'404','error'=>$validator->errors()]);
       }else{
        $checkUser = User::find($request->id_user);
        if($checkUser){
            $dataOrdresWitaing = Orders::where([['id_user','=',$request->id_user],['status_order','=','0']])
            ->get();
            $dataOrdresComplet = Orders::where([['id_user','=',$request->id_user],['status_order','=','1']])
            ->get();
        
            $dataOrdresRejected = Orders::where([['id_user','=',$request->id_user],['status_order','=','3']])
            ->get();
        
        return response(['OrdresWitaing'=>$dataOrdresWitaing,'OrdresComplete'=>$dataOrdresComplet,
        'OrdresRejected'=>$dataOrdresRejected,
        'message'=>'successfully','status'=>200]);

        }else{
            return response(['statues'=>404,'error'=>' not found user']);
           }
       }
    }

   public function getOneOrder(Request $request){
    $validator = Validator::make($request->all(), [
        'id_user' => 'required',
        'id_orders'=>'required',
    
   ]);
   if($validator->fails()){
       return response(['statues'=>'404','error'=>$validator->errors()]);
   }else{
    $checkUser = User::find($request->id_user);
    if($checkUser){
        $items = Cart::where([['id_user','=',$request->id_user],['order_status','=',$request->id_orders]])
        ->join('products', 'products.id', '=', 'cart.id_products')
        ->select('products.*','cart.*')
        ->get();
        $dataOrdre = Orders::where([['id_user','=',$request->id_user],['id_orders','=',$request->id_orders]])
        ->get();
          $addres = Address::where([['id_addres','=',$request->id_addres]])
          ->select('addresses.*')->get();
       
        if($items){
            return response(['data'=>$items,'dataOrdre'=>$dataOrdre,'dataaddres'=>$addres,
            'message'=>'successfully','status'=>200]);
        }else{
            return response(['statues'=>404,'error'=>'fiuier']);  
        }

    }else{
        return response(['statues'=>404,'error'=>' not found user']);   
    }
   }
   }
}
