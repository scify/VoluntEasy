<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration {

	
    ///////////////////////////////////////////////////
    //   Notification Types Index                    //
    //   1 = new Request from Shipper To Transporter //
    //   2 = request Rejected from Transporter       //
    //   3 = request Rejected from Transporter       //
    //   4 = request Approved from Transporter       //
    ///////////////////////////////////////////////////

 
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table)
		{
			$table->increments('id');
			$table->timestamps();
			$table->unsignedInteger('userId')->index();
			$table->integer('typeId')->index(); //  what the notification is about
			$table->integer('referenceId')->index(); // the bookingId 
			$table->string('status', 30)->nullable;  // what notification action (ring a bell, print red button on NavBar, etc..)
		});

		Schema::table('notifications', function(Blueprint $table)
		{
			$table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
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
		 	$table->dropForeign('notifications_userid_foreign');
        });

		Schema::dropIfExists('notifications');
		
	}

}
