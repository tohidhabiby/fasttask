<?php

namespace App\Traits\Filters;

use Illuminate\Database\Eloquent\Builder;

trait FilterStatusTrait
{
    /**
     * Filter by Status.
     *
     * @param string $status Status.
     *
     * @return Builder
     */
    protected function status(string $status): Builder
    {
        return $this->builder->whereStatus($status);
    }
}
