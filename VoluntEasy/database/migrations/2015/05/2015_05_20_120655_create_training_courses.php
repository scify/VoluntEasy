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
		// Schema::create('training_courses', function($table)
		// {
		// 	$table->increments('id');
		// 	$table->integer('action_id')->unsigned();
		// 	$table->foreign('action_id')->references('id')->on('unit');
		// 	$table->string('name', 50);
		// 	$table->string('description', 300);
		// 	$table->string('duration', 50);
		// 	$table->string('place', 100);
		// 	$table->string('rapporteur', 50);
		// });

		// Schema::create('courses_to_volunteers', function($table)
		// {
		// 	$table->increments('id');
		// 	$table->integer('volunteer_id')->unsigned();
		// 	$table->foreign('volunteer_id')->references('id')->on('volunteer');
		// 	$table->integer('course_id')->unsigned();
		// 	$table->foreign('course_id')->references('id')->on('training_courses');
		// });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Schema::dropIfExists('courses_to_volunteers');
		// Schema::dropIfExists('training_courses');
	}

}
