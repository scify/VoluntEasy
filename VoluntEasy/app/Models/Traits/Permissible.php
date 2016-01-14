<?php namespace App\Models\Traits;

use App\Models\Action;
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

        if ($hasModule && $hasAction && ($value==null || $hasValue))
            return 1;
        else
            return 0;
    }
}
