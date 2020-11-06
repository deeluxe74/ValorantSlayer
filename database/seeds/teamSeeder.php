<?php

use App\Player;
use App\Team;
use Illuminate\Database\Seeder;

class teamSeeder extends Seeder
{
    public function run(){
        $faker = Faker\Factory::create('fr_FR');

        $master = Team::create([                
            'name' => 'TheFirst',
            'score' => '5700',
            'victory' => '60',
            'defeat' => '6',
            'logo'=> 'https://zupimages.net/up/20/16/1hak.png',
        ]);
        //Static for Master Team
        $i = 1;
        $id = $i; 
        while($i <= 60){
            Player::create([
                'team_id' => 1,
                'user_id' => $id,
                'result' => 'Gagner',
                'pass_match' => 'delete',
            ]);
            if($i > 30 && $i < 45) {
                $id = 21;
            }elseif($i >= 45){
                $id = 41;
            }
            $i++;
        }

        $x = 1;
        while($x <= 6){
            Player::create([
                'team_id' => 1,
                'user_id' => 21,
                'result' => 'Perdu',
                'pass_match' => 'delete',
            ]); 
            $x++;
        }


        $i = 0;
        while($i < 19){
            $victory = $faker->numberBetween($min = 0, $max = 59);
            $defeat = $faker->numberBetween($min = 0, $max = 30);

            $score = ($victory * 100) - ($defeat * 50) ;
            $name = $faker->country;
            while(strlen($name) >= 8){
                $name = $faker->country;
            }
            Team::create([
                'name' => $name,
                'score' => $score,
                'victory' => $victory,
                'defeat' => $defeat,
                'logo'=> 'https://zupimages.net/up/20/17/iue2.jpg',
                ]);
            $i++;

            $user_id = $i;   
            while($victory > 0){
                Player::create([
                    'team_id' => $i + 1,
                    'user_id' => $user_id + 1,
                    'result' => 'Gagner',
                    'pass_match' => 'delete',
                ]);
                if($victory < 30){
                    $user_id = $i + 20;
                }elseif($victory < 15){
                    $user_id = $i + 20;
                }elseif($victory < 4){
                    $user_id = $i - 40;
                }
                $victory--;
            }
            while($defeat > 0){
                Player::create([
                    'team_id' => $i + 1,
                    'user_id' => $user_id + 1,
                    'result' => 'Perdu',
                    'pass_match' => 'delete',
                ]);
                if($defeat < 30){
                    $user_id = $i + 20;
                }elseif($defeat < 15){
                    $user_id = $i + 20;
                }elseif($defeat < 4){
                    $user_id = $i - 40;
                }
                $defeat--;
            }
        }
        //Generate the player for game waiting
        for($i=0; $i < 7; $i++){ 
            $pass = 'a3ba2d23de09d2aa4bc00504af9d6b21fecba050'.$i;
            Player::create([
                'team_id' => 13,
                'user_id' => 13,
                'pass_match' => $pass,
            ]);
            Player::create([
                'team_id' => 13,
                'user_id' => 33,
                'pass_match' => $pass,
            ]);

        }
        
    }
}
