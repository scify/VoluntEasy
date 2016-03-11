<?php namespace App\Models\Traits;

use App\Models\Action;
use App\Models\Roles\Role;
use App\Models\Unit;
use App\Services\Facades\NotificationService;
use App\Services\Facades\UnitService;
use App\Services\Facades\UserService;

/**
 * Trait Permissible is used to determine whether
 * a user has permission to perform certain actions.
 *
 * Class Permissible
 * @package App\Models\Traits
 */
trait Permissible {

    /**
     * Check if the user has permission to perform a certain action
     *
     * @param $action
     * @param null $value
     * @return int
     */
    public function hasPermission($action, $value = null) {

        $pieces = explode(".", $action);
        $module = $pieces[0];
        $action = $pieces[1];

        $this->load('roles.permissions.module', 'roles.permissions.action');

        //first check if any of the roles assigned to the user has the permission
        //to perform the requested action
        foreach ($this->roles as $role) {

            $hasModule = false;
            $hasAction = false;

            foreach ($role->permissions as $permission) {

                if ($module == $permission->module->name)
                    $hasModule = true;

                if ($action == $permission->action->name && $hasModule) {
                    $hasAction = true;
                    break;
                }
            }
        }

        //if the action has parameters, i.e. a user must update unit with id=5,
        //we must also check if they can edit it.
        if ($hasModule && $hasAction && $value != null) {
            if ($value != null) {

                $hasValue = false;

                switch ($module) {
                    case 'action':
                        $action = Action::where('id', $value)->first(['unit_id']);
                        if (in_array($action->unit_id, UserService::userUnits()))
                            $hasValue = true;
                        break;
                    case 'collaboration':
                        break;
                    case 'unit':
                        if (in_array($value, UserService::userUnits()))
                            $hasValue = true;
                        break;
                    case 'user':
                        break;
                    case 'volunteer':
                        break;
                }
            }
        }

        if ($hasModule && $hasAction && ($value == null || $hasValue))
            return 1;
        else
            return 0;
    }

    /**
     *
     * Attach or detach roles to the user.
     * According to the assigned roles, decide if we should
     * also sync actions/units/both/neither.
     *
     * @param $values
     */
    public function refreshRoles($values) {

        $roles = Role::whereIn('name', $values)->get(['id']);

        $this->roles()->sync($roles);

        if (in_array('admin', $values)) {
            //only sync with root unit
            $this->units()->sync([UnitService::getRoot()->id]);
            //remove all actions, admin can do anything
            $this->actions()->detach();
        } else {
            if (in_array('unit_manager', $values)) {
                //refresh user units
                if (\Request::has('unitsSelect') && sizeof(\Request::get('unitsSelect')) > 0) {
                    
                    $this->units()->sync(\Request::get('unitsSelect'));

                    foreach (\Request::get('unitsSelect') as $unitId) {
                        $unit = Unit::find($unitId);
                        NotificationService::userToUnit($this->id, $unit);
                    }
                }

                if (in_array('action_manager', $values)) {
                    //refresh user actions
                    if (\Request::has('actionsSelect') && sizeof(\Request::get('actionsSelect')) > 0)
                        $this->actions()->sync(\Request::get('actionsSelect'));
                }
            }
        }
    }
}
