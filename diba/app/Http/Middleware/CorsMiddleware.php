<?php

namespace App\Http\Middleware;

use App\Traits\IgnoreRoutesInMiddlewareTrait;
use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    use IgnoreRoutesInMiddlewareTrait;

    /**
     * @return void
     */
    private function ignoreRoutes(): void
    {
        $this->except = [
        ];
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request Request.
     * @param Closure $next Next.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->shouldIgnore()) {
            return $next($request);
        }

        return $next($request)
            ->header('Access-Control-Allow-Origin', '*')
            ->header('Access-Control-Allow-Methods', 'PATCH, GET, POST, PUT, DELETE, OPTIONS')
            ->header('Access-Control-Allow-Headers', '*')
            ->header('Access-Control-Allow-Credentials', ' true');
    }
}
