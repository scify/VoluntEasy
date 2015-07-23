<?php

use Illuminate\Database\Migrations\Migration;

class CreateVolunteerTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('identification_types', function ($table) {
            $table->increments('id');
            $table->string('description', 50);
        });

        Schema::create('marital_statuses', function ($table) {
            $table->increments('id');
            $table->string('description', 100)->nullable();
        });

        Schema::create('driver_license_types', function ($table) {
            $table->increments('id');
            $table->string('description', 100)->nullable();
        });

        Schema::create('availability_freqs', function ($table) {
            $table->increments('id');
            $table->string('description', 100);
        });


        Schema::create('work_statuses', function ($table) {
            $table->increments('id');
            $table->string('description', 300);
        });

        Schema::create('genders', function ($table) {
            $table->increments('id');
            $table->string('description', 50);
        });

        Schema::create('education_levels', function ($table) {
            $table->increments('id');
            $table->string('description', 50);
        });

        Schema::create('comm_method', function ($table) {
            $table->increments('id');
            $table->string('description', 200);
        });

        Schema::create('volunteers', function ($table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('last_name', 100);
            $table->string('fathers_name', 100);
            $table->string('identification_num', 100)->nullable();
            $table->date('birth_date');
            $table->smallInteger('children')->nullable();
            $table->string('address', 300)->nullable();
            $table->string('city', 300)->nullable();
            $table->string('country', 300)->nullable();
            $table->smallInteger('post_box')->nullable();
            $table->string('participation_reason', 300);
            $table->string('participation_previous', 400)->nullable();
            $table->string('participation_actions', 400)->nullable();
            $table->string('home_tel')->nullable();
            $table->string('work_tel')->nullable();
            $table->string('cell_tel')->nullable();
            $table->string('fax')->nullable();
            $table->string('email')->unique();
            $table->string('extra_lang', 100)->nullable();
            $table->string('work_description', 300)->nullable();
            $table->string('specialty', 300)->nullable();
            $table->string('department', 300)->nullable();
            $table->string('additional_skills', 300)->nullable();
            $table->boolean('live_in_curr_country')->nullable();
            $table->boolean('computer_usage')->nullable();
            $table->text('comments', 20000)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->integer('gender_id')->unsigned();
            $table->foreign('gender_id')->references('id')->on('genders')->onDelete('cascade');
            $table->integer('education_level_id')->unsigned();
            $table->foreign('education_level_id')->references('id')->on('education_levels')->onDelete('cascade');
            $table->integer('comm_method_id')->unsigned()->nullable();
            $table->foreign('comm_method_id')->references('id')->on('comm_method')->onDelete('cascade');
            $table->integer('identification_type_id')->unsigned();
            $table->foreign('identification_type_id')->references('id')->on('identification_types')->onDelete('cascade');
            $table->integer('marital_status_id')->unsigned()->nullable();
            $table->foreign('marital_status_id')->references('id')->on('marital_statuses')->onDelete('cascade');
            $table->integer('driver_license_type_id')->unsigned();
            $table->foreign('driver_license_type_id')->references('id')->on('driver_license_types')->onDelete('cascade');
            $table->integer('availability_freqs_id')->unsigned();
            $table->foreign('availability_freqs_id')->references('id')->on('availability_freqs')->onDelete('cascade');
            $table->integer('work_status_id')->unsigned();
            $table->foreign('work_status_id')->references('id')->on('work_statuses')->onDelete('cascade');

            $table->boolean('blacklisted')->default(false);
        });

        Schema::create('availability_time', function ($table) {
            $table->increments('id');
            $table->string('description', 100);
        });

        Schema::create('volunteer_availability_times', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('availability_time_id')->unsigned();
            $table->foreign('availability_time_id')->references('id')->on('availability_time');
        });

        Schema::create('actions_volunteers', function ($table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
        });

        Schema::create('actions_volunteers_history', function ($table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->timestamps();
        });

        Schema::create('units_volunteers', function ($table) {
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('cascade');
        });

        Schema::create('interests', function ($table) {
            $table->increments('id');
            $table->text('category', 100);
            $table->text('description', 100);
        });

        Schema::create('volunteer_interests', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('interest_id')->unsigned();
            $table->foreign('interest_id')->references('id')->on('interests');
        });

        Schema::create('languages', function ($table) {
            $table->increments('id');
            $table->string('description', 50);
        });

        Schema::create('language_levels', function ($table) {
            $table->increments('id');
            $table->string('description', 50);
        });

        Schema::create('volunteer_languages', function ($table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('language_id')->unsigned();
            $table->foreign('language_id')->references('id')->on('languages');
            $table->integer('language_level_id')->unsigned();
            $table->foreign('language_level_id')->references('id')->on('language_levels');
        });

        Schema::create('volunteer_statuses', function ($table) {
            $table->increments('id');
            $table->text('description');
        });

        Schema::create('volunteer_step_status', function ($table) {
            $table->increments('id');
            $table->string('description', 300)->nullable();
            $table->string('comments', 300)->nullable();
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('step_id')->unsigned();
            $table->foreign('step_id')->references('id')->on('steps');
            $table->integer('step_status_id')->unsigned();
            $table->foreign('step_status_id')->references('id')->on('step_statuses');
            $table->timestamps();
        });

        Schema::create('volunteer_step_history', function ($table) {
            $table->increments('id');
            $table->date('date');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('step_id')->unsigned();
            $table->foreign('step_id')->references('id')->on('steps');
            $table->integer('previous_step_status_id')->unsigned();
            $table->foreign('previous_step_status_id')->references('id')->on('step_statuses');
            $table->integer('new_step_status_id')->unsigned();
            $table->foreign('new_step_status_id')->references('id')->on('step_statuses');
        });

        // Schema::create('volunteer_action_status', function ($table) {
        //     $table->increments('id');
        //     $table->integer('volunteer_id')->unsigned();
        //     $table->foreign('volunteer_id')->references('id')->on('volunteers');
        //     $table->integer('action_id')->unsigned();
        //     $table->foreign('action_id')->references('id')->on('actions');
        //     $table->integer('action_status_id')->unsigned();
        //     $table->foreign('action_status_id')->references('id')->on('volunteer_statuses');
        // });

        // Schema::create('volunteer_action_history', function ($table) {
        //     $table->increments('id');
        //     $table->integer('volunteer_id')->unsigned();
        //     $table->foreign('volunteer_id')->references('id')->on('volunteers');
        //     $table->integer('action_id')->unsigned();
        //     $table->foreign('action_id')->references('id')->on('actions');
        //     $table->integer('previous_action_status_id')->unsigned();
        //     $table->foreign('previous_action_status_id')->references('id')->on('volunteer_statuses');
        //     $table->integer('new_action_status_id')->unsigned();
        //     $table->foreign('new_action_status_id')->references('id')->on('volunteer_statuses');
        // });

        Schema::create('volunteer_unit_status', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('volunteer_status_id')->unsigned();
            $table->foreign('volunteer_status_id')->references('id')->on('volunteer_statuses');
        });

        Schema::create('volunteer_unit_history', function ($table) {
            $table->increments('id');
            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('unit_id')->unsigned();
            $table->foreign('unit_id')->references('id')->on('units');
            $table->integer('previous_unit_status_id')->unsigned();
            $table->foreign('previous_unit_status_id')->references('id')->on('volunteer_statuses');
            $table->integer('new_unit_status_id')->unsigned();
            $table->foreign('new_unit_status_id')->references('id')->on('volunteer_statuses');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('volunteer_unit_history');
        Schema::dropIfExists('volunteer_unit_status');
        Schema::dropIfExists('actions_volunteers_history');
        // Schema::dropIfExists('volunteer_action_history');
        // Schema::dropIfExists('volunteer_action_status');
        Schema::dropIfExists('volunteer_statuses');
        Schema::dropIfExists('volunteer_step_history');
        Schema::dropIfExists('volunteer_step_status');
        Schema::dropIfExists('volunteer_languages');
        Schema::dropIfExists('language_levels');
        Schema::dropIfExists('languages');
        Schema::dropIfExists('volunteer_interests');
        Schema::dropIfExists('interests');
        Schema::dropIfExists('actions_volunteers');
        Schema::dropIfExists('units_volunteers');
        Schema::dropIfExists('volunteer_availability_times');
        Schema::dropIfExists('availability_time');
        Schema::dropIfExists('volunteers');
        Schema::dropIfExists('comm_method');
        Schema::dropIfExists('education_levels');
        Schema::dropIfExists('genders');
        Schema::dropIfExists('work_statuses');
        Schema::dropIfExists('availability_freqs');
        Schema::dropIfExists('driver_license_types');
        Schema::dropIfExists('marital_statuses');
        Schema::dropIfExists('identification_types');

    }

}
