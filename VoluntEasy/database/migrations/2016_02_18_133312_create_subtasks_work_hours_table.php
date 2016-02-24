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
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->time('from_hour');
            $table->time('to_hour');
            $table->string('comments', 500)->nullable();
            $table->integer('volunteer_sum')->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->timestamps();
        });

        Schema::create('volunteer_work_hours', function ($table) {
            $table->increments('id');
            $table->string('description', 500)->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->integer('subtask_work_dates_id')->unsigned();
            $table->foreign('subtask_work_dates_id')->references('id')->on('subtask_work_dates');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('volunteer_work_hours');
        Schema::dropIfExists('subtask_work_dates');
    }
}
