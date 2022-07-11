<?php

namespace App\Rules;

use App\Models\File\File;
use Illuminate\Contracts\Validation\Rule;

class CheckFileExtensionRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(protected array|null $extensions = []) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute Attribute.
     * @param mixed $value Value.
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $file = File::find($value);
        if ($file) {
            if (!in_array(strtolower($file->getExtension()), $this->extensions)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return __(
            'validation.uploaded_file_extensions',
            [
                'values' => implode(',', $this->extensions),
            ]
        );
    }
}
