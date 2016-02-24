<?php

use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {


        Schema::create('task_statuses', function ($table) {
            $table->increments('id');
            $table->string('description');
        });


        Schema::create('tasks', function ($table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->string('description', 1000)->nullable();
            $table->boolean('isComplete')->default(false);
            $table->integer('priority')->default(2);
            $table->date('due_date')->nullable();

            $table->integer('status_id')->unsigned()->default(1);
            $table->foreign('status_id')->references('id')->on('task_statuses');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });


        Schema::create('subtasks', function ($table) {
            $table->increments('id');
            $table->string('name', 300);
            $table->string('description', 1000)->nullable();
            $table->integer('priority')->default(2);
            $table->date('due_date')->nullable();

            $table->integer('task_id')->unsigned();
            $table->foreign('task_id')->references('id')->on('tasks');

            $table->integer('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('task_statuses');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('actions');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('subtasks');
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('task_statuses');
    }
}
