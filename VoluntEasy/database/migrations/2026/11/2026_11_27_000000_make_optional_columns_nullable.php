<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Columns that the forms leave out when they are optional. They were NOT NULL
 * without a default, which worked only in MySQL non-strict mode.
 *
 * - users.image_name: a user does not need a profile image.
 * - actions.volunteer_sum: not shown in flavours with tasks; "-" when empty.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_name')->nullable()->change();
        });
        Schema::table('actions', function (Blueprint $table) {
            $table->string('volunteer_sum')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image_name')->nullable(false)->change();
        });
        Schema::table('actions', function (Blueprint $table) {
            $table->string('volunteer_sum')->nullable(false)->change();
        });
    }
};
