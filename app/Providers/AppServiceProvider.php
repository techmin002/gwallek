<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\OrderManager\Models\Order;

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

public function boot()
{
    view()->composer('*', function ($view) {
        $pendingCount = Order::where('status', 'pending')->count();
        $view->with('pendingCount', $pendingCount);
    });
}

}
