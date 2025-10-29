<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\EditLog;

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
        // Share unread notifications count to admin layout
        View::composer('layouts.admin', function ($view) {
            $unreadNotifications = EditLog::where('admin_notified', false)->count();
            $view->with('unreadNotifications', $unreadNotifications);
        });
    }
}
