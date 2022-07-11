<?php

namespace App\Interfaces\Models\User;

use App\Interfaces\Models\BaseModelInterface;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface PermissionInterface extends BaseModelInterface
{
    const TABLE = 'permissions';

    /**
     * Generate permission title.
     *
     * @param string      $methodName Method name.
     * @param string|null $slug       Slug.
     * @param string|null $related    Related.
     *
     * @return string|null
     */
    public static function generatePermissionTitle(string $methodName, ?string $slug = null, array $related): ?string;

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany;
}
