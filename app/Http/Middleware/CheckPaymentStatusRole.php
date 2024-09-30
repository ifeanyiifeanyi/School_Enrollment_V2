<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatusRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $application = $user->applications;
        // dd($user);

        if ($application) {

            if ($application->payment_status === 'pending') {
                return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
                    ->with('warning', 'Please complete the payment to finalize your application.');
            }
        }
        // if (empty($application->payment_id)) {
        //     return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
        //         ->with('warning', 'Please complete the payment to finalize your application.');
        // }

        // if (empty($application->payment_id)) {
        //     return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
        //         ->with('warning', 'Please complete the payment to finalize your application.');
        // }
        return $next($request);
    }
}
