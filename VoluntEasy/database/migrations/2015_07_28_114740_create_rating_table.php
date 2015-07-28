<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('rating_volunteer_action', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->onDelete('cascade');
			$table->integer('action_id')->onDelete('cascade');
			$table->integer('user_id')->onDelete('cascade');
			$table->integer('attr1')->default(0);
			$table->integer('attr2')->default(0);
			$table->integer('attr3')->default(0);
			$table->timestamps();

			$table->index('volunteer_id');
		});

		Schema::table('volunteers', function($table)
		{
			$table->integer('rating_attr1')->default(0);
			$table->integer('rating_attr1_count')->default(0);
			$table->integer('rating_attr2')->default(0);
			$table->integer('rating_attr2_count')->default(0);
			$table->integer('rating_attr3')->default(0);
			$table->integer('rating_attr3_count')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('rating_volunteer_action');

		Schema::table('volunteers', function($table)
		{
			$table->dropColumn('rating_attr1');
			$table->dropColumn('rating_attr1_count');
			$table->dropColumn('rating_attr2');
			$table->dropColumn('rating_attr2_count');
			$table->dropColumn('rating_attr3');
			$table->dropColumn('rating_attr3_count');
			$table->dropColumn('total');			
		});
	}

}
