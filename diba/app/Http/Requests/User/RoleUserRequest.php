<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User\Role;
use Illuminate\Validation\Rule;

class RoleUserRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'role_ids' => ['required', 'array'],
            'role_ids.*' => ['required', 'integer', 'distinct', Rule::exists(Role::TABLE, Role::ID)],
        ];
    }
}
