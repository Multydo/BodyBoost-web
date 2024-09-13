<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;

class getData extends Controller
{
    public function getBodyPart(Request $request){ 
        
        $bodyPart = $request["body_part"];
        if($request["lastId"]==-1){
           $firstId = Exercise::where('body_part', $bodyPart)
                        ->orderBy('id', 'asc')
                        ->select('id')
                        ->first();

            $reqId = $firstId["id"];
        }else{
            $reqId = $request["lastId"]+1 ;
        }


        
        $exerciseData = Exercise::where([
                                ['body_part', '=', $bodyPart],
                                ['id', '>=', $reqId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
        //dd($exerciseData);
        if($exerciseData){
            $moreId = $reqId +11 ;
            $moreExData = Exercise::where([
                                ['body_part', '=', $bodyPart],
                                ['id', '>=', $moreId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
            $state = true;
            if(!$moreExData){
                $state = false;
            }   
            //dd($exerciseData);
            return response()->json([
                "message" => "exercise data found",
                "state" => $state,
                "data" => $exerciseData
            ],200);

        }else{
            return response()->json([
                "message"=>"invalid body_part: $bodyPart or id: $reqId",
                "state"=>false,
                "data"=>""
            ],400);
        }
       
    }
}








class getData extends Controller
{
    public function getfunction(Request $request){
        
        $function = $request["function"];
        if($request["lastId"]==-1){
           $firstId = Exercise::where('function', $function)
                        ->orderBy('id', 'asc')
                        ->select('id')
                        ->first();

            $reqId = $firstId["id"];
        }else{
            $reqId = $request["lastId"]+1 ;
        }


        
        $exerciseData = Exercise::where([
                                ['function', '=', $fuction],
                                ['id', '>=', $reqId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
        //dd($exerciseData);
        if($exerciseData){
            $moreId = $reqId +11 ;
            $moreExData = Exercise::where([
                                ['function', '=', $function],
                                ['id', '>=', $moreId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
            $state = true;
            if(!$moreExData){
                $state = false;
            }   
            //dd($exerciseData);
            return response()->json([
                "message" => "exercise data found",
                "state" => $state,
                "data" => $exerciseData
            ],200);

        }else{
            return response()->json([
                "message"=>"invalid function: $function or id: $reqId",
                "state"=>false,
                "data"=>""
            ],400);
        }
       
    }
}


class getData extends Controller
{
    public function getmachine(Request $request){
        $function = $request["machine"];
        if($request["lastId"]==-1){
           $firstId = Exercise::where('machine', $machine)
                        ->orderBy('id', 'asc')
                        ->select('id')
                        ->first();

            $reqId = $firstId["id"];
        }else{
            $reqId = $request["lastId"]+1 ;
        }


        
        $exerciseData = Exercise::where([
                                ['machine', '=', $fuction],
                                ['id', '>=', $reqId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
        //dd($exerciseData);
        if($exerciseData){
            $moreId = $reqId +11 ;
            $moreExData = Exercise::where([
                                ['machine', '=', $machine],
                                ['id', '>=', $moreId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
            $state = true;
            if(!$moreExData){
                $state = false;
            }   
            //dd($exerciseData);
            return response()->json([
                "message" => "exercise data found",
                "state" => $state,
                "data" => $exerciseData
            ],200);

        }else{
            return response()->json([
                "message"=>"invalid machine: $machine or id: $reqId",
                "state"=>false,
                "data"=>""
            ],400);
        }
       
    }
}