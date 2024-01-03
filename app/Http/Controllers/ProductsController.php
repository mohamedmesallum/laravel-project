<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProductsController extends Controller
{
    function upload(Request $request){
        $imge = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('Products',$imge,'upload');       
       dd($path);
       // public_path($path);
    }


    public function addProducts(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|String',
            'name_ar'=>'required|String',
            'image' =>'required |mimes:png,PNG,JPG|max:2048',
            'description'=>'required|String',
            'description_ar'=>'required|String',
            'priec'=>'required',
            'categories_id'=>'required',
    
        ]);
        if($validator->fails()){
    
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }
       $image = $this->uplod($request);
        $res= Products::create([
            'name' =>$request->name,
            'name_ar'=>$request->name_ar,
           'image'=> $image,
           'description'=>$request->description,
           'description_ar'=>$request->description_ar,
           'priec'=>$request->priec,
           'categories_id'=>$request->categories_id,
           'status'=>$request->status,
           'oldpriec'=>$request->oldpriec,
           'discount'=>$request->discount,
           'count'=>$request->count
        ]);
        if($res){
            return response(['data'=>$res,'message'=>'It has been added successfully','status'=>200]);
        }
        return response(['statues'=>404,'error'=>'failed']);
    }

    public function getProducts(){
        $res = Products::all();
        if($res){
            return response(['data'=>$res,'status'=>200]);
        }
        return response(['statues'=>404,'error'=>'failed']);
    }
       
    public function getOneProducts($id){
        $res=  Products::find($id);
        $getReview = Review::where('id_product','=',$id)
        ->join('Users', 'Users.id', '=', 'id_user')
        ->select('review.*','users.name','users.image')
        ->get();
        if($res){
            return response(['data'=>$res,'review'=>$getReview,'status'=>200]);
        }
        return response(['statues'=>404,'error'=>'not found']);

    }
     

    public function deletProducts($id){
        $res=  Products::find($id);
        if($res){
          $deletResponse=$res->delete($id);
          if($deletResponse){
            return response(['message'=>'Deleted successfully','status'=>200]);
          }
          return response(['statues'=>404,'error'=>'failed']);
        }
        return response(['statues'=>404,'error'=>'not found']);
    }

   
    public function getOneCategories(Request $request ){
        $validator = Validator::make($request->all(), [
            'categories_id'=>'required',
        ]);
        if($validator->fails()){
    
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $res=  Products::where('categories_id',$request->categories_id)->get();
            if($res){
                return response(['data'=>$res,'statues'=>200]);
            }
            return response(['statues'=>'404','message'=>'not found']);
        }
    }

    public function updateProducts(Request $request){
       $checkid =  Products::find($request->id);
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
