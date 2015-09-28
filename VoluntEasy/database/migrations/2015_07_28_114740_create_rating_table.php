<?php

use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        //the rating descriptions, i.e. Συνέπεια, Ομαδικότητα etc
        Schema::create('rating_attributes', function ($table) {
            $table->increments('id');
            $table->string('description', 100);
        });

        //table to keep the token that is send to each upeu8unos
        Schema::create('action_ratings', function ($table) {
            $table->increments('id');
            $table->string('email');
            $table->string('token', 30)->nullable();
            $table->boolean('rated')->default(0);

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });

        //table to keep the ratings that each user makes for a volunteer
        Schema::create('volunteer_action_ratings', function ($table) {
            $table->increments('id');
            $table->string('comments', 300)->nullable();
            $table->integer('hours')->nullable();
            $table->integer('minutes')->nullable();

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');
            $table->integer('action_rating_id')->unsigned();
            $table->foreign('action_rating_id')->references('id')->on('action_ratings');

            $table->timestamps();
            $table->index('volunteer_id');
        });

        //the actual rating for each attribute
        Schema::create('ratings', function ($table) {
            $table->increments('id');
            $table->string('rating');

            $table->integer('rating_attribute_id')->unsigned();
            $table->foreign('rating_attribute_id')->references('id')->on('rating_attributes');

            $table->integer('volunteer_action_rating_id')->unsigned();
            $table->foreign('volunteer_action_rating_id')->references('id')->on('volunteer_action_ratings');

            $table->timestamps();
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
        Schema::dropIfExists('volunteer_action_ratings');
        Schema::dropIfExists('action_ratings');
    }
}
