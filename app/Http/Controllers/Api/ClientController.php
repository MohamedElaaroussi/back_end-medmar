<?php

namespace App\Http\Controllers\Api;
use App\Models\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        return response()->json($clients);
    }

    public function clients()
    {
        $clients = Client::all();
        if ($clients) {
            return response()->json($clients);
        } else {
            return response()->json(["message"=>"client not found"]);
        }

    }

    public function store(ClientRequest $request)
    {

        try {
            // Validate data
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'L\'image n\'est pas valide. Assurez-vous qu\'elle soit bien présente, qu\'elle soit une image, qu\'elle ait une taille maximale de 2 Mo et qu\'elle ait une extension parmi celles indiquées.',
                ], 400);
            }

            $imageName = Str::random(32) . "." . $request->image->getClientOriginaExtlension();

            // Change the storage path here
            $storagePath = $imageName;

            // Create Product
            Client::create([
                'image' => $storagePath,
            ]);

            // Save Image in Storage folder
            Storage::disk('public')->put($imageName, file_get_contents($request->image));

            // Return Json Response
            return response()->json([
                'message' => "client successfully created."
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
    $client = Client::find($id);
    if(!$client){
        return response()->json([
            'message' => 'Not Found !'
        ],404);
    }
    //public storage
    $storage = Storage::disk('public');
    //delete image
    if($storage->exists($client->image)){
        $storage->delete($client->image);

        //delete realisation
        $client->delete();

        //return json
        return response()->json([
            'message' => 'client deleted'
        ],200);
    }
  }
}
