<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePublicCtaPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_actions', function ($table) {
            $table->increments('id');
            $table->string('description', 1000);
            $table->string('address', 500);
            $table->string('map_url', 500);
            $table->string('executive_name', 300);
            $table->string('executive_email', 300);
            $table->string('executive_phone', 300);
            $table->string('public_url', 500);
            $table->boolean('isActive')->default(false);

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });

        //define which subtasks will be shown on the public page
        Schema::create('public_actions_subtasks', function ($table) {
            $table->increments('id');
            $table->string('description', 1000);

            $table->integer('public_actions_id')->unsigned();
            $table->foreign('public_actions_id')->references('id')->on('public_actions');

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

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
        Schema::dropIfExists('public_actions_subtasks');
        Schema::dropIfExists('public_actions');
    }
}
