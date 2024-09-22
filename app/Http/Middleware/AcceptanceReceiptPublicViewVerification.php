<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AcceptanceFee;
use Symfony\Component\HttpFoundation\Response;

class AcceptanceReceiptPublicViewVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $transactionId = $request->route('transactionId');
        $acceptanceFee = AcceptanceFee::where('transaction_id', $transactionId)
            ->where('status', 'paid')
            ->first();

        if (!$acceptanceFee) {
            return redirect()->route('login')->with('error', 'Invalid or unpaid acceptance fee.');
        }

        return $next($request);
    }
}
