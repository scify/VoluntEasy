<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCtaVolunteersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cta_volunteers', function ($table) {
            $table->increments('id');
            $table->string('first_name', 300);
            $table->string('last_name', 300);
            $table->string('email', 300);
            $table->string('phone_number', 300);
            $table->string('comments', 1000)->nullable();
            $table->boolean('isVolunteer')->default(0);

            $table->integer('public_action_id')->unsigned();
            $table->foreign('public_action_id')->references('id')->on('public_actions');

            $table->softDeletes();
            $table->timestamps();
        });

        //the dates filled by the volunteer
        Schema::create('cta_volunteers_dates', function ($table) {
            $table->increments('id');

            $table->integer('cta_volunteers_id')->unsigned();
            $table->foreign('cta_volunteers_id')->references('id')->on('cta_volunteers');

            $table->integer('subtask_shifts_id')->unsigned();
            $table->foreign('subtask_shifts_id')->references('id')->on('subtask_shifts');

            $table->softDeletes();
            $table->timestamps();
        });

        //if the volunteer is found in the db, connect with the cta volunteer
        Schema::create('cta_volunteers_platform_volunteers', function ($table) {
            $table->increments('id');

            $table->integer('cta_volunteers_id')->unsigned();
            $table->foreign('cta_volunteers_id')->references('id')->on('cta_volunteers');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->softDeletes();
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
        Schema::dropIfExists('cta_volunteers_dates');
        Schema::dropIfExists('cta_volunteers_platform_volunteers');
        Schema::dropIfExists('cta_volunteers');
    }
}
