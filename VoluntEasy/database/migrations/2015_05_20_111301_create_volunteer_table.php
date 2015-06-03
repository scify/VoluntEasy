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
		Schema::create('volunteer', function($table)
		{
			$table->increments('id');
			$table->string('name', 100);
			$table->string('last_name', 100);
			$table->string('fathers_name', 100);
			$table->string('id_num', 100);
			$table->date('birth_date');
			$table->boolean('gender');
			$table->smallInteger('children')->nullable();
			$table->string('address', 300)->nullable();
			$table->smallInteger('post_box')->nullable();
			$table->string('participation_reason', 300);
			$table->string('extra_lang', 100);
			$table->boolean('live_in_curr_country')->nullable();
		});

		Schema::create('volunteer_to_unit', function($table)
		{
			$table->increments('id');
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('unit');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
		});

		// Populate id types.
		Schema::create('volunteer_id_type', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('id_type', 50);
		});

		// Populate marital status.
		Schema::create('volunteer_marital_status', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('marital_status', 100)->nullable;
		});

		// Populate driver license types.
		Schema::create('volunteer_drv_license_type', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('category', 100)->nullable();
		});

		// Populate volunteer frequency text.
		Schema::create('volunteer_freq', function($table)
		{
			$table->increments('id');
			$table->string('frequency', 50)->nullable();
			$table->string('time_of_day', 50)->nullable();
		});

		Schema::create('volunteer_freq_link', function($table)
		{
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->integer('freq_id')->unsigned();
			$table->foreign('freq_id')->references('id')->on('volunteer_freq');
		});

		/* Populate interest for checkboxes. */
		Schema::create('volunteer_interests', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
		});

		// Populate language list.
		Schema::create('volunteer_lang', function($table)
		{
			$table->increments('id');
			$table->string('language', 50)->nullable();
		});

		Schema::create('volunteer_lang_level', function($table)
		{
			$table->increments('lang_level_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->integer('lang_id')->unsigned();
			$table->foreign('lang_id')->references('id')->on('volunteer_lang');
		});

		// Populate work status.
		Schema::create('volunteer_work_status', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('work_status', 300);
			$table->string('work_message', 300)->nullable();
		});

		Schema::create('volunteer_part_reason', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('participation_previous', 400)->nullable();
			$table->string('participation_actions', 400)->nullable();
		});

		// Populate languages.
		Schema::create('volunteer_lang_list', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteer');
			$table->string('lang', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('volunteer_lang_list');
		Schema::drop('volunteer_part_reason');
		Schema::drop('volunteer_work_status_link');
		Schema::drop('volunteer_work_status');
		Schema::drop('volunteer_lang_level');
		Schema::drop('volunteer_lang');
		Schema::drop('volunteer_interests');
		Schema::drop('volunteer_freq_link');
		Schema::drop('volunteer_freq');
		Schema::drop('volunteer_drv_license_type');
		Schema::drop('volunteer_marital_status');
		Schema::drop('volunteer_id_type');
		Schema::drop('volunteer_to_unit');
		Schema::drop('volunteer');
	}

}
