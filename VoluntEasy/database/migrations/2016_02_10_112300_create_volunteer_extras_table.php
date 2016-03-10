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
            $table->boolean('knows_word')->nullable()->default(0);
            $table->boolean('knows_excel')->nullable()->default(0);
            $table->boolean('knows_powerpoint')->nullable()->default(0);
            $table->boolean('has_previous_volunteer_experience')->nullable()->default(0);
            $table->boolean('has_previous_work_experience')->nullable()->default(0);

            $table->string('volunteering_work_extra', 300)->nullable();
            $table->string('other_department', 300)->nullable();


            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('how_you_learned2_id')->unsigned();
            $table->foreign('how_you_learned2_id')->references('id')->on('how_you_learned2');

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
        Schema::dropIfExists('volunteer_extras');

    }
}
