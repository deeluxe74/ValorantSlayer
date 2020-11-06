<?php

namespace App\Http\Controllers;

use App\Player;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use stdClass;

class TeamController extends Controller
{
    public function createTeam(Request $request) {
        $team = New Team;
        //Vérifie si user a une team
        $userId = Request('userId');
        $user = User::where('id',$userId)->first();

        if($user->team_id > 0){
            return ['errors' => 'Vous avez déja une team vous ne pouvez pas accéder a cette fonctions.'];
        }
        //Crée ma team
        $team->name = Request('name');
        $team->logo = Request('logo');
        $team->save();
            
        //Leader de team
        $user->roles = 'Legend';
        $user->team_id = $team->id;
        $user->save();

        return $user;
        
    }

    public function getTeam(Request $request){
        $userId = Request('team_id');
        if($userId != null){
            $users = User::where('team_id',$userId)->get();
            $team = Team::where('id',$userId)->first();
            $win = [];
            $loose = [];
            //Take scorage of all members
            foreach($users as $user){
                $id = $user->id;
                //Take all win
                $games = Player::where('user_id', $id)
                ->where('result', 'Gagner')
                ->get();
                array_push($win, $games);
                //Take all loose
                $gamesLoose = Player::where('user_id', $id)
                ->where('result', 'Perdu')
                ->get();
                array_push($loose, $gamesLoose);
            };
            $data = [$users, $team, $win, $loose];
            return $data;
        }
    }

    public function getAllTeam(Request $request){
        $all_team = Team::orderBy('score', 'desc')->get();
        
        return $all_team;
    }

    public function newMember(Request $request){
        $pass_team = Request('secret_pass');
        $team_id = Request('team_id');
        //Check if minesse 5

        //Found user as same secret
        $user = User::where('pass_team',$pass_team)->first();
        if($user == null){
            return ['errors' =>"Cette utilisateur n'existe pas en base de données"];
        }

        $user->team_id = $team_id;
        $user->roles = 'Sbire';
        $user->save();

        return ['id' => $team_id];
    }
}
