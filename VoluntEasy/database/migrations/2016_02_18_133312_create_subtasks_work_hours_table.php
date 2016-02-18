<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubtasksWorkHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subtask_work_dates', function ($table) {
            $table->increments('id');
            $table->date('fromDate');
            $table->date('toDate')->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->timestamps();
        });

        Schema::create('subtask_work_hours', function ($table) {
            $table->increments('id');
            $table->time('fromHour');
            $table->time('toHour');

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
    public function down()
    {
        Schema::dropIfExists('subtask_work_dates');
        Schema::dropIfExists('subtask_work_hours');
    }
}
