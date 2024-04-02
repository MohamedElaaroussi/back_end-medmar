<?php

namespace App\Http\Controllers\Api;
use App\Models\Realisation;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\RealisationRequest;
use Illuminate\Support\Facades\Storage;

class RealisationController extends Controller
{
    public function index()
    {
        $realisations = Realisation::all();
        return response()->json($realisations);
    }

    public function allRealisations()
    {
        $realisations = Realisation::all();
        return response()->json($realisations);
    }

    public function store(RealisationRequest $request)
    {

    try {
        $imageName = Str::random(32) . "." . $request->image->getClientOriginalExtension();

        // Change the storage path here
        $storagePath = $imageName;

        // Create Product
        Realisation::create([
            'image' => $storagePath,
        ]);

        // Save Image in Storage folder
        Storage::disk('public')->put($imageName, file_get_contents($request->image));

        // Return Json Response
        return response()->json([
            'message' => "realisation successfully created."
        ], 200);
    } catch (\Exception $e) {
        // Return Json Response
        return response()->json([
            'message' => "Something went really wrong!"
        ], 500);
    }

}
    public function destroy($id)
    {
        $realisation = Realisation::find($id);
        if(!$realisation){
            return response()->json([
                'message' => 'Not Found !'
            ],404);
        }
        //public storage
        $storage = Storage::disk('public');
        //delete image
        if($storage->exists($realisation->image)){
            $storage->delete($realisation->image);

            //delete realisation
            $realisation->delete();

            //return json
            return response()->json([
                'message' => 'realisation deleted'
            ],200);
        }
    }


}
