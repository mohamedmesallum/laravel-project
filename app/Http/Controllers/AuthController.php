<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','refresh']]);
    }
    function uplod(Request $request){
        $imge = $request->file('image')->getClientOriginalName();
        $path = $request->file('image')->storeAs('user',$imge,'upload');
        
        return $path;

    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $res = User::where('email',$request->email)->first();
        if($res){
            if(hash::check($request->password,$res->password)){
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 422);
                }
                if (! $token = auth()->attempt($validator->validated())) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
                return $this->createNewToken($token);

            }else{
                return response([
                    'error'=>'The password is not valid',
                    'status'=>404,
                ]);
            }
    
        } else{
            return response([
                'error'=>'The email is not valid',
                'status'=>404,


            ]);
        }
 

     
    }
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string',
            'password' => 'required',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(),400);
        }
        $res = User::where('email',$request->email)->first();
        if($res){
            return response([
                'error'=>'The email address is already in use',
                'status'=>404,

            ]);
        }else{
          //  $image = $this->uplod($request);
            $user = User::create(array_merge(
                $validator->validated(),
                ['password' => bcrypt($request->password)],
               // 'image' -> $request->$image,
            ));

            
            if (! $token = auth()->attempt($validator->validated())) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return $this->createNewToken($token);

        }
      
     
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth(),
            'user' => auth()->user(),
            'status'=>200,
        ]);
    }
}
