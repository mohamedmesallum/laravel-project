<?php

namespace App\Http\Controllers;

use App\Models\Categories as ModelsCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoriesController extends Controller
{
    function uplod(Request $request){
        $imge = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('Categories',$imge,'upload');       
        return $path;
    }
    public function addCategories(Request $request ){
        $validator = Validator::make($request->all(), [
            'name' => 'required|String',
            'name_ar'=>'required|String',
            'image' =>'required |mimes:png,PNG,JPG|max:2048',
            //JPEG/
        ]);
        if($validator->fails()){
    
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }
       $image = $this->uplod($request);
        $res= ModelsCategories::create([
            'name' =>$request->name,
            'name_ar'=>$request->name_ar,
           'image'=> $image,
        ]);
        if($res){
            return response(['data'=>$res,'message'=>'It has been added successfully','status'=>200]);

        }
        return response(['statues'=>404,'error'=>'failed']);


    }

    public function getCategories(){
        $res =ModelsCategories::all();
        if($res){
            return response(['data'=>$res,'status'=>200]);
        }
        return response(['statues'=>404,'error'=>'failed']);
    }

    public function deletCategories($id){
        $res=  ModelsCategories::find($id);
        if($res){
            $deletBaneer=$res->delete($id);
            if($deletBaneer){
                return response(['message'=>'Deleted successfully','status'=>200]);
            }
            return response(['statues'=>404,'error'=>'failed']);
        }
        return response(['message'=>'not found','statues'=>404,'error'=>'failed']);

    }
    public function  updateCategories(Request $request){
        $checkid =  ModelsCategories::find($request->id);
        if($checkid){
         $res = $checkid->fill($request->post())->update();
         if($res){
             return response(['data'=>$checkid,'message'=>'update successfully'],200);
         }
         return response(['statues'=>404,'error'=>'failed']);
        }else
       return response(['statues'=>404,'error'=>'not found']);
    }
  



}
//id	name	name_ar	image	
