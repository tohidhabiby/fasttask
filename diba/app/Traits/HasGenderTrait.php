<?php

namespace App\Traits;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

trait HasGenderTrait
{
    /**
     * @param Builder $builder Builder.
     * @param string  $gender  Gender.
     *
     * @return Builder
     */
    public function scopeWhereGenderLike(Builder $builder, string $gender): Builder
    {
        return $builder->where(User::GENDER, 'like', "%$gender%");
    }

    /**
     * @param Builder $builder Builder.
     * @param string  $gender  Gender.
     *
     * @return Builder
     */
    public function scopeOrWhereGenderLike(Builder $builder, string $gender): Builder
    {
        return $builder->orWhere(User::GENDER, 'like', "%$gender%");
    }
}
