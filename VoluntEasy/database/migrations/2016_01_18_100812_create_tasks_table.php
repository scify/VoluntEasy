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
            $table->date('task_date');
            $table->time('task_time');
            $table->string('comments', 500)->nullable();
            $table->string('working_hours', 100)->nullable();

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses');

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
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
    }
}
