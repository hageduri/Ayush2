<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\AllUsersPolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Access\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Gate::policy(User::class, AllUsersPolicy::class);

        // Gate::define('userViewPolicy', [UserPolicy::class, 'viewAny']);
        // Gate::define('userViewPolicy.view', [UserPolicy::class, 'view']);
    }
}
