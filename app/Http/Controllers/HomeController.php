<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Categories;
use App\Models\Products;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class HomeController extends Controller
{
 
    public function getData(Request $request){
    try{
      //    $token = $request->header(key:'auth_token');
     // $user = JWTAuth::setToken($token)->toUser();
      //if($user != null){
     
               $getCartigres= Categories::where('home','!=','1')->get();
               $getBanner = Banner::all();
               $getDiscountn = Products::where('discount','!=','0')->get();
               $getPopular = Categories::select('id')->where('name','=','Popular')->get();
               $getBestChoice = Categories::select('id')->where('name','=','Best Choice')->get();
               $Popular = Products::where('categories_id','=',$getPopular[0]['id'])->get();
               $BestChoice = Products::where('categories_id','=',$getBestChoice [0]['id'])->get();
       
       
               
       
               return response(['Categories'=>$getCartigres,'Banner'=>$getBanner,'Discount'=>$getDiscountn,
               'Popular'=>$Popular,'Best Choice'=>$BestChoice,'statues'=>200]);
              }catch( Exception $error){
                 return response(['statues'=>404,'error'=>'failed']);
              }
         }

 
      
       

    
}
