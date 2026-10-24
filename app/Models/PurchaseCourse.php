<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PurchaseCourse extends Model
{
    use HasFactory;

    public static function purchase_course($identifier)
    {
        // get payment details
        $payment_details = session('payment_details');
              //dd($payment_details);
        if (Session::has('keys')) {
            $transaction_keys          = session('keys');
            $transaction_keys          = json_encode($transaction_keys);
            $payment['transaction_id'] = $transaction_keys;
            $remove_session_item[]     = 'keys';
        }
        if (Session::has('session_id')) {
            $transaction_keys      = session('session_id');
            $payment['session_id'] = $transaction_keys;
            $remove_session_item[] = 'session_id';
        }

        // generate invoice for payment
        $payment['invoice'] = Str::random(20);
        for ($i = 0; $i < count($payment_details['items']); $i++) {
            $price           = $payment_details['items'][$i]['price'];
            $course_discount = $payment_details['items'][$i]['discount_price'];
            $batch_id = $payment_details['custom_field']['batch_ids'][$i] ?? null;
            if (get_course_creator_id($payment_details['items'][$i]['id'])->role == 'admin') {
                $payment['admin_revenue'] = $payment_details['payable_amount'];
            } else {
                $payment['instructor_revenue'] = $payment_details['payable_amount'] * (get_settings('instructor_revenue') / 100);
                $payment['admin_revenue']      = $payment_details['payable_amount'] - $payment['instructor_revenue'];
            }

            $payment['course_id']    = $payment_details['items'][$i]['id'];
            $payment['tax']          = $payment_details['tax'];
            $enroll['batch_id']        = $batch_id;
            $payment['amount']       = $course_discount ? $course_discount : $price;
            $payment['user_id']      = auth()->user()->id;
            $payment['payment_type'] = $identifier;
            $payment['coupon']       = $payment_details['coupon'];

            // insert payment history
            $payment_history = DB::table('payment_histories')->insert($payment);

            // if payment has done then enroll user
            if ($payment_history) {
                $enroll['course_id']       = $payment_details['items'][$i]['id'];
                $enroll['user_id']         = $payment_details['custom_field']['gifted_user_id'] ? $payment_details['custom_field']['gifted_user_id'] : auth()->user()->id;
                $enroll['enrollment_type'] = "paid";
                $enroll['entry_date']      = time();
                $enroll['batch_id']        = $batch_id;
            
                // insert a new enrollment
                DB::table('enrollments')->insert($enroll);
                $course_details = get_course_info($payment_details['items'][$i]['id']);
                $batch = DB::table('batches')->where('id', $batch_id)->first();
                //whatsapp message
              //  dd($course_details);
                self::sendCourseWhatsAppMessage(auth()->user()->name, $course_details,$batch);
                try {
                        $user  = auth()->user();
                        $course = DB::table('courses')->where('id', $enroll['course_id'])->first();
                    
                        $subject = "Course Enrollment Confirmation - " . ($course->title ?? 'Course');
                        
                        $logoUrl = asset('path/to/your/logo.png'); // Update with your logo path
                        $appName = config('app.name');
                        $appUrl = config('app.url');
                        $dashboardUrl = url('/dashboard'); // Update with your dashboard URL
                        
                        $message = "
                        <!DOCTYPE html>
                        <html lang='en'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>Course Enrollment Confirmation</title>
                        </head>
                        <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
                            <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f4f4f4; padding: 40px 0;'>
                                <tr>
                                    <td align='center'>
                                        <table role='presentation' style='width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;'>
                                            
                                            <!-- Header with Logo -->
                                            <tr>
                                                <td style='background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 30px; text-align: center;'>
                                                    <img src='https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png' alt='{$appName}' style='max-width: 150px; height: auto; margin-bottom: 15px;'>
                                                    <h1 style='margin: 0; color: #ffffff; font-size: 26px; font-weight: 600;'>Course Enrollment Confirmation!</h1>
                                                    <p style='margin: 10px 0 0 0; color: #ffffff; font-size: 14px;'>Welcome to your learning journey</p>
                                                </td>
                                            </tr>
                                            
                                            <!-- Success Badge -->
                                            <tr>
                                                <td style='padding: 30px 30px 0 30px; text-align: center;'>
                                                    <div style='display: inline-block; background-color: #dbeafe; color: #1e40af; padding: 10px 25px; border-radius: 50px; font-size: 14px; font-weight: 600;'>
                                                        âœ“ Payment Received Successfully
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!-- Content Section -->
                                            <tr>
                                                <td style='padding: 30px 30px 20px 30px;'>
                                                    <h2 style='margin: 0 0 15px 0; color: #333333; font-size: 22px; font-weight: 600;'>Hello {$user->name},</h2>
                                                    
                                                    <p style='margin: 0 0 20px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                                        Congratulations! You have successfully enrolled in <strong style='color: #3b82f6;'>\"{$course->title}\"</strong>.
                                                    </p>
                                                    
                                                    <p style='margin: 0 0 25px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                                        Your payment has been processed and you now have full access to all course materials, videos, and resources.
                                                    </p>
                                                </td>
                                            </tr>
                                            
                                            <!-- Course Details Box -->
                                            <tr>
                                                <td style='padding: 0 30px 30px 30px;'>
                                                    <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f9fafb; border-radius: 8px; overflow: hidden;'>
                                                        <tr>
                                                            <td style='padding: 20px; border-bottom: 2px solid #3b82f6;'>
                                                                <h3 style='margin: 0; color: #3b82f6; font-size: 18px; font-weight: 600;'>ðŸ“š Course Details</h3>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style='padding: 20px;'>
                                                                <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                                                    <tr>
                                                                        <td style='padding: 10px 0; color: #6b7280; font-size: 14px; width: 150px; vertical-align: top;'>Course Name:</td>
                                                                        <td style='padding: 10px 0; color: #333333; font-size: 16px; font-weight: 600; line-height: 1.5;'>{$course->title}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='padding: 10px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;'>Batch Name:</td>
                                                                        <td style='padding: 10px 0; color: #333333; font-size: 15px; border-top: 1px solid #e5e7eb;'>{$batch->name}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='padding: 10px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;'>Amount Paid:</td>
                                                                        <td style='padding: 10px 0; color: #10b981; font-size: 18px; font-weight: 700; border-top: 1px solid #e5e7eb;'>â‚¹" . number_format($payment['amount'], 2) . "</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='padding: 10px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;'>Payment Method:</td>
                                                                        <td style='padding: 10px 0; color: #333333; font-size: 15px; border-top: 1px solid #e5e7eb;'>" . ucfirst($identifier) . "</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style='padding: 10px 0; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb;'>Invoice ID:</td>
                                                                        <td style='padding: 10px 0; color: #333333; font-size: 15px; border-top: 1px solid #e5e7eb; font-family: monospace;'>{$payment['invoice']}</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            
                                            <!-- CTA Button -->
                                            <tr>
                                                <td style='padding: 0 30px 30px 30px; text-align: center;'>
                                                    <a href='{$dashboardUrl}' style='display: inline-block; padding: 15px 40px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: #ffffff; text-decoration: none; border-radius: 50px; font-size: 16px; font-weight: 600; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);'>
                                                        Access Your Course Now â†’
                                                    </a>
                                                </td>
                                            </tr>
                                            
                                            <!-- Info Box -->
                                            <tr>
                                                <td style='padding: 0 30px 30px 30px;'>
                                                    <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                                        <tr>
                                                            <td style='background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px;'>
                                                                <p style='margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;'>
                                                                    <strong>ðŸ’¡ Quick Start Tips:</strong><br>
                                                                    â€¢ Login to your dashboard to access the course<br>
                                                                </p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            
                                            <!-- Closing -->
                                            <tr>
                                                <td style='padding: 0 30px 30px 30px;'>
                                                    <p style='margin: 0 0 10px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                                        Happy Learning! We're excited to be part of your educational journey.
                                                    </p>
                                                    <p style='margin: 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                                        <strong style='color: #333333;'>Warm regards,</strong><br>
                                                        <span style='color: #3b82f6; font-weight: 600;'>The {$appName} Team</span>
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
                                                        Need help with your course? Our support team is here to assist you.
                                                    </p>
                                                    
                                                    <p style='margin: 15px 0 0 0; color: #4F6564; font-size: 12px;'>
                                                        Â© " . date('Y') . " {$appName}. All rights reserved.
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
                    } catch (\Exception $e) {
                        \Log::error('Failed to send enrollment email: ' . $e->getMessage());
                    }
            }
        }

        // if payment and enroll has been done then remove items from cart
        if ($payment_history && $enroll) {
            $cart_items = $payment_details['custom_field']['cart_id'];
            foreach ($cart_items as $item) {
                DB::table('cart_items')->where('user_id', auth()->user()->id)->where('course_id', $item)->delete();
            }
        }

        $remove_session_item[] = 'payment_details';
        Session::forget($remove_session_item);
        Session::flash('success', 'Course enrolled successfully.');
        return redirect()->route('my.courses');
    }
     // New function to send WhatsApp message
    private static function sendCourseWhatsAppMessage($name, $course,$batch)
    {
         $batch_start_date = date('d M Y', strtotime($batch->start_date));
         $batch_end_date = date('d M Y', strtotime($batch->end_date));
        // $start_time = date('d M Y, h:i A', strtotime($course->start_date));
        $class_timing = $course->class_timing ?? 'Check your schedule';
        $join_link = $course->join_link ?? 'Link not available';
        $phone = auth()->user()->phone;
       
        $message = "🎉 *Course Enrollment Confirmation* 🎉\n\n" .
            "Hello *{$name}*,\n\n" .
            "You have successfully enrolled in the live course *{$course->title}* ✅.\n\n" .
            "📚 *Batch:* {$batch->name}\n\n" .
            "⏰ *Class Timing:* {$class_timing}\n\n" .
             "📅 *Batch Start Date:* {$batch_start_date}\n" .
             "📅 *Batch End Date:* {$batch_end_date}\n" .
            "🔗 *Access your classes here:*\n{$join_link}\n\n" .
            "🙏 Welcome to Divine Touch";

        $message = urlencode($message);

        $url = "https://listingbook.in/divine?number={$phone}&message={$message}";

        try {
            file_get_contents($url);
        } catch (\Exception $e) {
            \Log::error('WhatsApp API Error: ' . $e->getMessage());
        }
    }
}
