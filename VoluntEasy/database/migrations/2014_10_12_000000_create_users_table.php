<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('user_addr');
			$table->string('user_tel', 50);
			$table->rememberToken()->nullable();
			$table->timestamps();
		});

		Schema::create('user_role', function($table)
		{
			$table->increments('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
		});

		Schema::create('user_descr', function($table)
		{
			$table->integer('role_id')->unsigned();
			$table->foreign('role_id')->references('id')->on('user_role');
			$table->text('role_descr');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_descr');
		Schema::drop('user_role');
		Schema::drop('users');
	}

}
