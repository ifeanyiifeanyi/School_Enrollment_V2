<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use Symfony\Component\HttpFoundation\Response;

class AcceptanceReceiptSuccessfulPaid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $acceptanceFee = AcceptanceFee::where('user_id', $user->id)
            ->where('status', 'paid')
            ->latest()
            ->first();

        if (!$acceptanceFee) {
            return redirect()->route('student.dashboard')->with('error', 'No paid acceptance fee found.');
        }

        return $next($request);
    }
}
