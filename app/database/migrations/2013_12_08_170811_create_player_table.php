<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlayerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('player', function(Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('pseudonym');
			$table->string('course');
			$table->string('department');
			$table->string('year');
			$table->text('allergies');
			$table->string('water');
			$table->integer('gameID');
			$table->boolean('alive');
			$table->integer('circleID');
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
		Schema::drop('player');
	}

}
