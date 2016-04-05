<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeighnKeyOpaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('volunteer_opa_ratings', function ($table) {
            $table->integer('action_rating_id')->unsigned();
            $table->foreign('action_rating_id')->references('id')->on('action_ratings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('volunteer_opa_ratings', function ($table) {
            $table->dropForeign('action_rating_id');
        });
    }
}
