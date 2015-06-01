<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrainingCourses extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('training_courses', function($table)
		{
			$table->increments('course_id');
			$table->integer('action_id')->unsigned();
			$table->foreign('action_id')->references('action_id')->on('actions');
			$table->string('name', 50);
			$table->string('description', 300);
			$table->string('duration', 50);
			$table->string('place', 100);
			$table->string('rapporteur', 50);
		});

		Schema::create('courses_to_volunteers', function($table)
		{
			$table->increments('course_to_vol_link_id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('volunteer_id')->on('volunteer');
			$table->integer('course_id')->unsigned();
			$table->foreign('course_id')->references('course_id')->on('training_courses');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('courses_to_volunteers');
		Schema::drop('training_courses');
	}

}
