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
			$table->timestamp('start_date');
			$table->timestamp('end_date');
		});

		Schema::create('step_status', function($table)
		{
			$table->increments('step_id');
			$table->text('status');
		});

		Schema::create('action_step', function($table)
		{
			$table->increments('action_step_id');
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('unit');
			$table->integer('step_id')->unsigned()->nullable();
			$table->foreign('step_id')->references('step_id')->on('step_status');
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
		Schema::drop('action_step');
		Schema::drop('step_status');
		Schema::drop('unit');
	}

}
