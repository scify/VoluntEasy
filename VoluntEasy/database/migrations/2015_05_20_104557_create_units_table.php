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
		Schema::create('units', function($table)
		{
			$table->increments('id');
			$table->string('description', 300);
			$table->string('comments', 300);
			$table->smallInteger('level')->nullable();
			$table->integer('user_id')->unsigned;
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('parent_unit_id')->unsigned;
			$table->foreign('parent_unit_id')->references('id')->on('units');
			$table->timestamp('start_date');
			$table->timestamp('end_date');
			$table->timestamps();
		});

		Schema::create('step_statuses', function($table)
		{
			$table->increments('id');
			$table->text('description');
		});

		Schema::create('steps', function($table)
		{
			$table->increments('id');
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('units');
			$table->string('description', 300);
			$table->smallInteger('step_order');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('steps');
		Schema::drop('step_statuses');
		Schema::drop('units');
	}

}
