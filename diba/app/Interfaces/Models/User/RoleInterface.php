<?php

namespace App\Interfaces\Models\User;

use App\Interfaces\Models\BaseModelInterface;
use App\Interfaces\Traits\HasTitleInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface RoleInterface extends BaseModelInterface, HasTitleInterface
{
    const TABLE = 'roles';

    const ADMIN_ROLE = 'admin';
    const USER_ROLE = 'user';
    const SUPPORT = 'support';

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany;

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * @param string $title Title.
     *
     * @return RoleInterface
     */
    public static function createObject(string $title): RoleInterface;

    /**
     * @param string $title Title.
     *
     * @return RoleInterface
     */
    public function updateObject(string $title): RoleInterface;
}
