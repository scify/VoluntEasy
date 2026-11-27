<?php

namespace App\Models\Traits;

use App\Models\Roles\Role;
use App\Models\Unit;
use App\Services\NotificationService;
use App\Services\UnitService;

/**
 * Trait Permissible is used to determine whether
 * a user has permission to perform certain actions.
 *
 * Class Permissible
 */
trait Permissible
{
    /**
     * Attach or detach roles to the user.
     * According to the assigned roles, decide if we should
     * also sync actions/units/both/neither.
     */
    public function refreshRoles($values)
    {

        $roles = [];
        $units = [];
        $actions = [];

        if ($values != null) {

            if (in_array('admin', $values)) {
                // only sync with root unit
                array_push($units, app(UnitService::class)->getRoot()->id);

                $roles = Role::whereIn('name', $values)->get(['id']);
            } // else {
            if (in_array('unit_manager', $values)) {
                // refresh user units
                if (\Request::filled('unitsSelect') && count(\Request::get('unitsSelect')) > 0) {

                    foreach (\Request::get('unitsSelect') as $unitId) {
                        array_push($units, $unitId);
                    }

                    foreach (\Request::get('unitsSelect') as $unitId) {
                        $unit = Unit::find($unitId);
                        app(NotificationService::class)->userToUnit($this->id, $unit);
                    }
                }
            }

            if (in_array('action_manager', $values)) {
                // refresh user actions
                if (\Request::filled('actionsSelect') && count(\Request::get('actionsSelect')) > 0) {
                    $actions = \Request::get('actionsSelect');
                }
            }
            //  }

            if ((\Request::filled('unitsSelect') && count(\Request::get('unitsSelect')) > 0) ||
                (\Request::filled('actionsSelect') && count(\Request::get('actionsSelect')) > 0)
            ) {
                $roles = Role::whereIn('name', $values)->get(['id']);
            }
        }

        $this->roles()->sync($roles);
        $this->units()->sync($units);
        $this->actions()->sync($actions);

    }
}
