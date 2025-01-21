<?php

namespace App\Http\Controllers;

use App\Models\Points;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PointsController extends Controller
{

    public function index()
    {

    }

    public function destroy($id)
    {
        try {
            $point = Points::findOrFail($id);
            File::delete($point->image);
            $point->delete();
            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
         {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
