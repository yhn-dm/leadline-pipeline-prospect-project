<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
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
        Paginator::useTailwind();

        Blade::component('components.app-layout', 'app-layout');
        View::composer('*', function ($view) {
            $user = Auth::user();
            $spaces = $user ? $user->spaces : collect(); // Collection vide si non connecté
            $view->with('spaces', $spaces);
        });
    }
}
