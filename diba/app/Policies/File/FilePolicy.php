<?php

namespace App\Policies\File;

use App\Constants\PermissionTitle;
use App\Models\File\File;
use App\Models\User\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Response;

class FilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user User.
     * @param File $file File.
     *
     * @return \Illuminate\Auth\Access\Response|boolean
     */
    public function view(User $user, File $file): \Illuminate\Auth\Access\Response|bool
    {
        if (
            $file->getIsPublic() ||
            $file->user->is($user) ||
            $user->hasPermission(PermissionTitle::GET_ALL_FILES)
        ) {
            return true;
        }

        return $this->deny(__('error.you_have_not_access_to_this_file'), Response::HTTP_FORBIDDEN);
    }
}
