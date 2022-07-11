<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasTitleTrait
{
    /**
     * @param Builder $builder Builder.
     * @param string  $title   Title.
     * @return Builder
     */
    public function scopeWhereTitleLike(Builder $builder, string $title): Builder
    {
        return $builder->where(self::TITLE, 'like', "%$title%");
    }

    /**
     * @param Builder $builder Builder.
     * @param string  $title   Title.
     * @return Builder
     */
    public function scopeOrWhereTitleLike(Builder $builder, string $title): Builder
    {
        return $builder->orWhere(self::TITLE, 'like', "%$title%");
    }
}
