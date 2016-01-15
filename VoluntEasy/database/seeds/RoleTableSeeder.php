<?php

use App\Models\Roles\ModuleAction;
use Illuminate\Database\Seeder;
use App\Models\Roles\Module;
use App\Models\Roles\Role;
use App\Models\Roles\Permission;

class RoleTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     * Use php artisan db:seed to run the seed files.
     *
     * @return void
     */
    public function run() {
        //Add roles
        $admin = new Role(['name' => 'admin']);
        $unit_manager = new Role(['name' => 'unit_manager']);
        $action_manager = new Role(['name' => 'action_manager']);

        $admin->save();
        $unit_manager->save();
        $action_manager->save();

        //Add modules
        $action = new Module(['name' => 'action']);
        $collaboration = new Module(['name' => 'collaboration']);
        $unit = new Module(['name' => 'unit']);
        $user = new Module(['name' => 'user']);
        $volunteer = new Module(['name' => 'volunteer']);

        $action->save();
        $collaboration->save();
        $unit->save();
        $user->save();
        $volunteer->save();


        //Add actions
        $create = new ModuleAction(['name' => 'create']);
        $delete = new ModuleAction(['name' => 'delete']);
        $read = new ModuleAction(['name' => 'read']);
        $update = new ModuleAction(['name' => 'update']);

        $create->save();
        $delete->save();
        $read->save();
        $update->save();

        //Add role permissions
        $admin->permissions()->saveMany([
            new Permission(['module_id' => $action->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $collaboration->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $unit->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $user->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $volunteer->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $update->id]),
        ]);

        $unit_manager->permissions()->saveMany([
            new Permission(['module_id' => $action->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $action->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $collaboration->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $collaboration->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $unit->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $unit->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $user->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $user->id, 'action_id' => $update->id]),

            new Permission(['module_id' => $volunteer->id, 'action_id' => $create->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $delete->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $read->id]),
            new Permission(['module_id' => $volunteer->id, 'action_id' => $update->id]),
        ]);

        $action_manager->permissions()->saveMany([
            new Permission(['module_id' => $action->id, 'action_id' => $read->id]),

            new Permission(['module_id' => $user->id, 'action_id' => $read->id]),
        ]);

    }
}
