<?php

namespace App\Interfaces\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

interface HasUserIdInterface
{
    const USER_ID = 'user_id';

    /**
     * @param Builder $builder Builder.
     * @param integer $userId  ID.
     *
     * @return Builder
     */
    public function scopeOrWhereUserIdIs(Builder $builder, int $userId): Builder;

    /**
     * @param Builder $builder Builder.
     * @param array   $userIds User IDs.
     *
     * @return Builder
     */
    public function scopeWhereUserIdIn(Builder $builder, array $userIds): Builder;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo;
}
