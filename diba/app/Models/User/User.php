<?php

namespace App\Models\User;

use App\Interfaces\Models\User\UserInterface;
use App\Models\RiskFlow\RiskFlow;
use App\Models\Stock\Basket;
use App\Models\Stock\Symbol;
use App\Traits\HasEmailTrait;
use App\Traits\HasFirstNameTrait;
use App\Traits\HasGenderTrait;
use App\Traits\HasLastNameTrait;
use App\Traits\HasUsernameTrait;
use Habibi\Interfaces\FiltersInterface;
use Habibi\Traits\HasIdTrait;
use Habibi\Traits\MagicMethodsTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements UserInterface
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasIdTrait;
    use HasEmailTrait;
    use HasFirstNameTrait;
    use HasLastNameTrait;
    use HasGenderTrait;
    use HasUsernameTrait;
    use MagicMethodsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::FIRST_NAME,
        self::EMAIL,
        self::LAST_NAME,
        self::GENDER,
        self::INTERNATIONAL_NUMBER,
        self::MOBILE,
        self::OTHER_CONTACT_WAY,
        self::PHONE,
        self::ADDRESS,
        self::USERNAME,
        self::BEST_TIME_FOR_CALL,
        self::PASSWORD,
        self::LAST_LOGIN,
        self::SECURITY_ANSWER,
        self::SECURITY_QUESTION,
        self::IS_ACTIVE,
        self::POST_CODE,
    ];

    /**
     * @var array
     */
    public static array $questions = [
        self::QUESTION_CHILDHOOD_FRIEND,
        self::QUESTION_FAVORITE_CITY,
        self::QUESTION_FAVORITE_COLOR,
        self::QUESTION_FIRST_MOBILE,
        self::QUESTION_FIRST_SCHOOL,
    ];

    /**
     * @var array
     */
    public static array $genders = [self::GENDER_MALE, self::GENDER_FEMALE];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        self::PASSWORD,
    ];

    /**
     * Filter scope.
     *
     * @param Builder          $builder Builder.
     * @param FiltersInterface $filters Filters.
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, FiltersInterface $filters): Builder
    {
        return $filters->apply($builder);
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * User has permission.
     *
     * @param string $permission Permission title.
     *
     * @return boolean
     */
    public function hasPermission(string $permission): bool
    {
        return !empty(static::whereIdIn([$this->getId()])->whereHasPermission($permission)->first());
    }

    /**
     * @param Builder $builder    Builder.
     * @param string  $permission Permission title.
     *
     * @return Builder
     */
    public function scopeWhereHasPermission(Builder $builder, string $permission): Builder
    {
        return $builder->whereHas(
            'roles',
            function (Builder $joinRole) use ($permission) {
                return $joinRole->whereHas(
                    'permissions',
                    function (Builder $joinPermission) use ($permission) {
                        return $joinPermission->whereTitle($permission);
                    }
                );
            }
        );
    }
}
