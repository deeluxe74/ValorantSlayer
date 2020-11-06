<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(teamSeeder::class);
        $this->call(GameSeeder::class);
     
    }
}
