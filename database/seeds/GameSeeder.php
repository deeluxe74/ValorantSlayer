<?php

use App\Game;
use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(){
        $faker = Faker\Factory::create('fr_FR');
        $i = 0;
        $map = 'Heaven';
        $ladder = '5vs5';
        $day = 15;
        while($i < 7){
            $pass = 'a3ba2d23de09d2aa4bc00504af9d6b21fecba050'.$i;
            $game_time = $faker->DateTime();
            if($i == 3 ){
                $map = 'Split';
                $ladder = '2vs2';
            }
            Game::create([            
                'ladder' => $ladder,
                'game_time' => date("d/m/Y h:i", strtotime('+'.$day.'day')),
                'team1' => '13',
                'map1' => $map,
                'pass_match' => $pass,
                'status' => 'Ouvert',
            ]);
            $i++;
            $day += 3;
        }
    }
}
