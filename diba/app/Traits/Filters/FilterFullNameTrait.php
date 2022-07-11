<?php

namespace App\Traits\Filters;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Builder;

trait FilterFullNameTrait
{
    /**
     * Filter by name.
     *
     * @param string $fullName First Name.
     *
     * @return Builder
     */
    protected function fullName(string $fullName): Builder
    {
        $array = explode(' ', $fullName);
        foreach ($array as $item) {
            $this->builder->where(
                function (Builder $query) use ($item) {
                    $query->where(User::FIRST_NAME, 'like', "%$item%")
                        ->orWhere(User::LAST_NAME, 'like', "%$item%");
                }
            );
        }

        return $this->builder;
    }
}
