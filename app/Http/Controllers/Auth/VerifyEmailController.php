<?php

namespace App\Http\Controllers\Auth;
use App\Mail\Mailer;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {    
         $user = $request->user();
        if ( $user->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
        }

        // if ( $user->markEmailAsVerified()) {
            
        //     event(new Verified($request->user()));
            
        //     $subject = "Welcome - " . config('app.name');
        //         $message = "Hello {$user->name},\n\n".
        //                   "Thank you for Register ".
        //                   "Regards,\n" . config('app.name');

        //     Mail::raw($message, function ($mail) use ($user, $subject) {
        //             $mail->to($user->email)
        //                  ->subject($subject);
        //         });
        // }
        
        if ($user->markEmailAsVerified()) {
    
    event(new Verified($request->user()));
    
    $subject = "Welcome - " . config('app.name');
    
    $logoUrl = asset('https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png'); // Update with your logo path
    $appName = config('app.name');
    $appUrl = config('app.url');
    
    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Email Verification</title>
    </head>
    <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
        <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f4f4f4; padding: 40px 0;'>
            <tr>
                <td align='center'>
                    <table role='presentation' style='width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;'>
                        
                        <!-- Header with Logo -->
                        <tr>
                            <td style='background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 10px; text-align: center;'>
                                <img src='{$logoUrl}' alt='{$appName}' style='max-width: 150px; height: auto; margin-bottom: 6px;'>
                                <h1 style='margin: 0; color: #ffffff; font-size: 26px; font-weight: 600;'>Welcome to {$appName}</h1>
                            </td>
                        </tr>
                        
                        <!-- Content Section -->
                        <tr>
                            <td style='padding: 40px 30px;'>
                                <h2 style='margin: 0 0 20px 0; color: #333333; font-size: 22px; font-weight: 600;'>Dear {$user->name},</h2>
                                
                                <p style='margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    <strong style='color: #4F6564'>Congratulations!</strong> Your email has been successfully verified with {$appName}.
                                </p>
                                
                                <p style='margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    Your account is now fully activated and you can enjoy all our services.
                                </p>
                                
                                <!-- Success Box -->
                                <table role='presentation' style='width: 100%; border-collapse: collapse; margin: 30px 0;'>
                                    <tr>
                                        <td style='background-color: #f0f7ff; border-left: 4px solid #4F6564; padding: 20px; border-radius: 4px;'>
                                            <p style='margin: 0; color: #333333; font-size: 15px; line-height: 1.6;'>
                                                ✓ Your account is now active<br>
                                                ✓ You can access all features<br>
                                                ✓ Start exploring our services
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                                
                                <p style='margin: 0 0 10px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    Thank you for choosing {$appName}. We look forward to serving you!
                                </p>
                                
                                <p style='margin: 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    <strong style='color: #333333;'>Warm regards,</strong><br>
                                    <span style='color: #4F6564; font-weight: 600;'>The {$appName} Team</span>
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Divider -->
                        <tr>
                            <td style='padding: 0 30px;'>
                                <div style='border-top: 1px solid #e0e0e0;'></div>
                            </td>
                        </tr>
                        
                        <!-- Footer Section -->
                        <tr>
                            <td style='padding: 30px; background-color: #f8f9fa; text-align: center;'>
                                <p style='margin: 0 0 15px 0; color: #999999; font-size: 13px; line-height: 1.5;'>
                                    This email was sent to you because you registered on {$appName}.
                                </p>
                                
                                <p style='margin: 15px 0 0 0; color: #4F6564; font-size: 12px;'>
                                    © " . date('Y') . " {$appName}. All rights reserved.
                                </p>
                            </td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
    ";
    
    Mail::send([], [], function ($mail) use ($user, $subject, $message) {
        $mail->to($user->email)
             ->subject($subject)
             ->html($message);
    });
}

        return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
    }
}
