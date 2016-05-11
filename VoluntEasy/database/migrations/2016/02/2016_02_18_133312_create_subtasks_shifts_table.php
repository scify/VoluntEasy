<?php

use Illuminate\Database\Migrations\Migration;

class CreateSubtasksShiftsTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('subtask_shifts', function ($table) {
            $table->increments('id');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->time('from_hour')->nullable();
            $table->time('to_hour')->nullable();
            $table->string('comments', 500)->nullable();
            $table->integer('volunteer_sum')->nullable();

            $table->integer('subtask_id')->unsigned();
            $table->foreign('subtask_id')->references('id')->on('subtasks');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('volunteer_subtask_shifts', function ($table) {
            $table->increments('id');
            $table->string('description', 500)->nullable();

            $table->integer('subtask_shifts_id')->unsigned();
            $table->foreign('subtask_shifts_id')->references('id')->on('subtask_shifts');

            $table->integer('volunteer_id')->unsigned();
            $table->foreign('volunteer_id')->references('id')->on('volunteers');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('volunteer_subtask_shifts');
        Schema::dropIfExists('subtask_shifts');
    }
}
