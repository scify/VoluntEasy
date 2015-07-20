<?php

use Illuminate\Database\Migrations\Migration;

class AddExtraColumns extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::table('steps', function ($table) {
            $table->string('type');
        });

        Schema::table('actions_volunteers_history', function ($table) {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('notifications', function ($table) {
            $table->dropColumn('type');
        });

        Schema::table('actions_volunteers_history', function ($table) {
            $table->dropForeign('user_id');
        });
    }

}
