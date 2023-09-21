<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        $this->registerAppPolicies();
    }

    public function registerAppPolicies()
    {
        Gate::define('create-vender', function($user) {
            return $user->hasAccess(['create-member']);
        });

        Gate::define('create-manager', function($user) {
            return $user->hasAccess(['create-manager']);
        });

        Gate::define('create-user', function($user) {
            return $user->hasAccess(['create-user']);
        });

        Gate::define('assign-role', function($user) {
            return $user->hasAccess(['assign-role']);
        });
    }
}
