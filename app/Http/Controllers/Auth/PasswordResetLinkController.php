<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    // public function store(Request $request): RedirectResponse
    // {
    //     $request->validate([
    //         'email' => ['required', 'email'],
    //     ]);

    //     // We will send the password reset link to this user. Once we have attempted
    //     // to send the link, we will examine the response then see the message we
    //     // need to show to the user. Finally, we'll send out a proper response.
    //     $status = Password::sendResetLink(
    //         $request->only('email')
    //     );

    //     return $status == Password::RESET_LINK_SENT
    //         ? back()->with('status', __($status))
    //         : back()->withInput($request->only('email'))
    //         ->withErrors(['email' => __($status)]);
    // }
    
   public function store(Request $request): RedirectResponse
{
    // Validate input
    $request->validate([
        'email' => ['required', 'email'],
    ]);

    try {
        // Attempt to send the password reset link
        $status = Password::sendResetLink($request->only('email'));

        // Log raw status
        \Log::info('Password reset link send attempt', [
            'email'  => $request->email,
            'status' => $status,
        ]);

        if ($status == Password::RESET_LINK_SENT) {
            \Log::info('Password reset email successfully handed to mailer', [
                'email' => $request->email
            ]);
            return back()->with('status', __('A password reset link has been sent to your email.'));
        }

        // If user email not found or other status
        \Log::warning('Password reset email failed with status', [
            'email'  => $request->email,
            'status' => $status,
        ]);

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => __('We could not send the password reset link. Please check your email and try again.')]);

    } catch (\Exception $e) {
        // Handle any mailer/transport exceptions
        \Log::error('Password reset exception', [
            'email'   => $request->email,
            'message' => $e->getMessage(),
            'trace'   => $e->getTraceAsString(),
        ]);

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => 'We could not send the password reset email at this time. Please try again later.']);
    }
}
}
