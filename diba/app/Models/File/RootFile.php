<?php

namespace App\Models\File;

use App\Interfaces\Models\File\RootFileInterface;
use App\Models\BaseModel;
use App\Traits\HasSizeTrait;
use App\Traits\IsSyncedTrait;

class RootFile extends BaseModel implements RootFileInterface
{
    use HasSizeTrait;
    use IsSyncedTrait;

    /** @var boolean */
    public $timestamps = false;

    const RETRY = 'retry';
    const NEXT_RETRY = 'next_retry';

    /**
     * @var array
     */
    protected $casts = [
        self::SYNCED => 'boolean',
    ];

    /**
     * Find or create rootFile.
     *
     * @param string  $hashContent Content hash.
     * @param string  $mimeType    Mime type.
     * @param integer $size        Size.
     * @param string  $path        Path.
     *
     * @return RootFileInterface
     */
    public static function createObject(
        string $hashContent,
        string $mimeType,
        int $size,
        string $path
    ): RootFileInterface {
        $rootFile = self::whereContentHash($hashContent)->first();

        if ($rootFile) {
            return $rootFile;
        }

        $rootFile = new self();
        $rootFile->setContentHash($hashContent);
        $rootFile->setMimeType($mimeType);
        $rootFile->setSize($size);
        $rootFile->setPath($path);
        $rootFile->sync();
        $rootFile->save();

        return $rootFile;
    }

    /**
     * @return array
     */
    public function exportColumns(): array
    {
        return [
            self::PATH,
            self::CONTENT_HASH,
            self::MIME_TYPE,
            self::SIZE,
            self::SYNCED,
            self::RETRY,
            self::NEXT_RETRY,
        ];
    }
}
