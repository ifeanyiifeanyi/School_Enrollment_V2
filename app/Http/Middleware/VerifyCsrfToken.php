<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;
use Illuminate\Support\Facades\Auth;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];

    // public function handle($request, Closure $next)
    // {
    //     if ($request->route()->named('logout')) {
    //         if (!Auth::check() || Auth::guard()->viaRemember()) {
    //             $this->except[] = route('logout');
    //             $this->except[] = route('admin.logout');
    //             $this->except[] = route('student.logout');
    //         }
    //     }
    // }
}
