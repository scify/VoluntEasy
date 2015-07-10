<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

    //////////////////////////////////////////////////////////////////////////
    //   Notification Types Index                                           //
    //   1 = Volunteer is assighned to Unit (Unit-Users)                    //
    //   2 = Volunteer is deleted or unAssighned (top Users)                //
    //   3 = Voluteer is in the midle of actions period (parent Unit-Users) //
    //   4 = action is expired ...   (parent Unit-Users)                    //
    //   4 = Volunteer submited the Questionare (parent Unit-Users)         //
    //////////////////////////////////////////////////////////////////////////

 
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function($table)
		{
			$table->increments('id');
			$table->unsignedInteger('user_id')->index();
			$table->integer('type_id')->index(); // the Model instance id that we have o locate 
			$table->integer('reference1_id')->index(); // the bookingId 
			$table->integer('reference2_id')->nullable(); // a second Model instance id that maybe we have o locate
			$table->string('status', 30)->nullable();  // what notification action (ring a bell, print red button on NavBar, etc..)
			$table->string('msg', 300);
			$table->string('url', 100);
			$table->timestamps();
		});

		Schema::table('notifications', function($table)
		{
			$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::table('notifications', function($table)
        {
		 	$table->dropForeign('notifications_user_id_foreign');
        });

		Schema::dropIfExists('notifications');
		
	}

}
