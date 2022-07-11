<?php

namespace App\Filters\User;

use App\Models\User\User;
use App\Traits\Filters\FilterEmailTrait;
use App\Traits\Filters\FilterFirstNameTrait;
use App\Traits\Filters\FilterFullNameTrait;
use App\Traits\Filters\FilterIdsTrait;
use App\Traits\Filters\FilterIsActiveTrait;
use App\Traits\Filters\FilterLastNameTrait;
use App\Traits\Filters\FilterUsernameTrait;
use Habibi\Filters\Filters;

class UserFilter extends Filters
{
    use FilterIdsTrait;
    use FilterEmailTrait;
    use FilterFirstNameTrait;
    use FilterLastNameTrait;
    use FilterUsernameTrait;
    use FilterFullNameTrait;
    use FilterIsActiveTrait;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = [
        'ids',
        'fullName',
        'firstName',
        'lastName',
        'username',
        'email',
        'isActive',
    ];

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    public array $attributes = [
        'ids' => 'array',
        'fullName' => 'string',
        'firstName' => 'string',
        'lastName' => 'string',
        'email' => 'string',
        'isActive' => 'boolean',
    ];

    /**
     * Registered Order By Columns.
     *
     * @var array
     */
    public array $orderByColumns = [
        User::ID,
        User::FIRST_NAME,
        User::LAST_NAME,
        User::USERNAME,
        User::EMAIL,
        User::IS_ACTIVE,
    ];
}
