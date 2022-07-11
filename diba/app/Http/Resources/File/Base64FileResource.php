<?php

namespace App\Http\Resources\File;

use App\Models\File\File;
use App\Models\File\RootFile;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class Base64FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            File::EXTENSION => $this->getExtension(),
            File::NAME => $this->getName(),
            RootFile::MIME_TYPE => $this->rootFile->getMimeType(),
            RootFile::SIZE => $this->rootFile->getSize(),
            // get the disk from config or setting table or file request --> it depends on your structure
            'file' => base64_encode(
                Storage::disk(Config::get('filesystems.default'))
                    ->get($this->rootFile->getContentHash() . '.' . $this->getExtension())
            ),
        ];
    }
}
