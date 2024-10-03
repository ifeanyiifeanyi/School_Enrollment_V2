<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApplicationPaymentStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user->applications) {
            return redirect()->route('student.dashboard')->with('error', 'You have not submitted an application yet.');
        }

        if (!$user->applications->payment_id) {
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
                ->with('warning', 'Please complete your payment to access this page.');
        }
        return $next($request);
    }
}
