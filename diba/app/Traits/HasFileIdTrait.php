<?php

namespace App\Traits;

use App\Models\File\File;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasFileIdTrait
{
    /**
     * @return BelongsTo
     */
    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
