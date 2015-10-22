<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VolunteerAddons extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('availability_days', function ($table) {
            $table->increments('id');
            $table->string('day', 100);
            $table->string('time', 100);
            $table->timestamps();
        });

        Schema::create('volunteer_availability_days', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('availability_day_id')->unsigned();
            $table->foreign('availability_day_id')->references('id')->on('availability_days');
        });

        Schema::create('how_you_learned', function ($table) {
            $table->increments('id');
            $table->string('description', 100);
            $table->string('comments', 300);
            $table->timestamps();
        });


        Schema::table('volunteers', function($table)
        {
            $table->integer('how_you_learned_id')->unsigned()->nullable();
            $table->foreign('how_you_learned_id')->references('id')->on('how_you_learned')->onDelete('cascade');

        });


    }

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('volunteer_availability_days');
        Schema::dropIfExists('availability_days');
	}

}
