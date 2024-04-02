<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\LogUserRequest;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{
    public function login(LogUserRequest $request)
    {
        if(auth()->attempt($request->only('email','password'))){
            $user = auth()->user();
            $token = $user->createToken('user_token')->plainTextToken;
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Utilisateur connecté.',
                'user' => $user,
                'token' => $token
            ]);

        }else{
            //Si les informations ne correspondent a aucun utilisateur
            return response()->json([
                'status_code' => 403,
                'status_message' => 'Information non valide .',
            ]);
        }
    }

    public function user(Request $request)
    {
        $userData=User::all();
        // return $request->user();
        return response()->json($userData);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete(); // Revoke all of the user's tokens

        return response()->json(['message' => 'Successfully logged out']);
    }
//MA_CLE_SECRETE_VISIBLE_UNIQUEMENT_AU_BACKEND
}
