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

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });


        Schema::create('task_statuses', function($table)
        {
            $table->increments('id');
            $table->string('name');
        });


        Schema::create('volunteer_tasks', function($table)
        {
            $table->increments('id');
            $table->string('name', 300)->nullable();
            $table->string('job_descr', 500)->nullable();
            $table->string('comments', 500)->nullable();

            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses');

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
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
    }
}
