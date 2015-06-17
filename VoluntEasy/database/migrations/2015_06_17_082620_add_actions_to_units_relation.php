<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddActionsToUnitsRelation extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('units', function($table)
		{
			$table->integer('action_id')->unsigned;
			$table->foreign('action_id')->references('id')->on('actions');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('units', function($table)
		{
			$table->dropColumn('action_id');
		});
	}

}
