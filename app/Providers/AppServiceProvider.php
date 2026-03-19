<?php

namespace App\Providers;

use App\Models\Notifications;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Schema::defaultStringLength(191);

        View::composer('layouts.dashboard', function ($view): void {
            $notifications = collect();
            $unreadCount = 0;

            if (Auth::check()) {
                $notifications = Notifications::query()
                    ->where('user_id', Auth::id())
                    ->orderByDesc('created_at')
                    ->limit(8)
                    ->get();

                $unreadCount = (int) $notifications->where('is_read', false)->count();
            }

            $view->with([
                'layoutNotifications' => $notifications,
                'layoutNotificationCount' => $unreadCount,
            ]);
        });
    }
}
