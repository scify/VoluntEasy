<?php

use Illuminate\Database\Migrations\Migration;

class CreateSubtasksWorkHoursTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('subtask_work_dates', function ($table) {
            $table->increments('id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->time('from_hour')->nullable();
            $table->time('to_hour')->nullable();
            $table->string('comments', 500)->nullable();
            $table->integer('volunteer_sum')->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->timestamps();
        });

        Schema::create('volunteer_work_dates', function ($table) {
            $table->increments('id');
            $table->string('description', 500)->nullable();

            $table->integer('subtask_work_dates_id')->unsigned();
            $table->foreign('subtask_work_dates_id')->references('id')->on('subtask_work_dates');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('volunteer_work_dates');
        Schema::dropIfExists('subtask_work_dates');
    }
}
