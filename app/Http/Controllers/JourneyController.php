<?php

namespace App\Http\Controllers;

use App\Models\Journey;
use Illuminate\Http\Request;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Journey as JourneyResource;
use Illuminate\Support\Facades\Event;
use App\Events\CreateJourney;
use App\Events\EditJourney;



class JourneyController extends Controller
{
    use SoftDeletes;

    public function index()
    {
        $journeys = Journey::paginate(10);
        return view('journey.index',compact('journeys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('journey.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'headline' => ['bail','required','string'],
            'start_day' => ['date', 'required'] ,
            'last_day' => ['date', 'required'] ,
            'start_lat' => ['required'],
            'start_lng' => ['required'],
            'end_lat' => ['required'],
            'end_lng' => ['required'],
            'description' => ['required'],
            'journey_charg' => ['required'],
            'max_number' => ['required'],
        ]);

      $journey =  Journey::create([
            'headline' => $request->headline,
            'start_day' => $request->start_day,
            'last_day' => $request->last_day,
            'start_point' => new Point($request->start_lat, $request->start_lng),
            'end_point' => new Point($request->end_lat, $request->end_lng),
            'description' => $request->description,
            'journey_charg' => $request->journey_charg,
            'max_number' => $request->max_number,
        ]);

        event(new CreateJourney($journey));

         return redirect()->route('journey.show',compact('journey'));


    }

    /**
     * Display the specified resource.
     */
    public function show(Journey $journey)
    {
        $jou = Journey::find($journey->id);
        return view('journey.show',compact('jou'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Journey $journey)
    {

        return view('journey.edit',compact('journey'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Journey $journey)
    {
        $validated = $request->validate([
            'headline' => ['bail','required','string'],
            'start_day' => ['date', 'required'] ,
            'last_day' => ['date', 'required'] ,
            'start_lat' => ['required'],
            'start_lng' => ['required'],
            'end_lat' => ['required'],
            'end_lng' => ['required'],
            'description' => ['required'],
            'journey_charg' => ['required'],
            'max_number' => ['required'],
        ]);

            $journey->headline = $request->headline ;
            $journey->start_day =  $request->start_day;
            $journey->last_day = $request->last_day;
            $journey->start_point = new Point($request->start_lat, $request->start_lng);
            $journey->end_point = new Point($request->end_lat, $request->end_lng) ;
            $journey->description = $request->description ;
            $journey->journey_charg  = $request->journey_charg ;
            $journey->max_number = $request->max_number ;


            $journey->save();

            event(new EditJourney($journey));




            return redirect()->route('journey.show',$journey);


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Journey $journey)
    {
        $jou = Journey::find($journey->id);
        $jou->delete();
        return redirect()->route('journey.index');
    }

    public function trashed()
    {
        $trashed_journeys = Journey::onlyTrashed()->get();


            return view('journey.trash',compact('trashed_journeys'));



    }

    public function restore($id)
    {
         Journey::onlyTrashed()
        ->where('id', $id)
        ->restore();

        return redirect()->back();
    }

    public function force_delete($id)
    {
         Journey::onlyTrashed()
        ->where('id', $id)
        ->forceDelete();
        return redirect()->route('journey.trash');
    }


    //api

    public function apijourney()
    {
        $jou = Journey::get();

        if($jou)
        {
            $journeys = JourneyResource::collection($jou);
            return response()->json([
                "journeys" => $journeys,

            ]);
        }
        else
        {
            return response()->json(['message' => 'No record available'], 200);
        }


    }

    public function showjourneyapi(Journey $journey)
    {
            if($journey)
            {
                return response()->json([
                    "journey" => new  JourneyResource($journey)
                ]);

            }
            else
            {
                return response()->json([
                    "the journey is missing!"
                ]);
            }


    }



}
