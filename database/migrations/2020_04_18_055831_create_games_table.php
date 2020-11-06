<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('ladder');
            $table->string('game_time');
            $table->string('team1');
            $table->string('score1')->nullable();
            $table->string('map1');
            $table->string('team2')->nullable();
            $table->string('score2')->nullable();
            $table->string('map2')->nullable();
            $table->string('pass_match');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games');
    }
}
