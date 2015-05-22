<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnitsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		/* Unit model. */
		Schema::create('unit', function($table)
		{
			$table->increments('unit_id');
			$table->integer('user_id')->unsigned;
			$table->foreign('user_id')->references('user_id')->on('users');
			$table->integer('parent_unit_id')->unsigned;
			$table->foreign('parent_unit_id')->references('unit_id')->on('unit');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('unit');
	}

}
