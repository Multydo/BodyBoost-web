<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class test extends Controller
{
    public function test(Request $request){
        return response()->json(true);
        }
        
}
