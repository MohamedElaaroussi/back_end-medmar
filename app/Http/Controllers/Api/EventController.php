<?php

namespace App\Http\Controllers\Api;
use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventCreateRequest;
use App\Http\Requests\EventUpdateRequest;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::all();
        return response()->json($events);
    }

    public function events()
    {
        $events = Event::all();
        return response()->json($events);
    }
    

    public function store(EventCreateRequest $request)
    {
        try{
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $storagePath = $imageName;
            //create 
            Event::create([
                'image' => $storagePath,
                'titre' => $request->titre,
                'date' => $request->date,
                'status' => $request->status,
                'prix' => $request->prix,
                'description' => $request->description
            ]);
            //save image
            Storage::disk('public')->put($imageName,file_get_contents($request->image));
            //return json
            return response()->json([
                'message' => "Event successfully created."
            ],200);
            
        }catch(\Exception $e){
            //return json response
            return response()->json([
                'message' => 'Something went really wrong!'
            ],500);
        }
    }

    public function update(EventUpdateRequest $request,$id)
    {
        try{

            //recherche 
            $event = Event::find($id);

            //Vérifier si event existe
            if(!$event){
                return response()->json([
                    'message' => 'Event Not Found.'
                ],404);
            }

            //Vérification
            if(!$request->has('image')){
                return response()->json([
                    'message' => 'Image id required.'
                ],400);
            }

            //mettre a jour
            $event->titre = $request->titre;
            $event->date = $request->date;
            $event->status = $request->status;
            $event->prix = $request->prix;
            $event->description = $request->description;

            //Vérifier image
            if($request->hasFile('image')){
                $storage = Storage::disk('public');

                //supprimer l'ancienne image
                if($storage->exists($event->image)){
                    $storage->delete($event->image);
                }
                //Générer un nom unique
                $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();

                //Enregistrer le nouvelle image
                $storage->put($imageName, file_get_contents($request->file('image')));

                //mettre a jour
                $event->image = $imageName;
            }
            //sauvegarder
            $event->save();
            //return response
            return response()->json([
                'message' => 'Event successfully updated',
                'Event' => $event    
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ],500);
        }
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if(!$event){
            return response()->json([
                'message' => 'Not Found !'
            ],404);
        }
        //public storage
        $storage = Storage::disk('public');
        //delete image
        if($storage->exists($event->image)){
            $storage->delete($event->image);
            //delete event
            $event->delete();
            //return
            return response()->json([
                'message' => 'event deleted'
            ],200);
        }
    }

    public function activer($id){
        $event = Event::find($id);
    
        if(!$event){
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    
        $event->status = 'avenir';
        $event->save();
    
        return response()->json([
            'message' => 'Event status updated successfully',
            'event' => $event
        ], 200);
    }

    public function desactiver($id){
        $event = Event::find($id);
    
        if(!$event){
            return response()->json([
                'message' => 'not found'
            ], 404);
        }
    
        $event->status = 'terminer';
        $event->save();
    
        return response()->json([
            'message' => 'Event status updated successfully',
            'event' => $event
        ], 200);
    }

}
