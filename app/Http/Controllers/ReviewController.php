<?php

namespace App\Http\Controllers;

use App\Models\Products;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ReviewController extends Controller
{
    public function addReview(Request $request){
        $validator = Validator::make($request->all(), [
            'id_product' => 'required',
             'id_user' => 'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            if($request->ratings || $request->comment){
                $res= Review::create([
                    'id_product' =>$request->id_product,
                    'id_user'=>$request->id_user,
                  'ratings'=>$request->ratings,
                  'comment'=>$request->comment,
                ]);
                if($res){
                    return response(['message'=>'It has been added successfully','status'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
            }else{
                return response(['statues'=>404,'error'=>'null']);
            }
        
        }

    }

    public function getReview($id){
        $checkid=Products::find($id);
        if($checkid){
            $res=  Review::where('id_product',$id)->get();
            if($res){
                return response(['data'=>$res,'status'=>200]);
            }
            return response(['statues'=>404,'error'=>'failed']);
        }else{
            return response(['statues'=>404,'error'=>'not found Products']); 
        }
      
    }


    public function deletReview(Request $request){
        $validator = Validator::make($request->all(), [
            'id_product' => 'required',
             'id_user' => 'required',
             'id'=>'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $res=  Review::where([['id','=',$request->id],['id_user','=',$request->id_user],['id_product','=',$request->id_product]])->first();
        
            if($res){
                $deletResponse=$res->delete($request->id);
                if($deletResponse){
                    return response(['message'=>'Deleted successfully','status'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
            }else{
                return response(['statues'=>404,'error'=>'not found Products']); 
            }
        }
    }

    public function updateReview(Request $request){
        $validator = Validator::make($request->all(), [
            'id_product' => 'required',
             'id_user' => 'required',
             'id'=>'required',
        ]);
        if($validator->fails()){
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }else{
            $res=  Review::where([['id','=',$request->id],['id_user','=',$request->id_user],['id_product','=',$request->id_product]])->first();
        
            if($res){
                $updates = $res->fill($request->post())->update();
                if($updates){
                    return response(['data'=>$res,'message'=>'update successfully','status'=>200]);
                }else{
                    return response(['statues'=>404,'error'=>'failed']);
                }
            }else{
                return response(['statues'=>404,'error'=>'not found Products']); 
            }
        }
    }
}
