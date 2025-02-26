<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use App\Http\Resources\Journey as JourneyResource;
use Exception as GlobalException;
use Illuminate\Support\Facades\DB;



class JourneyApiController extends Controller
{

    public function index()
    {
        
            $journeys = Journey::with('points')->get();
            return response()->json([
                "journeys" => $journeys,

            ]);
         
    }

    public function show(Journey $journey)
    {
        try {
            if ($journey) {

                $points = DB::table('points')->select(
                    'id',
                    'journey_id',
                    'order',
                    'point_description',
                    'image',
                    DB::raw('ST_AsText(location) as location')
                )->where('journey_id', $journey->id)->get();

                $points = $points->map(function ($point) {
                    $pointArray = (array) $point;
                    foreach ($pointArray as $key => $value) {
                        if (is_string($value)) {
                            $pointArray[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                        }
                    }
                    $pointArray['location'] = $this->parsePoint($pointArray['location']);
                    return $pointArray;
                });

                return response()->json([
                    "journey" => new JourneyResource($journey),
                    "points" => $points
                ], 200);
            }
            else {
                return response()->json(["message" => "The journey is missing!"], 404);
            }
        } catch (GlobalException $e) {
            return response()->json(["message" => "An error occurred.", "error" => $e->getMessage()], 500);
        }
    }
    private function parsePoint(string $pointString) {
        preg_match('/POINT\(([-+]?[0-9]*\.?[0-9]+)\s([-+]?[0-9]*\.?[0-9]+)\)/', $pointString, $matches);
         return
         [
            'longitude' => $matches[1] ?? null,
             'latitude' => $matches[2] ?? null,
         ];
       }
}
