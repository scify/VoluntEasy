<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtaskChecklistTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtask_checklists', function ($table) {
            $table->increments('id');
            $table->string('comments', 1000);
            $table->boolean('isComplete')->default(false);

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

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
        Schema::dropIfExists('subtask_checklists');
    }
}
