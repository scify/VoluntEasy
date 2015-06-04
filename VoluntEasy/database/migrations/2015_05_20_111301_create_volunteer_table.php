<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// TODO: Populate id types.
		Schema::create('identification_types', function($table)
		{
			$table->increments('id');
			$table->string('description', 50);
		});

		// TODO: Populate marital status.
		Schema::create('marital_statuses', function($table)
		{
			$table->increments('id');
			$table->string('description', 100)->nullable;
		});

		// TODO: Populate driver license types.
		Schema::create('driver_license_types', function($table)
		{
			$table->increments('id');
			$table->string('description', 100)->nullable();
		});

		Schema::create('availability_freqs', function($table)
		{
			$table->increments('id');
			$table->string('description', 100);
		});


		// TODO: Populate work status.
		Schema::create('work_statuses', function($table)
		{
			$table->increments('id');
			$table->string('work_status', 300);
		});

		Schema::create('volunteers', function($table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('last_name', 100);
			$table->string('fathers_name', 100);
			$table->string('identification_num', 100);
			$table->date('birth_date');
			$table->boolean('gender');
			$table->smallInteger('children')->nullable();
			$table->string('address', 300)->nullable();
			$table->smallInteger('post_box')->nullable();
			$table->string('participation_reason', 300);
			$table->string('participation_previous', 400)->nullable();
			$table->string('participation_actions', 400)->nullable();
			$table->string('extra_lang', 100);
			$table->string('work_description', 300)->nullable();
			$table->boolean('live_in_curr_country')->nullable();
			$table->text('comments', 300);
			$table->timestamps();

			$table->integer('identification_type_id')->unsigned();
			$table->foreign('identification_type_id')->references('id')->on('identification_types');
			$table->integer('marital_status_id')->unsigned();
			$table->foreign('marital_status_id')->references('id')->on('marital_statuses');
			$table->integer('driver_license_type_id')->unsigned();
			$table->foreign('driver_license_type_id')->references('id')->on('driver_license_types');
			$table->integer('availability_freqs_id')->unsigned();
			$table->foreign('availability_freqs_id')->references('id')->on('availability_freqs');
			$table->integer('work_status_id')->unsigned();
			$table->foreign('work_status_id')->references('id')->on('work_statuses');
		});

		// TODO: Populate volunteer frequency text.
		Schema::create('availability_time', function($table)
		{
			$table->increments('id');
			$table->string('description', 100);
		});

		Schema::create('volunteers_availability_freqs', function($table)
		{
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers');
			$table->integer('availability_freqs_id')->unsigned();
			$table->foreign('availability_freqs_id')->references('id')->on('availability_time');
		});

		Schema::create('unit_volunteer', function($table)
		{
			$table->increments('id');
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('units');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers');
		});

		/* TODO: Populate interest for checkboxes. */
		Schema::create('interests', function($table)
		{
			$table->increments('id');
			$table->text('category', 100);
			$table->text('description', 100);
		});

		Schema::create('volunteer_interest', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers');
			$table->integer('interest_id')->unsigned();
			$table->foreign('interest_id')->references('id')->on('interests');
		});

		// TODO: Populate language list.
		Schema::create('languages', function($table)
		{
			$table->increments('id');
			$table->string('description', 50);
		});

		Schema::create('language_levels', function($table)
		{
			$table->increments('id');
			$table->string('description', 50);
		});

		Schema::create('volunteer_languages', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers');
			$table->integer('language_id')->unsigned();
			$table->foreign('language_id')->references('id')->on('languages');
			$table->integer('language_level_id')->unsigned();
			$table->foreign('language_level_id')->references('id')->on('language_levels');
		});


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('volunteer_languages');
		Schema::drop('language_levels');
		Schema::drop('languages');
		Schema::drop('volunteer_interest');
		Schema::drop('interests');
		Schema::drop('unit_volunteer');
		Schema::drop('volunteers_availability_freqs');
		Schema::drop('availability_time');
		Schema::drop('volunteers');
		Schema::drop('work_statuses');
		Schema::drop('availability_freqs');
		Schema::drop('driver_license_types');
		Schema::drop('marital_statuses');
		Schema::drop('identification_types');

	}

}
