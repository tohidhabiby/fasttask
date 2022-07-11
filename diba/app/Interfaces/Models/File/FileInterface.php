<?php

namespace App\Interfaces\Models\File;

use App\Interfaces\Models\User\UserInterface;
use App\Interfaces\Traits\BelongsToRootFileInterface;
use App\Interfaces\Traits\HasNameInterface;
use App\Interfaces\Models\BaseModelInterface;
use App\Interfaces\Traits\HasUserIdInterface;
use App\Interfaces\Traits\IsEnableInterface;
use Illuminate\Http\UploadedFile;

interface FileInterface extends
    BaseModelInterface,
    HasNameInterface,
    IsEnableInterface,
    HasUserIdInterface,
    BelongsToRootFileInterface
{
    const TABLE = 'files';
    const EXTENSION = 'extension';
    const IS_PUBLIC = 'is_public';

    /**
     * Create file
     *
     * @param UploadedFile  $file File.
     * @param UserInterface $user User.
     *
     * @return FileInterface
     *
     * @throws \Exception Exception.
     */
    public static function createObject(UploadedFile $file, UserInterface $user): FileInterface;
}
