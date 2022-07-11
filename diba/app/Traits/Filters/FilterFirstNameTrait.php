<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterFirstNameTrait
{
    /**
     * Filter by name.
     *
     * @param string $firstName First Name.
     *
     * @return Builder
     */
    protected function firstName(string $firstName): Builder
    {
        return $this->builder->whereFirstNameLike($firstName);
    }
}
