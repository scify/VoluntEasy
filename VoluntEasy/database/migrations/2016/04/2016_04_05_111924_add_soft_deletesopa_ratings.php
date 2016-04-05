<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletesopaRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('volunteer_opa_ratings', function ($table) {
            $table->softDeletes();
        });

        Schema::table('volunteer_opa_labor_skills', function ($table) {
            $table->softDeletes();
        });

        Schema::table('volunteer_opa_interpersonal_skills', function ($table) {
            $table->softDeletes();
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
            $table->dropColumn(['deleted_at']);
        });

        Schema::table('volunteer_opa_labor_skills', function ($table) {
            $table->dropColumn(['deleted_at']);
        });

        Schema::table('volunteer_opa_interpersonal_skills', function ($table) {
            $table->dropColumn(['deleted_at']);
        });
    }
}
