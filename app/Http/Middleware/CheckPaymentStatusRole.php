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

        // Check if the student has started an application
        if (is_null($application)) {
            // Redirect back to dashboard with a warning message
            return redirect()->route('student.dashboard')
                ->with('warning', 'You have not started an application yet. Please begin your application.');
        }

        // If the application exists but payment is pending
        if ($application->payment_status === 'pending') {
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])
                ->with('warning', 'Please complete the payment to finalize your application.');
        }

        return $next($request);
    }
}
