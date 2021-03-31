<?php

namespace App\Providers;

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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // the gate checks if the user can access organization module
        Gate::define('accessOrganizationModule', function($user) {
            return $user->role([1]);
        });

        // the gate checks if the user can access supservisor module
        Gate::define('accessSupervisorModule', function($user) {
            return $user->role([1,5]);
        });

        // the gate checks if the user can access provider module
        Gate::define('accessProviderModule', function($user) {
            return $user->role([1,2,5]);
        });

        // the gate checks if the user can access participant module
        Gate::define('accessParticipantModule', function($user) {
            return $user->role([1,2,3,5]);
        });

        // the gate checks if the user can access program module
        Gate::define('accessProgramModule', function($user) {
            return $user->role([2,5]);
        });

        // the gate checks if the user can access goal module
        Gate::define('accessGoalModule', function($user) {
            return $user->role([1,2,3,4,5]);
        });

        // the gate checks if the user can access report module
        Gate::define('accessReportModule', function($user) {
            return $user->role([1,2,5]);
        });
    }
}