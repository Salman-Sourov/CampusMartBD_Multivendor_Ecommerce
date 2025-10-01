<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use App\Models\Product_category;

class VerifyEmailController extends Controller
{
    public function __invoke(EmailVerificationRequest $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('index')->with('message', 'Your email is already verified!');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('index')->with('message', 'Email verified successfully!');
    }
}
