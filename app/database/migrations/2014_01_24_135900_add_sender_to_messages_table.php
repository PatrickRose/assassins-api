<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddSenderToMessagesTable extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::table('messages', function(Blueprint $table) {
      $table->integer('sender');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('messages', function(Blueprint $table) {
      $table->dropColumn('sender');
    });
  }

}
