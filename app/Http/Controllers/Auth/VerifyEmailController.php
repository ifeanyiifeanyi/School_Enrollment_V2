<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();

        Log::info('Verifying email for user:', ['user' => $user]);

        if ($user->hasVerifiedEmail()) {
            Log::info('Email already verified for user:', ['user' => $user]);
            return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
        }

        if ($user->markEmailAsVerified()) {
            Log::info('Email marked as verified for user:', ['user' => $user]);
            event(new Verified($user));
        } else {
            Log::error('Failed to mark email as verified for user:', ['user' => $user]);
        }

        return redirect()->intended(RouteServiceProvider::HOME.'?verified=1');
    }
}

