<?php

namespace App\Policies\User;

use App\Models\User\Role;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * @param Role $role Role.
     * @return boolean
     */
    private function isRoleInCustomRoles(Role $role): bool
    {
        return in_array($role->title, Role::$customRoles);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user User.
     * @param Role $role Role.
     *
     * @return boolean|\Illuminate\Auth\Access\Response
     */
    public function update(User $user, Role $role): bool|\Illuminate\Auth\Access\Response
    {
        return $this->isRoleInCustomRoles($role) ?
            $this->deny(
                __(
                    'error.cant_update_custom_role',
                    ['action' => 'update']
                )
            ) : true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user User.
     * @param Role $role Role.
     *
     * @return boolean|\Illuminate\Auth\Access\Response
     */
    public function delete(User $user, Role $role): bool|\Illuminate\Auth\Access\Response
    {
        return $this->isRoleInCustomRoles($role) ?
            $this->deny(
                __(
                    'error.cant_update_custom_role',
                    ['action' => 'delete']
                )
            ) : true;
    }
}
