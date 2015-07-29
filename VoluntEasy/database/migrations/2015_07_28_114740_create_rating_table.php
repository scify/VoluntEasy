<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration {

	/**
	 * Run the migrations.
	 * 
	 * $num = $volunteer->ratings->count();
	 * 
	 * $volunteer->ratings->lists(attr1); 
	 * 
	 * @return void
	 */
	public function up()
	{
		Schema::create('rating_volunteer_action', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers')->onDelete('cascade');
			
			$table->integer('action_id')->unsigned();
			$table->foreign('action_id')->references('id')->on('actions')->onDelete('cascade');

			$table->string('email');

			// $string = str_random(30);
			$table->string('token',30);

			$table->integer('attr1')->default(0);
			$table->integer('attr2')->default(0);
			$table->integer('attr3')->default(0);
			$table->timestamps();

			$table->index('volunteer_id');
		});

		Schema::create('ratings', function($table)
		{
			$table->increments('id');
			$table->integer('volunteer_id')->unsigned();
			$table->foreign('volunteer_id')->references('id')->on('volunteers');			
			
			$table->integer('rating_attr1')->default(0);
			$table->integer('rating_attr1_count')->default(0);
			$table->integer('rating_attr2')->default(0);
			$table->integer('rating_attr2_count')->default(0);
			$table->integer('rating_attr3')->default(0);
			$table->integer('rating_attr3_count')->default(0);

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
		Schema::dropIfExists('rating_volunteer_action');
		Schema::dropIfExists('ratings');
	}
}
