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
			$table->increments('volunteer_id');
			$table->string('name', 100);
			$table->string('last_name', 100);
			$table->string('fathers_name', 100);
			$table->string('id_num', 100);
			$table->date('birth_date');
			$table->boolean('gender');
			$table->smallInteger('children')->nullable();
			$table->string('address', 300)->nullable();
			$table->smallInteger('post_box')->nullable();
			$table->string('country', 50)->nullable();
			$table->boolean('live_in_curr_country')->nullable();
		});

		Schema::create('volunteer_to_action', function($table)
		{
			$table->increments('volunteer_to_action_id');
			$table->integer('action_id')->unsigned();
			$table->foreign('action_id')->references('action_id')->on('actions');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
		});

		Schema::create('volunteer_id_type', function($table)
		{
			$table->increments('id_type_id');
			$table->string('id_type', 50)->nullable();
		});

		Schema::create('volunteer_id_link', function($table)
		{
			$table->increments('id_num');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('id_type_id')->unsigned();
			$table->foreign('id_type_id')->references('id_type_id')->on('volunteer_id_type');
		});

		Schema::create('volunteer_marital_status', function($table)
		{
			$table->increments('marital_status_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->string('marital_status', 100)->nullable;
		});

		Schema::create('volunteer_drv_license_type', function($table)
		{
			$table->increments('drv_id');
			$table->string('category', 100)->nullable();
		});

		Schema::create('volunteer_drv_link', function($table)
		{
			$table->increments('license_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('drv_id')->unsigned();
			$table->foreign('drv_id')->references('drv_id')->on('volunteer_drv_license_type');
		});

		Schema::create('volunteer_freq', function($table)
		{
			$table->increments('freq_id');
			$table->string('frequency', 50)->nullable();
			$table->string('time_of_day', 50)->nullable();
		});

		Schema::create('volunteer_freq_link', function($table)
		{
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('freq_id')->unsigned();
			$table->foreign('freq_id')->references('freq_id')->on('volunteer_freq');
		});

		/* TODO: populate interests. */
		Schema::create('volunteer_interests', function($table)
		{
			$table->increments('interest_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
		});

		Schema::create('volunteer_lang', function($table)
		{
			$table->increments('lang_id');
			$table->string('language', 50)->nullable();
		});

		Schema::create('volunteer_lang_level', function($table)
		{
			$table->increments('lang_level_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('lang_id')->unsigned();
			$table->foreign('lang_id')->references('lang_id')->on('volunteer_lang');
		});

		Schema::create('volunteer_work_status', function($table)
		{
			$table->increments('status_id');
			$table->string('work_status', 300)->nullable();
		});

		Schema::create('volunteer_work_status_link', function($table)
		{
			$table->increments('work_status_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('status_id')->unsigned();
			$table->foreign('status_id')->references('status_id')->on('volunteer_work_status');
			$table->string('work_message', 300)->nullable();
		});
		
		Schema::create('volunteer_part_reason', function($table)
		{
			$table->increments('reason_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->string('particupation_reason', 400);
			$table->string('participation_previous', 400);
			$table->string('participation_actions', 400);
		});

		Schema::create('volunteer_country_list', function($table)
		{
			$table->increments('vol_country_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->string('country', 100);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('volunteer_country_list');
		Schema::drop('volunteer_part_reason');
		Schema::drop('volunteer_work_status_link');
		Schema::drop('volunteer_work_status');
		Schema::drop('volunteer_lang_level');
		Schema::drop('volunteer_lang');
		Schema::drop('volunteer_interests');
		Schema::drop('volunteer_freq_link');
		Schema::drop('volunteer_freq');
		Schema::drop('volunteer_drv_link');
		Schema::drop('volunteer_drv_license_type');
		Schema::drop('volunteer_marital_status');
		Schema::drop('volunteer_id_link');
		Schema::drop('volunteer_id_type');
		Schema::drop('volunteer_to_action');
		Schema::drop('volunteer');
	}

}
