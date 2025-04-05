<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // e.g. Featured Games, More to Discover, RPG, FPS, etc.
            $table->string('image');    // URL for the game image
            $table->string('name');     // Game name
            $table->text('details');    // Game details/description
            $table->decimal('price', 8, 2); // Game price (excludes the "$" symbol, which you can add in the view)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('games');
    }
}
