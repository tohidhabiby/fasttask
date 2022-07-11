<?php

namespace App\Http\Resources\File;

use App\Http\Resources\User\UserResource;
use App\Models\File\File;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FileResource extends JsonResource
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
            File::ID => $this->getId(),
            File::USER_ID => $this->getUserId(),
            File::EXTENSION => $this->getExtension(),
            File::ENABLED => $this->isEnable(),
            File::NAME => $this->getName(),
            File::IS_PUBLIC => $this->getIsPublic(),
            'root_file' => new RootFileResource($this->rootFile),
            File::CREATED_AT => $this->{File::CREATED_AT},
            File::UPDATED_AT => $this->{File::UPDATED_AT},
            'user' => $this->whenLoaded(
                'user',
                function () {
                    return new UserResource($this->user);
                }
            ),
        ];
    }
}
