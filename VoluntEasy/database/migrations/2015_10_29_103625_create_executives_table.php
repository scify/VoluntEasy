<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExecutivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('executives', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('collaborations_executives', function ($table) {
            $table->increments('id');
            $table->integer('collaboration_id')->unsigned();
            $table->foreign('collaboration_id')->references('id')->on('collaborations');
            $table->integer('executive_id')->unsigned();
            $table->foreign('executive_id')->references('id')->on('executives');
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
        Schema::dropIfExists('collaborations_executives');
        Schema::dropIfExists('executives');
	}

}
