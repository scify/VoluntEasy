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
		Schema::table('actions', function($table)
		{
			$table->integer('unit_id')->unsigned();
			$table->foreign('unit_id')->references('id')->on('units');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('actions', function($table)
		{
			//$table->dropColumn('unit_id');
		});
	}

}
