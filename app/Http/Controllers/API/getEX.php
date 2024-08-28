<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exercise;
use App\Models\target;
use Illuminate\Support\Facades\Http;

class getEX extends Controller
{
     /*public function fetchAndSaveExercises()
    {
        // Define the API endpoint and headers
        $url = "https://exercisedb.p.rapidapi.com/exercises/target/upper%20back?offset=1&limit=2000";
        $headers = [
            "x-rapidapi-key" => "2482707fbbmsh4a5ed99c5191f4cp14ff5bjsnfc6b81e723f4", // Replace with your actual RapidAPI key
            "x-rapidapi-host" => "exercisedb.p.rapidapi.com"
        ];

        try {
            // Fetch the data from the API
            $response = Http::withHeaders($headers)->get($url);
            $exercises = $response->json();

            // Loop through the data and save each exercise to the database
            foreach ($exercises as $exercise) {
                target::updateOrCreate(
                    
                    [
                        'name' => $exercise['name'],
                        'body_part' => $exercise['bodyPart'],
                        'equipment' => $exercise['equipment'],
                        'target' => $exercise['target'],
                        'secondary_muscles' => json_encode($exercise['secondaryMuscles']),
                        'instructions' => json_encode($exercise['instructions']),
                        'gif_url' => $exercise['gifUrl']
                    ]
                );
            }

            return response()->json(['status' => 'success', 'message' => 'Data fetched and saved successfully.']);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }*/
}