<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;

class getData extends Controller
{
    // hasab l part l jasem li bade yeha
    public function getBodyPart(Request $request)
{
    
    $bodyPart = $request->input("body_part");
    $lastId = $request->input("lastId", -1); 

    if ($lastId == -1) {
      
        $firstRecord = Exercise::where('body_part', $bodyPart)
            ->orderBy('id', 'asc')
            ->select('id')
            ->first();

        if ($firstRecord) {
            $reqId = $firstRecord->id;
        } else {
            return response()->json([
                "message" => "No exercises found for the specified body_part.",
                "state" => false,
                "data" => []
            ], 404);
        }
    } else {
        $reqId = $lastId + 1;
    }

    
    $exerciseData = Exercise::where([
        ['body_part', '=', $bodyPart],
        ['id', '>=', $reqId]
    ])
    ->take(10)
    ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
    ->get();

    if ($exerciseData->isNotEmpty()) {
        $moreId = $reqId + 11;

        // 
        $hasMoreData = Exercise::where([
            ['body_part', '=', $bodyPart],
            ['id', '>=', $moreId]
        ])->exists();

        return response()->json([
            "message" => "Exercise data found",
            "state" => $hasMoreData,
            "data" => $exerciseData
        ], 200);
    } else {
        return response()->json([
            "message" => "No exercises found for body_part: $bodyPart or id: $reqId.",
            "state" => false,
            "data" => []
        ], 404);
        // by3ti esem l exercices li bade ye mn l body part mtl l daher for expl w bi dawer 3a tamarin hasab ltalab
        // bi haded n2tet l bideye hasab l last id 
        // eza l last id m ken mab3ut bi balech mn awl l data
        // eza ken fi data zyede byb3at json eno fi w by3rod be2e ldata
        // eza m ken fi byb3at eno m3ch fi data 
    }
}

}








{
    // hasab no3 l temrin
    public function getFunction(Request $request)
{
   
    $function = $request->input("function");
    $lastId = $request->input("lastId", -1); 

    
    if ($lastId == -1) {
        $firstRecord = Exercise::where('function', $function)
            ->orderBy('id', 'asc')
            ->select('id')
            ->first();

        if ($firstRecord) {
            $reqId = $firstRecord->id;
        } else {
            return response()->json([
                "message" => "No exercises found for the specified function.",
                "state" => false,
                "data" => []
            ], 404);
        }
    } else {
        $reqId = $lastId + 1;
    }

    
    $exerciseData = Exercise::where([
        ['function', '=', $function],
        ['id', '>=', $reqId]
    ])
    ->take(10)
    ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
    ->get();

    
    $hasMoreData = Exercise::where([
        ['function', '=', $function],
        ['id', '>=', $reqId + 11]
    ])->exists();

    
    if ($exerciseData->isNotEmpty()) {
        return response()->json([
            "message" => "Exercise data found",
            "state" => $hasMoreData,
            "data" => $exerciseData
        ], 200);
    } else {
        return response()->json([
            "message" => "No exercises found for function: $function or id: $reqId.",
            "state" => false,
            "data" => []
        ], 404);
        // bye5od wazife m3ayane mn l function mtl l owe masalan  w bi haded mn l last id eza ken mawjud aw la 
        // eza m ken l last id mab3ut mn abl bi balech bi awl l data 
        //  by3tina bs 10 tamarin hasab l chi l matlub meno w bi chuf eza fi baed data
        // eza ken fi data byb3at risele m3 json eno fi w by3rod be2e l exercices 
        // eza m ken be2e data byb3at error
    }
}

}


{
    // hasab l makana
    public function getMachine(Request $request)
{
    
    $machine = $request->input("machine");
    $lastId = $request->input("lastId", -1); 

    
    if ($lastId == -1) {
        $firstRecord = Exercise::where('machine', $machine)
            ->orderBy('id', 'asc')
            ->select('id')
            ->first();

        if ($firstRecord) {
            $reqId = $firstRecord->id;
        } else {
            return response()->json([
                "message" => "No exercises found for the specified machine.",
                "state" => false,
                "data" => []
            ], 404);
        }
    } else {
        $reqId = $lastId + 1;
    }

    
    $exerciseData = Exercise::where([
        ['machine', '=', $machine],
        ['id', '>=', $reqId]
    ])
    ->take(10)
    ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
    ->get();

    $hasMoreData = Exercise::where([
        ['machine', '=', $machine],
        ['id', '>=', $reqId + 11]
    ])->exists();


    if ($exerciseData->isNotEmpty()) {
        return response()->json([
            "message" => "Exercise data found",
            "state" => $hasMoreData,
            "data" => $exerciseData
        ], 200);
    } else {
        return response()->json([
            "message" => "No exercises found for machine: $machine or id: $reqId.",
            "state" => false,
            "data" => []
        ], 404);
        // lcode bi dawer 3a exercicet bi 5anet l machine li bade yeha eza m ken fi id mn abl bi balech bi awal wahad 3emlinlo enregistrer
        // awl mara by3tine bs 10 tamarin m3 baed w bi chuf eza baed fi data mawjude bi alb machine
        // l ajwibe btruh 3a json li byb3at ll user true eza fi baed data aw false eza ken 5alsa l data
        // l data bteje tahet ba3da mtl l array
    }
}

        }
       
  