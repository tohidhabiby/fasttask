<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterLastNameTrait
{
    /**
     * Filter by name.
     *
     * @param string $lastName First Name.
     *
     * @return Builder
     */
    protected function lastName(string $lastName): Builder
    {
        return $this->builder->wherelastNameLike($lastName);
    }
}
