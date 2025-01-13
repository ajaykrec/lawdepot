<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\Auth\AuthController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[AuthController::class, 'register']); 
Route::post('/login',[AuthController::class, 'login']); 

Route::group(['prefix' => 'master','middleware'=>['sanctum']],function(){

   //=== logout ===
   Route::get('/logout',[AuthController::class, 'logout']); 

});
