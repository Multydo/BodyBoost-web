<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\getData;
route::post('functions',[getData::class,'getfunction']);


route::post('machines',[getData::class,'getmachine']);

route::post('bodyParts',[getData::class,'getBodyPart']);