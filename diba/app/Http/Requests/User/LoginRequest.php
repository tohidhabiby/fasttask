<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;
use App\Models\User\User;

/**
 * Class LoginRequest
 *
 *
 * @package App\Http\Requests
 */
class LoginRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            User::PASSWORD => $this->password(),
            User::USERNAME => $this->getUsernameRules(),
        ];
    }
}
