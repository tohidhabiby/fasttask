<?php

namespace App\Interfaces\Models\User;

use App\Interfaces\Traits\HasEmailInterface;
use App\Interfaces\Traits\HasFirstNameInterface;
use App\Interfaces\Traits\HasGenderInterface;
use App\Interfaces\Traits\HasLastNameInterface;
use App\Interfaces\Traits\HasUsernameInterface;
use Habibi\Interfaces\FiltersInterface;
use Habibi\Interfaces\HasIdInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

interface UserInterface extends
    HasIdInterface,
    HasEmailInterface,
    HasFirstNameInterface,
    HasLastNameInterface,
    HasUsernameInterface,
    HasGenderInterface
{
    const TABLE = 'users';
    const INTERNATIONAL_NUMBER = 'international_number';
    const MOBILE = 'mobile';
    const PHONE = 'phone';
    const BEST_TIME_FOR_CALL = 'best_time_for_call';
    const ADDRESS = 'address';
    const OTHER_CONTACT_WAY = 'other_contact_way';
    const PASSWORD = 'password';
    const POST_CODE = 'post_code';
    const LAST_LOGIN = 'last_login';
    const SECURITY_QUESTION = 'security_question';
    const SECURITY_ANSWER = 'security_answer';
    const QUESTION_FIRST_MOBILE = 'first_mobile';
    const QUESTION_FAVORITE_COLOR = 'favorite_color';
    const QUESTION_FIRST_SCHOOL = 'first_school';
    const QUESTION_CHILDHOOD_FRIEND = 'childhood_friend';
    const QUESTION_FAVORITE_CITY = 'favorite_city';
    const IS_ACTIVE = 'is_active';

    /**
     * Filter scope.
     *
     * @param Builder          $builder Builder.
     * @param FiltersInterface $filters Filters.
     *
     * @return Builder
     */
    public function scopeFilter(Builder $builder, FiltersInterface $filters): Builder;

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany;

    /**
     * User has permission.
     *
     * @param string $permission Permission title.
     *
     * @return boolean
     */
    public function hasPermission(string $permission): bool;

    /**
     * @param Builder $builder    Builder.
     * @param string  $permission Permission title.
     *
     * @return Builder
     */
    public function scopeWhereHasPermission(Builder $builder, string $permission): Builder;
}
