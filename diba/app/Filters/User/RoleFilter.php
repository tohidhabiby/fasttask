<?php

namespace App\Filters\User;

use App\Models\User\Role;
use App\Traits\Filters\FilterIdsTrait;
use App\Traits\Filters\FilterTitleTrait;
use Habibi\Filters\Filters;

class RoleFilter extends Filters
{
    use FilterIdsTrait;
    use FilterTitleTrait;

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    protected array $filters = [
        'title',
        'ids',
    ];

    /**
     * Registered filters to operate upon.
     *
     * @var array
     */
    public array $attributes = [
        'title' => 'string',
        'ids' => 'array',
    ];

    /**
     * Registered Order By Columns.
     *
     * @var array
     */
    public array $orderByColumns = [
        Role::ID,
        Role::TITLE,
    ];
}
