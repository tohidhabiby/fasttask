<?php

namespace App\Http\Resources\User;

use App\Models\User\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request Request.
     *
     * @return array
     */
    public function toArray($request): array
    {
        return [
            Role::ID => $this->getId(),
            Role::TITLE => $this->getTitle(),
            'permissions' => $this->whenLoaded(
                'permissions',
                function () {
                    return PermissionResource::collection($this->permissions);
                }
            ),
        ];
    }
}
