<?php

namespace App\Policies\User;

use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user User.
     * @return boolean|\Illuminate\Auth\Access\Response
     */
    public function details(User $user): bool|\Illuminate\Auth\Access\Response
    {
        if (is_null($user->userDetail)) {
            return true;
        }

        return $this->deny(__('error.you_filled_details_before'), Response::HTTP_FORBIDDEN);
    }

    /**
     * @param User $user     User.
     * @param User $customer Customer.
     *
     * @return boolean|\Illuminate\Auth\Access\Response
     */
    public function riskScoreNotNull(User $user, User $customer): bool|\Illuminate\Auth\Access\Response
    {
        if (!empty($customer->getRiskFlowId())) {
            return true;
        }

        return $this->deny(__('error.user_risk_score_is_null_or_confirmed_before'));
    }
}
