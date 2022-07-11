<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterIsActiveTrait
{
    /**
     * @param boolean $active Is Active.
     *
     * @return Builder
     */
    public function isActive(bool $active): Builder // phpcs:ignore
    {
        if ($active) {
            return $this->builder->whereActive();
        }

        return $this->builder->whereNotActive();
    }
}
