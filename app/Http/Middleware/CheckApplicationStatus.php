<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApplicationStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user) {
            $application = $user->applications
                ->whereNotNull('payment_id')
                ->first();

                $notification = [
                    'message' => 'You have already submitted an application!',
                    'alert-type' => 'info'
                ];

            if ($application) {
                return redirect()->route('student.dashboard')->with($notification);
            }
        }
        return $next($request);
    }
}
