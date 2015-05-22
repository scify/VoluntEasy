<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function($table)
		{
			$table->increments('action_id');
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('unit_id')->on('unit');
			/* 'timestamps' adds created_at and updated_at columns. */
			// $table->timestamps;
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
			$table->integer('action_id')->unsigned();
			$table->foreign('action_id')->references('action_id')->on('actions');
			/* Following may be null. */
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
		Schema::drop('actions');
	}

}
