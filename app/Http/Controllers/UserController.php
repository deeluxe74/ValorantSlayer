<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUser(Request $request){
        $tokenVue = Request('token');
        $idVue = Request('id');

        $user= User::all();
        foreach( $user as $curr){
            if($idVue == $curr->email){
                if(Request('token') == $curr->remember_token){
                    return $curr;
                }
            }
        }
    }

    public function post(Request $request){
        $user = new User;
        if (Request('picture') == null){
            $picture = '';
        }else{
            $picture = Request('picture');
        }

        $user->name = Request('name');
        $user->email = Request('email');
        $user->password = Request('password');
        $user->pass_team = '1e9R'.sha1(Request('name')).'8P5f';
        $user->picture = $picture;

        $user->save();

        return redirect()->to('/connexion');
    }

    public function connexion(Request $request){
        $email = Request('email');
        $password = Request('password');
        

        if (Auth::attempt(['email' => $email, 'password' => $password], true)){

            $token = Auth::user()->remember_token;
            return response()->json(['token'=> $token,'id'=> $email,'asErrors'=>false]);
            
        }
        return response()->json(['asErrors'=>true, 'message'=> 'Vos données sont incorect']);;
    }

    public function deleteMember(Request $request){
        $id = Request('user_id');
        $user = User::where('id',$id)->first();
        $team_id = $user->team_id;
        //Leader = errors
        if($user->roles == 'Legend'){
            return ['errors' =>'Hé, le leader et immunisé contre cela !'];
        }
        //Pass team regenere
        $user->pass_team = '7rZ1'.sha1($user->pass_team).'Po8';
        $user->team_id = null;
        $user->roles = null;
        $user->save();
        return ['success' => 'Ce membre a été retirer avec succès de votre équipe !', 'id' => $team_id];
    }
}