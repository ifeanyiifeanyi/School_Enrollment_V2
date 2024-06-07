<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Request;
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
    public function boot(UrlGenerator $url)
    {
        $checkValidSignature = (config('app.env') === 'production' && str_contains(URL::current(), 'livewire/upload-file'));

        Request::macro('hasValidSignature', function ($absolute = true) use ($checkValidSignature) {
            if ($checkValidSignature) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute);
        });

        Request::macro('hasValidRelativeSignature', function ()  use ($checkValidSignature) {
            if ($checkValidSignature) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute = false);
        });

        Request::macro('hasValidSignatureWhileIgnoring', function ($ignoreQuery = [], $absolute = true)   use ($checkValidSignature) {
            if ($checkValidSignature) {
                return true;
            }
            return URL::hasValidSignature($this, $absolute, $ignoreQuery);
        });
        if (env('APP_ENV') === 'production') {
            $url->forceScheme('https');
        }

        if(env('APP_ENV', 'production') == 'production') { // use https only if env is production
            URL::forceScheme('https');
        }
    }
}
