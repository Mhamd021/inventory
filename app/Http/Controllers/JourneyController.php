<?php

namespace App\Http\Controllers;
use App\Models\Journey;
use App\Models\Points;
use MatanYadaev\EloquentSpatial\Objects\Point;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Journey as JourneyResource;
use App\Events\CreateJourney;
use App\Events\EditJourney;
use App\Http\Requests\JourneyCreateRequest;
use App\Http\Requests\JourneyUpdateRequest;
use Exception as GlobalException;
use Illuminate\Support\Facades\DB;
use App\Services\ImageService;

class JourneyController extends Controller
{
    use SoftDeletes;
    protected $imageService;
    public function __construct(ImageService $imageService)
    {
         $this->imageService = $imageService;
    }
    public function index()
    {
        $journeys = Journey::paginate(10);
        return view('journey.index', compact('journeys'));
    }
    public function create()
    {
        return view('journey.create');
    }

    public function store(JourneyCreateRequest $request)
    {
        DB::transaction(function () use ($request) {

            $journey =  Journey::create([
                'headline' => $request->headline,
                'start_day' => $request->start_day,
                'last_day' => $request->last_day,
                'description' => $request->description,
                'journey_charg' => $request->journey_charg,
                'max_number' => $request->max_number,
            ]);
            event(new CreateJourney($journey));
            $points = [];
            foreach ($request->points as $index => $pointData) {
                $location = "ST_GeomFromText('POINT({$pointData['latitude']} {$pointData['longitude']})', 4326)";
                $point =
                    [
                        'journey_id' => $journey->id,
                        'order' => $index + 1,
                        'point_description' => $pointData['point_description'],
                        'location' => DB::raw($location),
                    ];
                if (isset($pointData['image'])) {
                    $point['image'] = $this->imageService->upload($pointData['image'], 'uploads/journeys', 1920, 1080);
                }
                $points[] = $point;
            }
            Points::insert($points);
        });
        return redirect()->route('journey.index');
    }
    public function show(Journey $journey)
    {
        $points = $journey->Points;
        return view('journey.show', compact('journey', 'points'));
    }
    public function edit(Journey $journey)
    {

        $points = $journey->Points;
        return view('journey.edit', compact('journey', 'points'));
    }

    public function update(JourneyUpdateRequest $request, Journey $journey)
    {
        $request->user()->fill($request->validated());
        $journey->headline = $request->headline;
        $journey->start_day =  $request->start_day;
        $journey->last_day = $request->last_day;
        $journey->description = $request->description;
        $journey->journey_charg  = $request->journey_charg;
        $journey->max_number = $request->max_number;
        $journey->save();

        foreach ($request->points as $index => $pointData)
        {
            if (isset($pointData['id'])) {
                // Update existing point
                $point = Points::findOrFail($pointData['id']);
            } else {
                // Create new point
                $point = new Points();
                $point->journey_id = $journey->id;
                $point->order = $index + 1;
            }
            $point->point_description = $pointData['point_description'];
            $point->location = new Point($pointData['latitude'], $pointData['longitude']);

            if (isset($pointData['image']) && $pointData['image'] instanceof \Illuminate\Http\UploadedFile) {
                if ($point->image) {
                    $this->imageService->delete($point->image);
                }
                      $point->image = $this->imageService->upload($pointData['image'], 'uploads/journeys', 1920, 1080);
            }
            $point->save();
        }
         event(new EditJourney($journey));

        return redirect()->route('journey.index');
    }


    public function destroy(Journey $journey)
    {
        $journey->delete();
        return redirect()->route('journey.index');
    }



    public function trashed()
    {
        $trashed_journeys = Journey::onlyTrashed()->get();
        return view('journey.trash', compact('trashed_journeys'));
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
        if ($jou) {
            $journeys = JourneyResource::collection($jou);
            return response()->json([
                "journeys" => $journeys,

            ]);
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }
    }

    public function showJourneyApi(Journey $journey)
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

