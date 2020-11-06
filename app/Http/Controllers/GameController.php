<?php

namespace App\Http\Controllers;

use App\Game;
use App\Player;
use App\Team;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GameController extends Controller
{
    public function getMembers(Request $request){
        $token = Request('token');
        $user = User::where('remember_token',$token)->first();
        // All user for this team
        $users = User::where('team_id',$user->team_id)->get();

        return $users;
    }

    public function createGame(Request $request){

        // The current team id
        $token = Request('token');
        $user = User::where('remember_token',$token)->first();
        $team_id = $user->team_id; 
        //Create instance game
        $game = new Game;
        $pass = Request('pass_match');
        //Take all player on create
        $users = Request('arr_player');
            
        //Pass so accept the Game
        if(isset($pass)){
            $take_game = Game::where('pass_match', $pass)->first();
            $take_game->map2 = Request('map');
            $take_game->team2 = $team_id;
            $take_game->status = 'Fermer';
            $take_game->save();
            $new_game = Game::where('pass_match', $pass)->first();
            // Instance all players on accept
            foreach($users as $currUser) {
                $player = new Player;
                $player->team_id = $currUser['team_id'];
                $player->user_id = $currUser['id'];
                $player->pass_match = $new_game->pass_match;
                $player->save();
            }

            return ['success' =>'Votre match a été Validé !', 'game' => $new_game];
        }else {
            //No pass so Create a new game
            $game->ladder = Request('ladder');
            $game->team1 = $team_id;
            $game->map1 = Request('map');
            $game->pass_match = Hash::make(Request('game_time'));
            $game->game_time = Request('game_time');
            $game->status = 'Ouvert';
            $game->save();
            //Asign all player on macth 
            foreach($users as $currUser) {

                $player = new Player;
                $player->team_id = $currUser['team_id'];
                $player->user_id = $currUser['id'];
                $player->pass_match = $game->pass_match;
                $player->save();
            }
            return ['success' =>'Votre match a été Validé !'];
        }
    }

    public function gameShow(Request $request){
        // The current user
        $token = Request('token');
        $user = User::where('remember_token',$token)->first();
        // Is a leader ?
        $roles_user = $user->roles;

        //Display him these game
        $games = Game::where('team1', $user->team_id)
            ->orWhere('team2', $user->team_id)
            ->get();

        //All game in live
        $allGames = Game::where('team1', '!=', $user->team_id)
            ->where('status', 'Ouvert')
            ->get();

        $data = [$allGames, $games ,$roles_user];
        return $data;
    }

    public function deleteGame(Request $request){
        Game::where('pass_match', Request('pass_match'))->delete();

        return ['success' => 'Ce match a bien été supprimer !', 'pass_match' => Request('pass_match')];
    }

    public function validateScore(Request $request){
        //Check who curr user is for scorage
        $user = User::where('remember_token', Request('token'))->first();
        //Save the score
        $game_pass = Request('game_pass');
        $score1 = Request('score1');
        $score2 = Request('score2');
        $game = Game::where('pass_match', $game_pass)->first();
        if($game->team1 == $user->team_id){
            $game->score1 = $score1;
            $game->score2 = $score2;
            if($score1 > $score2){
                $winner = $game->team1;
                $looser = $game->team2;
            }else {
                $winner = $game->team2;
                $looser = $game->team1;
            }
        }else {
            $game->score1 = $score2;
            $game->score2 = $score1;
            if($score1 > $score2){
                $winner = $game->team2;
                $looser = $game->team1;
            }else {
                $winner = $game->team1;
                $looser = $game->team2;
            }
        }
        $game->save();
            
        //Attribute win to winner
        $winner = Team::where('id', $winner)->first();
        $winner->victory = $winner->victory + 1;
        $winner->score = $winner->score + 100;
        $winner->save();
        //Atribute the loose
        $looser = Team::where('id', $looser)->first();
        $looser->defeat = $looser->defeat + 1;
        $looser->score = $looser->score - 50;
        $looser->save();

        $game->delete();
        return ['success' => 'Les scores sont bien enregistrer !'];
    }

    public function ficheShow(Request $request){
        $pass = Request('pass_match');
        $token = Request('token');
        //Who is the curr team ?
        $currUser = User::where('remember_token', $token)->first();
        //Logic get players name
        $players = Player::where('pass_match', $pass)->get();
        $currPlayers = [];
        $guestPlayers = [];
        $guestTeam = [];
        foreach ($players as $player) {
            if($player->team_id == $currUser->team_id){
                $user = User::where('id', $player->user_id)->first();
                array_push($currPlayers, $user); 
            }else {
                $user = User::where('id', $player->user_id)->first();
                array_push($guestPlayers, $user);
                $guestTeam = Team::where('id', $player->team_id)->first(); 
            }    
        }
        // Get the curr team
        $currTeam = Team::where('id', $currUser->team_id)->first();

        return ['currPlayers' => $currPlayers, 'guestPlayers' => $guestPlayers, 'guestTeam' => $guestTeam, 'currTeam' => $currTeam];
        
    }
}
