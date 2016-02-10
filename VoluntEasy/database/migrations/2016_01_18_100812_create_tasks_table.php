<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('tasks', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->boolean('isComplete')->default(false);
            $table->integer('priority')->default(2);

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });


        Schema::create('task_statuses', function($table)
        {
            $table->increments('id');
            $table->string('description');
        });


        Schema::create('subtasks', function($table)
        {
            $table->increments('id');
            $table->string('name', 300);
            $table->string('description', 500)->nullable();
            $table->integer('priority')->default(3);

            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses');

            $table->timestamps();
        });


        Schema::create('volunteer_subtasks', function($table)
        {
            $table->increments('id');
            $table->string('description', 500)->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->timestamps();
        });

        Schema::create('volunteer_task_availabilities', function($table)
        {
            $table->increments('id');
            $table->string('volunteer_email');
            $table->string('day');
            $table->string('hours')->nullable();

            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');

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
        Schema::dropIfExists('volunteer_tasks');
        Schema::dropIfExists('volunteer_task_availabilities');
        Schema::dropIfExists('volunteer_subtasks');
        Schema::dropIfExists('subtasks');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
    }
}
