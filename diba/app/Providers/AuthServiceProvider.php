<?php

namespace App\Providers;

use App\Models\File\File;
use App\Models\User\Role;
use App\Models\User\User;
use App\Policies\File\FilePolicy;
use App\Policies\User\RolePolicy;
use App\Policies\User\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Role::class => RolePolicy::class,
        User::class => UserPolicy::class,
        File::class => FilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Passport::personalAccessTokensExpireIn(now()->addMinutes(env('TOKEN_EXPIRES_MINUTES')));
    }
}
