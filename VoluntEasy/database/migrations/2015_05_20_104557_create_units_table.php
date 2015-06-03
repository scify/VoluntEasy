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
			$table->increments('id');
			$table->string('description', 300);
			$table->integer('user_id')->unsigned;
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('parent_unit_id')->unsigned;
			$table->foreign('parent_unit_id')->references('id')->on('unit');
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
