<?php

use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\HeroHomeController;
use App\Http\Controllers\Api\RealisationController;
use App\Http\Controllers\Api\SiteWebController;
use App\Http\Controllers\Api\TeamWorkController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\YoutubeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/admin/login-login-admin',[UserController::class,'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::middleware('auth:sanctum')->group(function(){
    Route::get('/user',[UserController::class,'user']);
    //logout
    Route::post('/logout',[UserController::class,'logout']);
    //realisation admin
    Route::get('/realisations',[RealisationController::class,'index']);
    Route::post('/realisations/ajouter',[RealisationController::class,'store']);
    Route::delete('/realisations/delete/{id}',[RealisationController::class,'destroy']);
    //creation de site web
    Route::get('/creation-site-web',[SiteWebController::class,'index']);
    Route::put('/update-site-web/{id}',[SiteWebController::class,'update']);
    //url youtube
    Route::get('/youtube-url',[YoutubeController::class,'index']);
    Route::put('/youtube-url/modifier/{id}',[YoutubeController::class,'update']);
    //teams work
    Route::get('/teams',[TeamWorkController::class,'index']);
    // Route::post('/teams/ajouter',[TeamWorkController::class,'store']);
    Route::put('/teams/modifier/{id}',[TeamWorkController::class,'update']);
    Route::delete('/teams/delete/{id}',[TeamWorkController::class,'destroy']);
    //events
    Route::get('/events',[EventController::class,'index']);
    Route::post('/events/ajouter',[EventController::class,'store']);
    Route::put('/events/modifier/{id}',[EventController::class,'update']);
    Route::delete('/events/delete/{id}',[EventController::class,'destroy']);
    //our clients
    Route::get('/clients',[ClientController::class,'index']);
    Route::post('/clients/ajouter',[ClientController::class,'store']);
    Route::delete('/clients/delete/{id}',[ClientController::class,'destroy']);
    //activer et desactiver event
    Route::put('/event/status/{id}', [EventController::class,'activer']);
    Route::put('/event/status/desactiver/{id}', [EventController::class,'desactiver']);
    //hero home
    Route::get('/hero-home',[HeroHomeController::class,'index']);
    Route::put('/hero/modifier/{id}',[HeroHomeController::class,'update']);

// });
//realisations
Route::post('/teams/ajouter',[TeamWorkController::class,'store']);
Route::get('/realisations/user',[RealisationController::class,'allRealisations']);
Route::get('/creation-site-web/user',[SiteWebController::class,'AllsiteWeb']);
Route::get('/youtube-url/user',[YoutubeController::class,'youtube']);
Route::get('/teams/user',[TeamWorkController::class,'teams']);
Route::get('/events/user',[EventController::class,'events']);
Route::get('/clients/user',[ClientController::class,'clients']);
Route::get('/hero-home/user',[HeroHomeController::class,'hero']);



