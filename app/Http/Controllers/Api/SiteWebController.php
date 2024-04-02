<?php

namespace App\Http\Controllers\Api;
use App\Models\SiteWeb;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateSiteRequest;

class SiteWebController extends Controller
{
    public function index()
    {
        $siteweb = SiteWeb::all();
        return response()->json($siteweb);
    }
    public function AllsiteWeb()
    {
        $siteweb = SiteWeb::all();
        if($siteweb){
            return response()->json($siteweb);
        }else{
            return response()->json(['message' => "No site web we haven't."]);
        }
    }


    public function update(UpdateSiteRequest $request, $id)
    {
    try {
        // Rechercher le site par son ID
        $site = SiteWeb::find($id);

        // Vérifier si le site existe
        if (!$site) {
            return response()->json([
                'message' => 'Site not found.'
            ], 404);
        }

        // Vérifier si le champ 'lien' est présent dans la requête
        if (!$request->has('lien')) {
            return response()->json([
                'message' => 'Link is required.'
            ], 400);
        }

        // Mettre à jour le lien du site
        $site->lien = $request->lien;

        // Vérifier s'il y a une nouvelle image à téléverser
        if ($request->hasFile('image')) {
            $storage = Storage::disk('public');

            // Supprimer l'ancienne image
            if ($storage->exists($site->image)) {
                $storage->delete($site->image);
            }

            // Générer un nom unique pour la nouvelle image
            $imageName = Str::random(32) . '.' . $request->image->getClientOriginalExtension();

            // Enregistrer la nouvelle image dans le dossier public
            $storage->put($imageName, file_get_contents($request->file('image')));

            // Mettre à jour le nom de l'image dans la base de données
            $site->image = $imageName;
        }

        // Sauvegarder les modifications du site
        $site->save();

        return response()->json([
            'message' => 'Site successfully updated',
            'site' => $site
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Something went wrong!',
            'error' => $e->getMessage()
        ], 500);
    }
}



}
