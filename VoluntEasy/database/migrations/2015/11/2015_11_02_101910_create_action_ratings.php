<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionRatings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('action_rating_attributes', function ($table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('action_scores', function ($table) {
            $table->increments('id');
            $table->string('token');
            $table->string('comments');
            $table->boolean('rated')->default(0);
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');
            $table->timestamps();
        });

        Schema::create('action_rating_scores', function ($table) {
            $table->increments('id');
            $table->integer('score');
            $table->integer('attribute_id')->unsigned();
            $table->foreign('attribute_id')->references('id')->on('action_rating_attributes');
            $table->integer('action_score_id')->unsigned();
            $table->foreign('action_score_id')->references('id')->on('action_scores');
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
        Schema::dropIfExists('action_rating_scores');
        Schema::dropIfExists('action_scores');
        Schema::dropIfExists('action_rating_attributes');

    }

}
