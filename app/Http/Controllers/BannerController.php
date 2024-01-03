<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    function uplod(Request $request){
        $imge = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('Banner',$imge,'test');       
        return $path;
    }

    public function addBanner(Request $request ){
        $validator = Validator::make($request->all(), [
            'categorieId' => 'required',
            'image' =>'required |mimes:png,PNG,JPG|max:2048',
            //JPEG/
        ]);
        if($validator->fails()){
    
            return response(['statues'=>'404','error'=>$validator->errors()]);
        }
       $image = $this->uplod($request);
        $res= Banner::create([
            'categorieId' =>$request->categorieId,
           'image'=> $image,
        ]);
        if($res){
            return response(['data'=>$res,'message'=>'It has been added successfully','status'=>200]);

        }
        return response(['statues'=>404,'error'=>'failed']);


    }
public function getImag($path){
    $image = Storage::url($path);
    return response($image, 200);
   
}

    public function getBanner(){
        $res = Banner::all();
        if($res){
            return response(['data'=>$res,'status'=>200]);
        }
        return response(['statues'=>404,'error'=>'failed']);
    }

    public function deletBanner($id){
        $res=  Banner::find($id);
        if($res){
                 
            $deletBaneer=$res->delete($id);
            if($deletBaneer){
                return response(['message'=>'Deleted successfully','status'=>200]);
            }
            return response(['statues'=>404,'error'=>'failed']);
        }
        return response(['message'=>'not found','statues'=>404,'error'=>'failed']);

    }
}
