<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;

/**
 * @OA\Tag(
 *     name="Exercise",
 *     description="Operations related to exercise data retrieval"
 * )
 */
class getData extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/bodypart",
     *     summary="Retrieve exercises by body part",
     *     description="Fetches a list of exercises filtered by the specified body part with pagination support.",
     *     operationId="getBodyPartExercises",
     *     tags={"Exercise"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="body_part", type="string", example="chest"),
     *             @OA\Property(property="lastId", type="integer", example=-1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exercises retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="exercise data found"),
     *             @OA\Property(property="state", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Bench Press"),
     *                     @OA\Property(property="body_part", type="string", example="chest"),
     *                     @OA\Property(property="equipment", type="string", example="barbell"),
     *                     @OA\Property(property="target", type="string", example="pectorals"),
     *                     @OA\Property(property="secondary_muscles", type="string", example="triceps, deltoids"),
     *                     @OA\Property(property="instructions", type="string", example="Lie on a bench with a barbell...")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid body_part or id",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="invalid body_part: chest or id: 5"),
     *             @OA\Property(property="state", type="boolean", example=false),
     *             @OA\Property(property="data", type="string", example="")
     *         )
     *     )
     * )
     */
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
     /**
     * @OA\Post(
     *     path="/api/equipment",
     *     summary="Retrieve exercises by equipment",
     *     description="Fetches a list of exercises filtered by the specified equipment with pagination support.",
     *     operationId="getEquipmentExercises",
     *     tags={"Exercise"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="equipment", type="string", example="dumbbell"),
     *             @OA\Property(property="lastId", type="integer", example=-1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exercises retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="exercise data found"),
     *             @OA\Property(property="state", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="name", type="string", example="Dumbbell Curl"),
     *                     @OA\Property(property="body_part", type="string", example="biceps"),
     *                     @OA\Property(property="equipment", type="string", example="dumbbell"), 
     *                     @OA\Property(property="target", type="string", example="biceps"),
     *                     @OA\Property(property="secondary_muscles", type="string", example="forearms"),
     *                     @OA\Property(property="instructions", type="string", example="Stand with a dumbbell in each hand...")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid equipment or id",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="invalid equipment: dumbbell or id: 5"),
     *             @OA\Property(property="state", type="boolean", example=false),
     *             @OA\Property(property="data", type="string", example="")
     *         )
     *     )
     * )
     */

    public function getEquipment(Request $request){
        
        $equipment = $request["function"];
        if($request["lastId"]==-1){
           $firstId = Exercise::where('equipment', $equipment)
                        ->orderBy('id', 'asc')
                        ->select('id')
                        ->first();

            $reqId = $firstId["id"];
        }else{
            $reqId = $request["lastId"]+1 ;
        }


        
        $exerciseData = Exercise::where([
                                ['equipment', '=', $equipment],
                                ['id', '>=', $reqId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', '', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
        //dd($exerciseData);
        if($exerciseData){
            $moreId = $reqId +11 ;
            $moreExData = Exercise::where([
                                ['equipment', '=', $equipment],
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
                "message"=>"invalid equipment: $equipment or id: $reqId",
                "state"=>false,
                "data"=>""
            ],400);
        }
       
    }
    /**
     * @OA\Post(
     *     path="/api/target",
     *     summary="Retrieve exercises by target muscle",
     *     description="Fetches a list of exercises filtered by the specified target muscle with pagination support.",
     *     operationId="getTargetExercises",
     *     tags={"Exercise"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="target", type="string", example="biceps"),
     *             @OA\Property(property="lastId", type="integer", example=-1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Exercises retrieved successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="exercise data found"),
     *             @OA\Property(property="state", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="id", type="integer", example=3),
     *                     @OA\Property(property="name", type="string", example="Hammer Curl"),
     *                     @OA\Property(property="body_part", type="string", example="biceps"),
     *                     @OA\Property(property="equipment", type="string", example="dumbbell"),
     *                     @OA\Property(property="target", type="string", example="biceps"),
     *                     @OA\Property(property="secondary_muscles", type="string", example="forearms"),
     *                     @OA\Property(property="instructions", type="string", example="Hold a dumbbell in each hand...")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid target or id",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="invalid target: biceps or id: 5"),
     *             @OA\Property(property="state", type="boolean", example=false),
     *             @OA\Property(property="data", type="string", example="")
     *         )
     *     )
     * )
     */


    public function getTarget(Request $request){
        $target = $request["target"];
        if($request["lastId"]==-1){
           $firstId = Exercise::where('machine', $target)
                        ->orderBy('id', 'asc')
                        ->select('id')
                        ->first();

            $reqId = $firstId["id"];
        }else{
            $reqId = $request["lastId"]+1 ;
        }


        
        $exerciseData = Exercise::where([
                                ['target', '=', $target],
                                ['id', '>=', $reqId]
                            ])->take(10)
                            ->select('id', 'name', 'body_part', 'equipment', 'target', 'secondary_muscles', 'instructions')
                            ->get()
                            ->toArray();
        //dd($exerciseData);
        if($exerciseData){
            $moreId = $reqId +11 ;
            $moreExData = Exercise::where([
                                ['machine', '=', $target],
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
                "message"=>"invalid machine: $target or id: $reqId",
                "state"=>false,
                "data"=>""
            ],400);
        }
       
    }
    
}