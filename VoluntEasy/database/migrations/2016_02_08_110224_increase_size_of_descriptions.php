<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class IncreaseSizeOfDescriptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('volunteers', function($table)
        {
            $table->string('participation_reason', 600)->nullable()->change();
            $table->string('participation_previous', 600)->nullable()->change();
            $table->string('participation_actions', 600)->nullable()->change();
            $table->string('additional_skills', 600)->nullable()->change();
            $table->string('work_description', 600)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
