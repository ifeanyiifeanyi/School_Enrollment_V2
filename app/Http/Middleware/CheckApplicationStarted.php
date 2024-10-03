<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Application;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckApplicationStarted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $application = Application::where('user_id', $user->id)
                                  ->whereNotNull('invoice_number')
                                  ->first();

        if (!$application) {
            return redirect()->route('student.admission.application')
                             ->with('error', 'Please start your application before proceeding to payment.');
        }

        // Pass the application to the route
        $request->merge(['application' => $application]);
        return $next($request);
    }
}
