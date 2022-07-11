<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User\Permission;
use App\Models\User\Role;
use Illuminate\Validation\Rule;

class RoleRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            Role::TITLE => [
                'required',
                'string',
                Rule::unique(Role::TABLE, Role::TITLE)->ignore($this->role?->getId(), Role::ID),
            ],
            'permissions' => 'sometimes|array',
            'permissions.*' => [
                'numeric',
                Rule::exists(Permission::TABLE, Permission::ID)
            ],
        ];
    }
}
