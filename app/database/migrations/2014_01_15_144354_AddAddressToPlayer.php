<?php

use Illuminate\Database\Migrations\Migration;

class AddAddressToPlayer extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('players', function($table) {
      $table->string('address');
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
      $table->dropColumn('address');
    });
    //
  }

}
