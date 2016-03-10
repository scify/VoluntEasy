<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCollaborationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

        Schema::create('collaboration_types', function ($table) {
            $table->increments('id');
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('collaborations', function ($table) {
            $table->increments('id');
            $table->string('name');
            $table->string('comments')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('type_id')->unsigned();
            $table->foreign('type_id')->references('id')->on('collaboration_types');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('collaborations_files', function ($table) {
            $table->increments('id');
            $table->string('filename');
            $table->integer('collaboration_id')->unsigned();
            $table->foreign('collaboration_id')->references('id')->on('collaborations');
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
        Schema::dropIfExists('collaborations_files');
        Schema::dropIfExists('collaborations');
        Schema::dropIfExists('collaboration_types');
    }

}
