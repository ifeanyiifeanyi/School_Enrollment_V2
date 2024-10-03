<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatusRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $application = $user->applications()->latest()->first(); // Get the most recent application

        if (!$application) {
            // No application exists, redirect to start a new application
            return redirect()->route('student.dashboard')
                ->with('info', 'You have not started an application yet. Please begin your application.');
        }

        if (is_null($application->payment_id)) {
            // Application exists but payment is pending
            $notification = [
                'message' => 'Please complete the payment to finalize your application.',
                'alert-type' => 'info'
            ];
            return redirect()->route('payment.view.finalStep', ['userSlug' => $user->nameSlug])->with($notification);
        }

        return $next($request);
    }
}
