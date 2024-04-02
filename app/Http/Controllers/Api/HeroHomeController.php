<?php

namespace App\Http\Controllers\Api;
use App\Models\HeroHome;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\HeroRequest;
use Illuminate\Support\Facades\Storage;

class HeroHomeController extends Controller
{
   
    public function index()
    {
        $hero = HeroHome::all();
        return response()->json($hero);
    }

    public function hero()
    {
        $hero = HeroHome::all();
        return response()->json($hero);
    }

    public function update(HeroRequest $request,$id)
    {
        try{
            //recherche
            $hero = HeroHome::find($id);

            //vérifier si hero existe
            if(!$hero){
                return response()->json([
                    'message' => 'Event Not Found.'
                ],404);
            }

            //mettre a jour
            $hero->titre = $request->titre;
            $hero->description = $request->description;

            //Vérifier image
            if($request->hasFile('image')){
                $storage = Storage::disk('public');

                //supprimer l'ancienne image
                if($storage->exists($hero->image)){
                    $storage->delete($hero->image);
                }
                //Générer un nom unique
                $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();

                //Enregistrer le nouvelle image
                $storage->put($imageName, file_get_contents($request->file('image')));

                //mettre a jour
                $hero->image = $imageName;
            }
             //sauvegarder
             $hero->save();
             //return response
             return response()->json([
                 'message' => 'hero successfully updated',
                 'Event' => $hero
             ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ],500);
        }
    }
}
