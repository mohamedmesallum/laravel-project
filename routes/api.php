<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\TestUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReviewController;
use App\Models\Address;
use App\Models\Products;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
   // return $request->user();
//});
Route::get('/index',[TestUserController::class,'index']);
Route::post('/uplod',[TestUserController::class,'uplod']);
Route::post('/riister',[TestUserController::class,'riister']);
Route::post('/login',[TestUserController::class,'login']);
Route::post('/addBanner',[BannerController::class,'addBanner']);
Route::get('/getBanner',[BannerController::class,'getBanner']);
Route::post('/deletBanner/{id}',[BannerController::class,'deletBanner']);
Route::post('/addCategories',[CategoriesController::class,'addCategories']);
Route::get('/getCategories',[CategoriesController::class,'getCategories']);
Route::post('/deletCategories/{id}',[CategoriesController::class,'deletCategories']);
Route::post('/updateCategories',[CategoriesController::class,'updateCategories']);
Route::post('/addProducts',[ProductsController::class,'addProducts']);
Route::get('/getProducts',[ProductsController::class,'getProducts']);
Route::get('/getOneProducts/{id}',[ProductsController::class,'getOneProducts']);
Route::post('/deletProducts/{id}',[ProductsController::class,'deletProducts']);
Route::post('/getOneCategories',[ProductsController::class,'getOneCategories']);
Route::post('/updateProducts',[ProductsController::class,'updateProducts']);
Route::post('/addReview',[ReviewController::class,'addReview']);
Route::get('/getReview/{id}',[ReviewController::class,'getReview']);
Route::post('/deletReview',[ReviewController::class,'deletReview']);
Route::post('/updateReview',[ReviewController::class,'updateReview']);
Route::post('/addDeleteFavorites',[FavoritesController::class,'addDeleteFavorites']);
Route::post('/getFavorites',[FavoritesController::class,'getFavorites']); 
Route::post('/addDeleteCart',[CartController::class,'addDeleteCart']);  
Route::post('/getCart',[CartController::class,'getCart']);
Route::get('/getData',[HomeController::class,'getData']);
Route::post('/addOrders',[OrdersController::class,'addOrders']);
Route::post('/getOrders',[OrdersController::class,'getOrders']);
Route::get('/allOrders',[OrdersController::class,'allOrders']);
Route::post('/getOneOrder',[OrdersController::class,'getOneOrder']);
Route::post('/addAddress',[AddressController::class,'addAddress']);
Route::post('/getAddress',[AddressController::class,'getAddress']);
Route::post('/deleteAddress',[AddressController::class,'deleteAddress']);
Route::get('image/{path}', [BannerController::class, 'getImag'])->where('path', '.*');
//addOrders

Route::group([
   'middleware' => 'api',
   'prefix' => 'auth'
], function ($router) {
   Route::post('/login', [AuthController::class, 'login']);
   Route::post('/register', [AuthController::class, 'register']);
   Route::post('/logout', [AuthController::class, 'logout']);
   Route::post('/refresh', [AuthController::class, 'refresh']);
   Route::get('/user-profile', [AuthController::class, 'userProfile']);  
 
  
});