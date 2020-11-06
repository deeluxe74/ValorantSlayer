<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/connexion', 'UserController@connexion');

Route::post('/signUp', 'UserController@post');

Route::post('/profil', 'UserController@getUser');

Route::post('/profil/team', 'TeamController@getTeam');
Route::get('/profil/allTeam', 'TeamController@getAllTeam');

Route::post('/profil/newTeam', 'TeamController@createTeam');
Route::post('/profil/team/newMember', 'TeamController@newMember');
Route::post('/profil/team/deleteMember', 'UserController@deleteMember');

Route::post('/match/getMembers', 'GameController@getMembers');
Route::post('/match/createGame', 'GameController@createGame');

Route::post('/match/show', 'GameController@gameShow');
Route::post('/match/deleteGame', 'GameController@deleteGame');
Route::post('/match/validateScore', 'GameController@validateScore');
Route::post('/fiche', 'GameController@ficheShow');
