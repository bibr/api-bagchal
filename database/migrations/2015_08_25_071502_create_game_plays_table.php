<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamePlaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_plays', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tiger_user_id');
            $table->string('goat_user_id');
            $table->text('tiger_position');
            $table->text('goat_position');
            $table->enum('next_move', ['tiger', 'goat']);
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
        Schema::drop('game_plays');
    }
}
