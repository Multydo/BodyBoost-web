<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\getData;
use App\Http\Controllers\API\UserController;
Route::post('/target',[getData::class,'getTarget']);


Route::post('/equipment',[getData::class,'getEquipment']);

Route::post('/bodypart',[getData::class,'getBodyPart']);
Route::post("/register",[UserController::class,"register"]);
Route::post("/login",[UserController::class,"login"]);