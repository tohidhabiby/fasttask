<?php

namespace App\Http\Resources\User;

use App\Constants\PermissionTitle;
use App\Http\Resources\RiskFlow\RiskFlowResource;
use App\Http\Resources\Stock\BasketResource;
use App\Http\Resources\Stock\SymbolResource;
use App\Interfaces\Models\User\UserInterface;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @var UserInterface|null
     */
    private UserInterface|null $userObject;

    /**
     * UserResource constructor.
     * @param $resource
     *
     * @param UserInterface|null $userObject UserObject.
     */
    public function __construct($resource, mixed $userObject = null)
    {
        $this->userObject = $userObject instanceof UserInterface ? $userObject : null;
        parent::__construct($resource);
    }

    /**
     * Transform the resource into an array.
     *
     * @param Request $request Request.
     *
     * @return array
     */
    public function toArray($request): array
    {
        return  [
            User::ID => $this->getId(),
            User::FIRST_NAME => $this->getFirstName(),
            User::LAST_NAME => $this->getLastName(),
            User::GENDER => $this->getGender(),
            User::CREATED_AT => $this->getCreatedAt(),
            User::UPDATED_AT => $this->getUpdatedAt(),
            User::INTERNATIONAL_NUMBER => $this->getInternationalNumber(),
            User::MOBILE => $this->getMobile(),
            User::PHONE => $this->getPhone(),
            User::BEST_TIME_FOR_CALL => $this->getBestTimeForCall(),
            User::ADDRESS => $this->getAddress(),
            User::OTHER_CONTACT_WAY => $this->getOtherContactWay(),
            User::POST_CODE => $this->getPostCode(),
            User::LAST_LOGIN => $this->getLastLogin(),
            User::IS_ACTIVE => $this->getIsActive(),
            'roles' => $this->whenLoaded(
                'roles',
                function () {
                    return RoleResource::collection($this->roles);
                }
            ),
        ];
    }
}
