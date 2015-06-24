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
			$table->integer('parent_unit_id')->nullable();
			$table->foreign('parent_unit_id')->references('id')->on('units');
			$table->timestamps();
		});

		Schema::create('actions', function($table)
		{
			$table->increments('id');
			$table->string('description', 300);
			$table->string('comments', 300);
            $table->string('email');
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
			$table->integer('action_id')->unsigned();
			$table->foreign('action_id')->references('id')->on('actions');
			$table->string('description', 300);
			$table->smallInteger('step_order');
		});

		Schema::create('units_users', function($table)
		{
			$table->integer('user_id')->unsigned;
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('unit_id')->unsigned;
			$table->foreign('unit_id')->references('id')->on('units');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('units_users');
		Schema::dropIfExists('steps');
		Schema::dropIfExists('step_statuses');
		Schema::dropIfExists('actions');
		Schema::dropIfExists('units');
	}

}
