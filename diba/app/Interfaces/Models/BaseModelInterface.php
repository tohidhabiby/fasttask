<?php

namespace App\Interfaces\Models;

use App\Interfaces\Traits\HasIdInterface;

interface BaseModelInterface extends HasIdInterface
{
    /**
     * @return array
     */
    public function exportColumns(): array;
}
