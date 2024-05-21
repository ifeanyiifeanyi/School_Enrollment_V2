<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
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
        $user = auth()->user();
        $application = $user->applications->first();

        if ($application && is_null($application->payment_id)) {
            // Application form has been filled, but payment is pending
            $notification = [
                'message' => 'Please complete the payment to finalize your application.',
                'alert-type' => 'info'
            ];
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])->with($notification);
        }
        return $next($request);
    }
}
