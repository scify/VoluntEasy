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
            $table->boolean('isAssigned')->default(0);
            $table->boolean('isVolunteer')->default(0);

            $table->integer('public_action_id')->unsigned();
            $table->foreign('public_action_id')->references('id')->on('public_actions');

            $table->timestamps();
        });

        //the dates filled by the volunteer
        Schema::create('cta_volunteers_dates', function ($table) {
            $table->increments('id');

            $table->integer('cta_volunteers_id')->unsigned();
            $table->foreign('cta_volunteers_id')->references('id')->on('cta_volunteers');

            $table->integer('subtask_work_dates_id')->unsigned();
            $table->foreign('subtask_work_dates_id')->references('id')->on('subtask_work_dates');

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
        Schema::dropIfExists('cta_volunteers');
    }
}
