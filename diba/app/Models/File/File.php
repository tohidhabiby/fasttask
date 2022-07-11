<?php

namespace App\Models\File;

use App\Interfaces\Models\File\FileInterface;
use App\Interfaces\Models\User\UserInterface;
use App\Models\BaseModel;
use App\Traits\BelongsToRootFileTrait;
use App\Traits\HasNameTrait;
use App\Traits\HasUserIdTrait;
use App\Traits\IsEnableTrait;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class File extends BaseModel implements FileInterface
{
    use HasNameTrait;
    use IsEnableTrait;
    use BelongsToRootFileTrait;
    use HasUserIdTrait;

    /** @var array $fillable */
    protected $fillable = [
        self::IS_PUBLIC,
        self::USER_ID,
        self::NAME,
        self::EXTENSION,
    ];

    /**
     * @var array
     */
    protected $casts = [
        self::ENABLED => 'boolean',
    ];

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
    public static function createObject(UploadedFile $file, UserInterface $user): FileInterface
    {
        $hashFile = sha1_file($file);
        $extension = $file->getClientOriginalExtension();
        $fileName = $hashFile . '.' . $extension;
        $path = $fileName;
        // You can change the disk in .env file,
        // or you can create a structure in admin setting,
        // or even you can get the disk from request
        $move = Storage::disk(Config::get('filesystems.default'))->put($path, file_get_contents($file));
        if (!$move) {
            throw new \Exception('System Can Not Save The File!');
        }
        //TODO use FileService
        $rootFile = RootFile::createObject(
            $hashFile,
            $file->getClientMimeType(),
            $file->getSize(),
            Storage::url($fileName)
        );

        $dbFile = new self();
        $dbFile->setExtension($extension)
            ->setRootFileId($rootFile->getId())
            ->setName($file->getClientOriginalName())
            ->setEnabled($rootFile->isSynced())
            ->setUserId($user->getId())
            ->setIsPublic(true)
            ->save();

        return $dbFile;
    }

    /**
     * @return array
     */
    public function exportColumns(): array
    {
        return [
            self::ROOT_FILE_ID,
            self::NAME,
            self::EXTENSION,
            self::ENABLED,
        ];
    }
}
