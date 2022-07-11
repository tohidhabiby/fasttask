<?php

namespace App\Interfaces\Traits;

use Illuminate\Database\Eloquent\Builder;

interface HasGenderInterface
{
    const GENDER = 'gender';

    const GENDER_NONE = 'none';
    const GENDER_MALE = 'male';
    const GENDER_FEMALE = 'female';

    /**
     * @param Builder $builder Builder.
     * @param string  $gender  Gender.
     *
     * @return Builder
     */
    public function scopeWhereGenderLike(Builder $builder, string $gender): Builder;

    /**
     * @param Builder $builder Builder.
     * @param string  $gender  Gender.
     *
     * @return Builder
     */
    public function scopeOrWhereGenderLike(Builder $builder, string $gender): Builder;
}
