<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterIsinTrait
{
    /**
     * Filter by Isin.
     *
     * @param string $isin Isin.
     *
     * @return Builder
     */
    protected function isin(string $isin): Builder
    {
        return $this->builder->whereIsin($isin);
    }
}
