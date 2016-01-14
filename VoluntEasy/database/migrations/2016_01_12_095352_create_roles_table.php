<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Keeps the roles (admin, unit_manager, action_manager etc)
        Schema::create('roles', function($table)
        {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        //Keeps the main modules of the platform that a user can perform actions to
        //For example Unit, Action, User
        Schema::create('modules', function($table)
        {
            $table->increments('id');
            $table->string('name');

            $table->timestamps();
        });

        //The actions that a user can perform to a module, for example CRUD
        Schema::create('module_actions', function($table)
        {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        //User to roles table
        Schema::create('users_roles', function($table)
        {
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');

            $table->timestamps();
        });

        //Role permissions
        Schema::create('roles_permissions', function($table)
        {
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles');

            $table->integer('module_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('modules');

            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')->references('id')->on('module_actions');

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
        Schema::dropIfExists('roles_actions');
        Schema::dropIfExists('users_roles');
        Schema::dropIfExists('roles_permissions');
        Schema::dropIfExists('module_actions');
        Schema::dropIfExists('modules');
        Schema::dropIfExists('roles');
    }
}
