<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
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
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('editComment', function ($user, $commentUserId) {
            return $user->role === 'admin' || $user->id == $commentUserId;
        });

        Gate::define('deleteComment', function ($user, $comment) {
//            dd($user->role);
            return $user->role === 'admin' || $user->id === $comment->user_id;
        });
    }
}
