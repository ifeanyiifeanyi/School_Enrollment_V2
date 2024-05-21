<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SiteSettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function($view) {
            $siteSetting = SiteSetting::first() ?? null;

            if ($siteSetting) {
                $view->with('siteSetting', $siteSetting);
            } else {
                $view->with('siteSetting', null);
            }
        });
    }
}
