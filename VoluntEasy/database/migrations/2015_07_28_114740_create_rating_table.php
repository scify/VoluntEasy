<?php

use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        //OLD RATING SYSTEM
        /*
            Schema::create('rating_volunteer_action', function(Blueprint $table)
            {
                $table->increments('id');

                $table->integer('volunteer_id')->unsigned();
                $table->foreign('volunteer_id')->references('id')->on('volunteers');

                $table->integer('action_id')->unsigned();
                $table->foreign('action_id')->references('id')->on('actions');

                $table->string('email');

                // $string = str_random(30);
                $table->string('token',30);

                $table->integer('attr1')->default(0);
                $table->integer('attr2')->default(0);
                $table->integer('attr3')->default(0);
                $table->timestamps();

                $table->index('volunteer_id');
            });

            Schema::create('ratings', function($table)
            {
                $table->increments('id');
                $table->integer('volunteer_id')->unsigned();
                $table->foreign('volunteer_id')->references('id')->on('volunteers');

                $table->integer('rating_attr1')->default(0);
                $table->integer('rating_attr1_count')->default(0);
                $table->integer('rating_attr2')->default(0);
                $table->integer('rating_attr2_count')->default(0);
                $table->integer('rating_attr3')->default(0);
                $table->integer('rating_attr3_count')->default(0);

                $table->timestamps();
            });
        */


        //refactoring ratings


        //the rating descriptions, i.e. Συνέπεια, Ομαδικότητα etc
        Schema::create('rating_attributes', function ($table) {
            $table->increments('id');
            $table->string('description', 100);
        });

        //table to keep the ratings that each user makes for a volunteer
        Schema::create('rating_volunteer_action', function ($table) {
            $table->increments('id');
            $table->string('email');
            $table->string('token', 30);

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
            $table->index('volunteer_id');
        });

        //the actual rating for each attribute
        Schema::create('ratings', function ($table) {
            $table->increments('id');
            $table->string('rating');

            $table->integer('rating_attribute_id')->unsigned();
            $table->foreign('rating_attribute_id')->references('id')->on('rating_attributes');

            $table->integer('rating_volunteer_action_id')->unsigned();
            $table->foreign('rating_volunteer_action_id')->references('id')->on('rating_volunteer_action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('ratings');
        Schema::dropIfExists('rating_attributes');
        Schema::dropIfExists('rating_volunteer_action');
    }
}
