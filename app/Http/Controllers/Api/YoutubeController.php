<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\Youtube;

class YoutubeController extends Controller
{
    public function index()
    {
        $youtubes = Youtube::all();
        return response()->json($youtubes);
    }
    public function youtube()
    {
        $youtubes = Youtube::all();
        return response()->json($youtubes);
    }

    public function update(VideoRequest $request, $id)
    {
        try{
            //Recherche le video par son Id
            $video = Youtube::find($id);
            //vérifier si le lien existe
            if(!$video){
                return response()->json([
                    'message' => 'lien not found .'
                ],404);
            }
            //vérifier si le champ lien est présent
            if(!$request->has('lien')){
                return response()->json([
                    'message' => 'lien is required .'
                ],400);
            }
            $video->lien = $request->lien;
            $video->save();
            //return
            return response()->json([
                'message' => 'video successfullt updated',
                'video' => $video
            ],200);

        }catch(\Exception $e){
            return response()->json([
                'message' => 'Something went wrong!',
                'error' => $e->getMessage()
            ],500);
        }
    }
}
