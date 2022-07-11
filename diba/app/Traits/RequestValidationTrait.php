<?php

namespace App\Traits;

use App\Models\File\File;
use App\Models\User\User;
use Illuminate\Validation\Rule;

trait RequestValidationTrait
{
    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function password(array $rules = []): array
    {
        return array_merge(
            [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
            ],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function mobile(array $rules = []): array
    {
        return array_merge(
            ['required', 'numeric', 'regex:/^09{1}[0-9]{9}/'],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function fileId(array $rules = ['required']): array
    {
        return array_merge(
            [
                'integer',
                Rule::exists(File::TABLE, File::ID),
            ],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function dateRules(array $rules = ['required']): array
    {
        return array_merge(
            ['date', 'after:' . now()->format('Y-m-d'), 'date_format:Y-m-d'],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function otp(array $rules = []): array
    {
        return array_merge(
            ['required', 'integer', 'min:10000', 'max:99999'],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function userId(array $rules = []): array
    {
        return array_merge(
            [
                'required',
                'integer',
                Rule::exists(User::TABLE, User::ID),
            ],
            $rules
        );
    }

    /**
     * @param array $rules Rules.
     *
     * @return array
     */
    public function getUsernameRules(array $rules = []): array
    {
        return array_merge(
            ['required', 'string', 'min:4'],
            $rules
        );
    }
}
