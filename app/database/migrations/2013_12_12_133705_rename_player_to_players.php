<?php

use Illuminate\Database\Migrations\Migration;

class RenamePlayerToPlayers extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename("player", "players");
        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	Schema::rename("players", "player");
        //
    }

}
