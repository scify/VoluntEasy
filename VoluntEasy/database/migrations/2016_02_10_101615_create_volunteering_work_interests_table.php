<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteeringWorkInterestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteering_work_interests', function ($table) {
            $table->increments('id');
            $table->text('description', 100);
            $table->timestamps();
        });

        Schema::create('volunteer_volunteering_work_interests', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('work_interest_id')->unsigned();
            $table->foreign('work_interest_id')->references('id')->on('volunteering_work_interests');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('volunteer_volunteering_work_interests');
        Schema::dropIfExists('volunteering_work_interests');
    }
}
