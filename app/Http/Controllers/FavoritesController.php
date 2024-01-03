<?php

namespace App\Http\Controllers;

use App\Models\Favorites;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FavoritesController extends Controller
{
    public function addDeleteFavorites(Request $request){
        $validator = Validator::make($request->all(), [
            'id_products' => 'required',
             'id_user' => 'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $check = Favorites::where([['id_user','=',$request->id_user],['id_products','=',$request->id_products]])->first();
            if($check){
                $deletFavorites=$check->delete($request->id);
                if($deletFavorites){
                    return response(['mesaage'=>'تم حذف العنصر بنجاح','statues'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
            }else{
                $add = Favorites::create([
                    'id_products' => $request->id_products,
                    'id_user' => $request->id_user,
                ]);
                if($add){
                    return response(['mesaage'=>'تم اضافه العنصر بنجاح','statues'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
                
            }
        }
    }


      public function getFavorites(Request $request){
        $validator = Validator::make($request->all(), [
             'id_user' => 'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
           $checkUser = User::find($request->id_user);
           if($checkUser){
            $checkFavorites = Favorites::where('id_user','=',$request->id_user)
            ->join('products', 'products.id', '=', 'id_products')
            ->select('products.*')->get();
           
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
