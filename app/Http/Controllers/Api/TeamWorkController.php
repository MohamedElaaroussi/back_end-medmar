<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\TeamWorkRequest;
use App\Models\TeamWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamWorkController extends Controller
{
    public function index()
    {
        $teams = TeamWork::all();
        return response()->json($teams);
    }

    public function teams()
    {
        $teams = TeamWork::all();
        return response()->json($teams);
    }

    public function store(TeamWorkRequest $request)
    {
        try{
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $storagePath = $imageName;
            //create
            TeamWork::create([
                'image' => $storagePath,
                'nom' => $request->nom,
                'role' => $request->role
            ]);
            //save image
            Storage::disk('public')->put($imageName,file_get_contents($request->image));
            //return json
            return response()->json([
                'message' => "teams successfully created."
            ], 200);

        }catch(\Exception $e){
            //return json rersponse
            return response()->json([
                'message' => 'Something went really wrong!'
            ],500);
        }
    }

    public function update(TeamWorkRequest $request,$id)
    {
        try{
        
        //recherche
        $team = TeamWork::find($id);
        
        //vérifier si existe
        if(!$team){
            return response()->json([
                'message' => 'team not found.'
            ],404);
        }

        //Vérifier si le champ 
        if (!$request->has('nom')) {
            return response()->json([
                'message' => 'Nom is required.'
            ], 400);
        }
        //Vérifier si le champ 
        if (!$request->has('role')) {
            return response()->json([
                'message' => 'Role is required.'
            ], 400);
        }
        //Vérifier si le champ 
        if (!$request->has('image')) {
        return response()->json([
        'message' => 'Image is required.'
            ], 400);
        }

        //mettre a jour
        $team->nom = $request->nom;
        $team->role = $request->role;

        //vérifier image
        if($request->hasFile('image')){
            $storage = Storage::disk('public');

            //supprimer l'ancienne image
            if($storage->exists($team->image)){
                $storage->delete($team->image);
            }

            // Générer un nom unique pour la nouvelle image
            $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();

            // Enregistrer la nouvelle image dans le dossier public
            $storage->put($imageName, file_get_contents($request->file('image')));
            
            // Mettre à jour le nom de l'image dans la base de données
            $team->image = $imageName;
            
        }

        //save
        $team->save();

        return response()->json([
            'message' => 'team successfully updated',
            'site' => $team
        ], 200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ], 500);    
        }

    }

    public function destroy($id)
    {
        $team = TeamWork::find($id);
        if(!$team){
            return response()->json([
                'message' => 'Not Found !'
            ],404);
        }
        //public storage
        $storage = Storage::disk('public');
        //delete image
        if($storage->exists($team->image)){
            $storage->delete($team->image);
            //delete team
            $team->delete();
            //return json
            return response()->json([
                'message' => 'team deleted'
            ],200);
        }
    }
}
