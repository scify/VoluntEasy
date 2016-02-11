<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVolunteerExtrasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('volunteer_extras', function ($table) {
            $table->increments('id');
            $table->boolean('knows_word')->default(0);
            $table->boolean('knows_excel')->default(0);
            $table->boolean('knows_powerpoint')->default(0);
            $table->boolean('has_previousVolunteerExperience')->default(0);
            $table->boolean('hasPreviousWorkExperience')->default(0);

            $table->string('volunteering_work_extra', 300);
            $table->string('other_department', 300);


            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

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
        Schema::dropIfExists('volunteer_extras');

    }
}
