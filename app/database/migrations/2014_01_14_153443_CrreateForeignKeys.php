<?php

use Illuminate\Database\Migrations\Migration;

class CrreateForeignKeys extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('players', function($table) {
      $table->integer('user_id');
      $table->integer('game_id');
      $table->foreign('user_id')->references('id')->on('users');
      $table->foreign('game_id')->references('id')->on('games');
    });
    //
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('players', function($table) {
      $table->dropColumn('user_id');
      $table->dropColumn('game_id');
      $table->dropForeign('players_user_id_foreign')->references('id')->on('users');
      $table->dropForeign('players_game_id_foreign')->references('id')->on('games');
    });
    //
  }

}
