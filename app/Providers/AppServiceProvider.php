<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
        // Admin IT can manage users & master data
        Gate::define('manage-master-data', function (User $user) {
            return $user->status === 'aktif' && $user->hasRole('admin_it');
        });

        Gate::define('manage-users', function (User $user) {
            return $user->status === 'aktif' && $user->hasRole('admin_it');
        });

        // Admin IT is strictly forbidden from approval, payment, and receipt confirmation
        Gate::define('approve-request', function (User $user) {
            return $user->status === 'aktif' && $user->hasRole('approver') && ! $user->hasRole('admin_it');
        });

        Gate::define('process-payment', function (User $user) {
            return $user->status === 'aktif' && $user->hasRole('admin_pencairan') && ! $user->hasRole('admin_it');
        });

        Gate::define('confirm-receipt', function (User $user) {
            return $user->status === 'aktif' && $user->hasRole('penerima') && ! $user->hasRole('admin_it');
        });
    }
}
