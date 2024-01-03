<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CartController extends Controller
{
    public function addDeleteCart(Request $request){
        $validator = Validator::make($request->all(), [
            'id_products' => 'required',
             'id_user' => 'required',
             'count'=>'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $check = Cart::where([['id_user','=',$request->id_user],['id_products','=',$request->id_products],
            ['order_status','=','0']
            ])->first();
            if($check){
                $deletFavorites=$check->delete($request->id);
                if($deletFavorites){
                    return response(['mesaage'=>'تم حذف العنصر بنجاح','statues'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
        
            }else{
                $add = Cart::create([
                    'id_products' => $request->id_products,
                    'id_user' => $request->id_user,
                    'count'=>$request->count
                ]);
                if($add){
                    return response(['mesaage'=>'تم اضافه العنصر بنجاح','statues'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
                
            }
        }
    }

    public function getCart(Request $request){
        $validator = Validator::make($request->all(), [
             'id_user' => 'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
           $checkUser = User::find($request->id_user);
           if($checkUser){
            $checkFavorites = Cart::where([['id_user','=',$request->id_user],['order_status','=','0']])
            ->join('products', 'products.id', '=', 'id_products')
            ->select('products.*','cart.*')->get();
           
            if($checkFavorites){
                return response(['data'=>$checkFavorites,'statues'=>200]);
            }else{
                return response(['statues'=>404,'error'=>'failed']);
            }
           }else{
            return response(['statues'=>404,'error'=>' not found user']);
           }
         
        }
      }
}
