<?php

namespace App\Models\User;

use App\Interfaces\Models\User\PermissionInterface;
use App\Models\BaseModel;
use App\Traits\HasTitleTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Permission extends BaseModel implements PermissionInterface
{
    use HasTitleTrait;

    const TITLE = 'title';

    /**
     * @var string[]
     */
    protected $fillable = [self::TITLE];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Generate permission title.
     *
     * @param string      $methodName Method name.
     * @param string|null $slug       Slug.
     * @param array       $related    Related.
     *
     * @return string|null
     */
    public static function generatePermissionTitle(string $methodName, ?string $slug = null, array $related): ?string
    {
        if ($slug === null) {
            return null;
        }

        if (count($related) > 1) {
            switch ($related[0]) {
                case 'get':
                    $permission =  'GetAll' . $slug . $related[1];
                    break;
                case 'post':
                case 'add':
                    $permission = 'Create' . $slug . $related[1];
                    break;
                case 'sync':
                    $permission = 'Update' . $slug . $related[1];
                    break;
                case 'delete':
                    $permission = 'Delete' . $slug . $related[1];
                    break;
                case 'sync':
                    $permission = 'Sync' . $slug . $related[1];
                    break;
                default:
                    return null;
            }
        } else {
            switch ($methodName) {
                case 'index':
                    $plural_slug = Str::plural($slug);
                    $permission = (count($related) == 1) ?
                        'GetAll' . $plural_slug : 'GetAll' . $plural_slug . $related[1];
                    break;

                case 'show':
                    $permission = (count($related) == 1)  ? 'Get' . $slug : 'Get' . $slug . $related[1];
                    break;

                case 'store':
                    $permission = (count($related) == 1)  ? 'Create' . $slug : 'Create' . $slug . $related[1];
                    break;

                case 'destroy':
                    $permission = (count($related) == 1)  ? 'Delete' . $slug : 'Delete' . $slug . $related[1];
                    break;

                case 'update':
                    $permission = (count($related) == 1)  ? 'Update' . $slug : 'Update' . $slug . $related[1];
                    break;


                default:
                    return null;
            }
        }

        return $permission;
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @return array
     */
    public function exportColumns(): array
    {
        return [
            self::ID,
            self::TITLE,
        ];
    }
}
