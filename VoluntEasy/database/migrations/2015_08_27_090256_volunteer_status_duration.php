<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VolunteerStatusDuration extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('volunteer_status_duration', function ($table) {
            $table->increments('id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('comments')->nullable();
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('volunteer_statuses');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::dropIfExists('volunteer_status_duration');

    }

}
