<?php

namespace App\Http\Controllers;

use apiRes;
use App\Models\TestUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Symfony\Contracts\Service\Attribute\Required;

class TestUserController extends Controller
{


    function uplod(Request $request){
        
        $imge = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->store('User','chatgpt'); 
        dd($request->file('image'));
       // return storage_path($path);
   // $imge = $request->file('image')->getClientOriginalName();
  //  $path = $request->file('image')->move('TestUser',$imge);
    //storeAs('public/images/TestUser',$imge,'test');
    //$fileDTO->filePath = Storage::url($fileEntity->file_name);
    //return 
 // Storage::url($path,$imge);
 
 }
 //  function uplod(Request $request){
    //$imageName =Str::random().'.'.$request->file('image')->getClientOriginalExtension();
    //Storage::disk('public')->put($request->image,$imageName);
           
    //  $imge = $request->file('image')

  //}
    
  
  
    function index(){
        $res = TestUser::all();
        $resbonsbody=[
            'data'=>$res,
            'status'=>200,
            'message'=>'ok'
        ];

        return response()->json($resbonsbody);
    }
       function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            $araay = [
                'statues'=>'404',
                'error'=>$validator->errors(),
                

            ];
            return response($araay);
        }
        $res = TestUser::where('email',$request->email)->first();
        if($res){
            if(hash::check($request->password,$res->password)){
                $resbonsbody=[
                    'data'=>$res,
                    'status'=>200,
                    'message'=>'ok'
                ];
        
                return response()->json($resbonsbody);
            
             }
             $Errors=[
                'Error'=>'Erorr',
                'status'=>404,
                'message'=>'The password is not valid'
            ];
             return response(['Error'=>'Erorr','message'=>'The password is not valid','status'=>404,]);

        }
        $Errors=[
            'Error'=>'Erorr',
            'status'=>404,
            'message'=>'The email is not valid'
        ];
      
         return response($Errors);
      
       }

    function riister(Request $request){

        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'name' =>' required',
            'password' => 'required',
        ]);
        if($validator->fails()){
            $araay = [
                'statues'=>'404',
                'error'=>$validator->errors(),

            ];
            return response($araay);
        }
       $image = $this->uplod($request);
        $res= TestUser::create([
            'name' =>$request->name,
            'email' =>$request->email,
            'password' =>Hash::make($request->password),
            'token'=> Str::random(60),
           'image'=> $image,

        ]);
        $araay=[
            'data'=>$res,
            'status'=>200,
        ];
        return response()->json($araay);
        
    }
}
