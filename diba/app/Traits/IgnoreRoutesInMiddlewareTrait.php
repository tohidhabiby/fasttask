<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

trait IgnoreRoutesInMiddlewareTrait
{
    /**
     * @var array
     */
    private array $except = [];

    /**
     * @return void
     */
    abstract private function ignoreRoutes(): void;

    /**
     * @return string|null
     */
    private function currentRoute(): ?string
    {
        $route = Route::getRoutes()->match(request());

        return $route->getName();
    }

    /**
     * @return boolean
     */
    private function shouldIgnore(): bool
    {
        $this->ignoreRoutes();

        return in_array($this->currentRoute(), $this->except);
    }
}
