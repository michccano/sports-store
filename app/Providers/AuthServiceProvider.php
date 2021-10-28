<?php

namespace App\Providers;

use App\Models\User;

use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('sportsPress', function (User $user) {
            return $user->pick === 1
                ? Response::allow()
                : Response::deny('You have no access to the service');
        });

        Gate::define('emailVerification', function (User $user) {
            return $user->email_verified_at !== null
                ? Response::allow()
                : Response::deny('You have not verified your email address');
        });

        Gate::define('admin', function (User $user) {
            return $user->role === 1
                ? Response::allow()
                : Response::deny('You are not an admin');
        });
    }
}
