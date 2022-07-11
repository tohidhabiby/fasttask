<?php

namespace App\Filters\User;

use App\Models\User\Permission;
use Habibi\Filters\Filters;
use App\Traits\Filters\FilterIdsTrait;
use App\Traits\Filters\FilterTitleTrait;

class PermissionFilter extends Filters
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
        Permission::ID ,
        Permission::TITLE ,
    ];
}
