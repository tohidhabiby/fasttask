<?php

namespace App\Models\User;

use App\Interfaces\Models\User\RoleInterface;
use App\Models\BaseModel;
use App\Traits\HasTitleTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends BaseModel implements RoleInterface
{
    use HasTitleTrait;

    /**
     * @var string[]
     */
    public static array $customRoles = [
        self::ADMIN_ROLE,
        self::USER_ROLE,
        self::SUPPORT,
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @param string $title Title.
     *
     * @return RoleInterface
     */
    public static function createObject(string $title): RoleInterface
    {
        $role = new static();
        $role->setTitle($title)->save();

        return $role;
    }

    /**
     * @param string $title Title.
     *
     * @return RoleInterface
     */
    public function updateObject(string $title): RoleInterface
    {
        $this->setTitle($title)->save();

        return $this;
    }

    /**
     * @return array
     */
    public function exportColumns(): array
    {
        return [
            Role::ID,
            Role::TITLE,
        ];
    }

    /**
     * get role by title.
     *
     * @param string $title Title.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public static function getRoleByTitle(string $title): Model|null
    {
        return self::whereTitle($title)->first();
    }
}
