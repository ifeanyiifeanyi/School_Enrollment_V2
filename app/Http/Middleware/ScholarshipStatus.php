<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ScholarApplication;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ScholarshipStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $application = ScholarApplication::where('user_id', Auth::id())->first();
        if (!$application) {
            return redirect()->route('student.scholarship.view')->with('error', 'You need to submit an application first.');
        }
        return $next($request);
    }
}
