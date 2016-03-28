<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOpaVolunteerRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('opa_labor_skills', function ($table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });


        Schema::create('opa_interpersonal_skills', function ($table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });


        Schema::create('volunteer_opa_ratings', function ($table) {
            $table->increments('id');

            $table->string('actionDescription', 1000)->nullable();
            $table->string('problemsOccured', 1000)->nullable();
            $table->string('fieldsToImprove', 1000)->nullable();
            $table->string('training', 1000)->nullable();
            $table->string('objectives', 1000)->nullable();
            $table->string('support', 1000)->nullable();
            $table->string('generalComments', 1000)->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });



        Schema::create('volunteer_opa_labor_skills', function ($table) {
            $table->increments('id');
            $table->string('comments')->nullable();
            $table->boolean('needsImprovemnet')->nullable();

            $table->integer('labor_skill_id')->unsigned();
            $table->foreign('labor_skill_id')->references('id')->on('opa_labor_skills');

            $table->integer('opa_rating_id')->unsigned();
            $table->foreign('opa_rating_id')->references('id')->on('volunteer_opa_ratings');
            $table->timestamps();
        });


        Schema::create('volunteer_opa_interpersonal_skills', function ($table) {
            $table->increments('id');
            $table->string('comments')->nullable();
            $table->boolean('needsImprovemnet')->nullable();

            $table->integer('intp_skill_id')->unsigned();
            $table->foreign('intp_skill_id')->references('id')->on('opa_interpersonal_skills');

            $table->integer('opa_rating_id')->unsigned();
            $table->foreign('opa_rating_id')->references('id')->on('volunteer_opa_ratings');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('volunteer_opa_labor_skills');
        Schema::dropIfExists('volunteer_opa_interpersonal_skills');
        Schema::dropIfExists('volunteer_opa_ratings');
        Schema::dropIfExists('opa_labor_skills');
        Schema::dropIfExists('opa_interpersonal_skills');
    }
}
