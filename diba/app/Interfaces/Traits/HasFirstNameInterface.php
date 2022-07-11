<?php

namespace App\Interfaces\Traits;

use Illuminate\Database\Eloquent\Builder;

interface HasFirstNameInterface
{
    const FIRST_NAME = 'first_name';

    /**
     * @param Builder $builder   Builder.
     * @param string  $firstName First Name.
     *
     * @return Builder
     */
    public function scopeWhereFirstNameLike(Builder $builder, string $firstName): Builder;

    /**
     * @param Builder $builder   Builder.
     * @param string  $firstName First Name.
     *
     * @return Builder
     */
    public function scopeOrWhereFirstNameLike(Builder $builder, string $firstName): Builder;
}
