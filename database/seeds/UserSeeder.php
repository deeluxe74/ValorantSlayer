<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{   
    public function run(){
        $faker = Faker\Factory::create('fr_FR');

        $master = User::create([                
            'name' => 'Deeluxe',
            'email' => 'rollet.raphael@gmail.com',
            'team_id' => 1,
            'roles' => 'Legend',
            'password' => 'az',
            'pass_team'=> '1e9R'.sha1(md5(microtime())).'8P5f',
            'picture' => 'https://zupimages.net/up/20/17/ss74.jpeg'
        ]);

        $i = 0;
        $team = 2;
        while($i < 50){
            if($team == 21){
                $team = 1;
            }
            if($i < 19){
                $roles = 'Legend';
            }else{
                $roles = 'Sbire';
            }
            User::create([
                'name' => $faker->lastName,
                'email' => $faker->email,
                'team_id' => $team,
                'roles' => $roles,
                'password' => 'az',
                'pass_team'=> '1e9R'.sha1(md5($faker->userName)).'8P5f',
                'picture' => 'https://zupimages.net/up/20/17/ss74.jpeg'
                ]);
            $i++;
            $team++;
        }
    }
}
