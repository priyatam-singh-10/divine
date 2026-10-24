<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use DB;
use Razorpay\Api\Api;
use App\Models\CartItem;
use Illuminate\Support\Facades\Mail;
use App\Models\Book;
use App\Models\ShopCart;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Coupon;
use Illuminate\Support\Facades\Log;
use App\Models\Payment_history;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PurchaseController extends Controller
{
    public function purchase_history()
    {
        $page_data['payments'] = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.user_id', auth()->user()->id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')
            ->latest('id')->paginate(10);
        $view_path = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.index';
        return view($view_path, $page_data);
    }

    public function invoice($id)
    {
        // validate course id
        if (!is_numeric($id) && $id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check existence
        $payment = Payment_history::join('courses', 'payment_histories.course_id', 'courses.id')
            ->join('users', 'payment_histories.user_id', 'users.id')
            ->where('payment_histories.id', $id)
            ->select('payment_histories.*', 'courses.title as course_title', 'users.name as user_name')->first();
        if (!$payment) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        $page_data['invoice'] = $payment;
        $view_path            = 'frontend.' . get_frontend_settings('theme') . '.student.purchase_history.invoice';
        return view($view_path, $page_data);
    }

    public function purchase_course(Request $request,$course_id)
    {
        // dd($request,$course_id);
        $batch_id = $request->query('batch_id');
        // validate course id
        if (!is_numeric($course_id) && $course_id < 1) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // check personal course
        if (Course::where('id', $course_id)->where('user_id', auth()->user()->id)->exists()) {
            Session::flash('error', get_phrase('Ops! You own this course.'));
            return redirect()->back();
        }

        // check the course is enrolled or not
        $enroll = Enrollment::where('user_id', auth()->user()->id)->where('course_id', $course_id);
        if ($enroll->exists()) {
            Session::flash('success', get_phrase('You already enrolled in this course'));
            return redirect()->back();
        }

        // get course details by id
        $course_details = Course::where('id', $course_id)->first();

        // if course doesn't exist redirect back
        if (!$course_details) {
            Session::flash('error', get_phrase('Data not found.'));
            return redirect()->back();
        }

        // if course is free then enroll user and redirect to my courses
        if ($course_details->is_paid == 0) {
            $enrollment['user_id']         = auth()->user()->id;
            $enrollment['course_id']       = $course_id;
            $enrollment['batch_id']        = $batch_id;
            $enrollment['enrollment_type'] = 'free';
            $enrollment['entry_date']      = time();
            $enrollment['expiry_date']     = null;
            Enrollment::insert($enrollment);
            return redirect()->route('my.courses');
        } else {
            $query = CartItem::where('course_id', $course_id)->where('user_id', auth()->user()->id);
            if ($query->count() == 0) {
                CartItem::insert(['user_id' => auth()->user()->id, 'course_id' => $course_id, 'batch_id' => $batch_id,'created_at' => date('Y-m-d H:i:s')]);
                return redirect(route('course_cart'));
            } elseif ($query->count() == 1) {
                return redirect(route('course_cart'));
            }
        }

        // redirect to cart store
        return redirect()->back();
    }

    public function payout(Request $request)
    {
        // get all item details by its id
        $items_id = json_decode($request->items);
        $batch_ids = json_decode($request->batch_ids, true);
        $courses  = $items_id;

        // if order is gift then select gifted user id
        if ($request->gifted_user_email) {
            $gifted_user_id = User::where('role', '!=', 'admin')->where('email', $request->gifted_user_email)->value('id');
            if (!$gifted_user_id) {
                Session::flash('error', get_phrase("User email doesn't exists."));
                return redirect()->back();
            }

            $courses = [];
            foreach ($items_id as $item) {
                if (Enrollment::where('course_id', $item)->where('user_id', $gifted_user_id)->doesntExist()) {
                    $courses[] = $item;
                }
            }

            if (count($courses) == 0) {
                Session::flash('error', get_phrase('User already enrolled.'));
                return redirect()->back();
            }
        }

        $selected_courses = Course::whereIn('id', $courses)->get();
        
          $cartDataForNotes = [];
        // prepare each item by its id
        foreach ($selected_courses as $key => $course) {
            
             $finalPrice = $course->discount_flag ? $course->discounted_price : $course->price;
                            // For Razorpay notes
                    $cartDataForNotes[] = [
                        'item_id'  => $course->id,
                        'quantity' => 1,          // default quantity for courses
                        'price'    => $finalPrice,
                    ];
                            
            $items[] = [
                'id'             => $course->id,
                'title'          => $course->title,
                'batch_id'       => $batch_ids[$key] ?? null,
                'subtitle'       => '',
                'price'          => $course->price,
                'discount_price' => $course->discount_flag ? $course->discounted_price : 0,
            ];
        }

        $payment_details = [
            'items'          => $items,

            'custom_field'   => [
                'item_type'       => 'course',
                'pay_for'         => 'course payment',
                'batch_ids' => $batch_ids,
                'user_id'         => auth()->user()->id,
                'user_photo'      => auth()->user()->photo,
                'cart_id'         => $items_id,
                'cart_items'      => $cartDataForNotes,
                'coupon_discount' => $request->coupon_discount,
                'gifted_user_id'  => $gifted_user_id ?? '',
            ],

            'success_method' => [
                'model_name'    => 'PurchaseCourse',
                'function_name' => 'purchase_course',
            ],

            'tax'            => round($request->tax, 2),
            'coupon'         => $request->coupon_code,
            'payable_amount' => round($request->payable, 2),
            'cancel_url'     => route('course_cart'),
            'success_url'    => route('payment.success', ''),
        ];

        Session::put(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }
    
    public function bookpayout(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
    
        // Handle guest users
        if (!Auth::check()) {
            session([
                'guest_cart_selected_items' => $selectedItems,
                'guest_cart_quantities' => $request->input('quantities', [])
            ]);
            return redirect()->route('login')->with('message', 'Please login to proceed to checkout.');
        }
    
        $userId = Auth::id();
    
        // Merge guest session items if they exist
        $guestSelectedItems = session()->pull('guest_cart_selected_items', []);
        $guestQuantities = session()->pull('guest_cart_quantities', []);
    
        // Handle cart selection
        if (empty($selectedItems) && empty($guestSelectedItems)) {
            $cartItems = ShopCart::where('user_id', $userId)
                ->with('book')
                ->get()
                ->filter(fn($item) => $item->book && $item->book->stock > 0);
        } else {
            $allSelectedItems = array_unique(array_merge($selectedItems, $guestSelectedItems));
            $cartItems = ShopCart::whereIn('id', $allSelectedItems)
                ->where('user_id', $userId)
                ->with('book')
                ->get()
                ->filter(fn($item) => $item->book && $item->book->stock > 0);
        }
    
        if ($cartItems->isEmpty()) {
            return back()->with('message', 'No valid items found in your cart.');
        }
    
        // Calculate totals
        $totalPrice = 0;
        $cartDataForNotes = [];
    
        foreach ($cartItems as $item) {
            $book = $item->book;
            if (!$book || $book->stock <= 0) continue;
    
            $quantity = $guestQuantities[$item->id] ?? $item->quantity ?? 1;
            $discount = $book->discount_percentage ?? 0;
            $price = $book->price ?? 0;
    
            $finalPrice = $price - ($price * ($discount / 100));
            $totalPrice += ($finalPrice * $quantity);
    
            $cartDataForNotes[] = [
                'item_id'  => $book->id,
                'quantity' => $quantity,
                'price'    => $finalPrice,
            ];
    
            if (($guestQuantities[$item->id] ?? null) && $item->quantity != $quantity) {
                $item->quantity = $quantity;
                $item->save();
            }
        }
    
        if ($totalPrice < 1) {
            return back()->with('message', 'Minimum order amount should be â‚¹1.');
        }
    
        
        $couponDiscount = 0;
        $coupon = null;
        $code = trim($request->input('coupon', ''));
        if (!empty($code)) {
            $coupon = Coupon::where('code', $code)->first();
    
            if (!$coupon) {
                Session::flash('error', 'This coupon is not valid.');
                return redirect()->back();
            }
    
            if ($coupon->status && (time() >= $coupon->expiry)) {
                Session::flash('error', 'Oops! Coupon is expired.');
                return redirect()->back();
            }
    
            $couponDiscount = $totalPrice * ($coupon->discount / 100);
            $totalPrice = max(0, $totalPrice - $couponDiscount);
        }
    
        // Create Razorpay order
        $amount = intval(round($totalPrice, 2) * 100);
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        $orderId = strtoupper('BOOK-' . \Illuminate\Support\Str::random(6));
    
        $order = $api->order->create([
            'receipt'         => 'order_rcptid_' . uniqid(),
            'amount'          => $amount,
            'currency'        => 'INR',
            'payment_capture' => 1,
            'notes' => [
                'user_id' => $userId,
                'cart_items' => json_encode($cartDataForNotes),
                'reference' => 'book',
                'order_id' => $orderId
            ]
        ]);
    
        $user = Auth::user();
        if (is_string($user->full_address)) {
            $user->full_address = json_decode($user->full_address, true);
        }
    
        return view('checkout', [
            'order_id'        => $order['id'],
            'amount'          => $amount,
            'cartItems'       => $cartItems,
            'key'             => env('RAZORPAY_KEY'),
            'totalPrice'      => $totalPrice,
            'couponDiscount'  => $couponDiscount,
            'coupon'          => $coupon,
            'user'            => $user,
        ]);
    }


    public function verifyPayment(Request $request)
{
    try {
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

        $razorpayPaymentId = $request->razorpay_payment_id;
        $razorpayOrderId   = $request->razorpay_order_id;
        $razorpaySignature = $request->razorpay_signature;
        $cartItemIds       = $request->cart_items ?? [];
        $totalAmount       = $request->total_amount ?? 0;

        $user = Auth::user();

        $shippingAddress = $request->shipping_address ?? $user->address ?? 'N/A';
        $shippingContact = $request->shipping_contact ?? $user->phone ?? 'N/A';
        $shippingName    = $request->shipping_name ?? $user->name ?? 'N/A';
        $shippingEmail   = $request->shipping_email ?? $user->email ?? 'N/A';

        $fullShippingAddress = $request->input('full_shippingaddress', []);

        foreach (['address', 'city', 'state', 'zipcode', 'country'] as $field) {
            if (empty($fullShippingAddress[$field])) {
                return response()->json([
                    'success' => false,
                    'message' => "Missing $field in shipping address."
                ], 400);
            }
        }

        $generatedSignature = hash_hmac(
            'sha256',
            $razorpayOrderId . "|" . $razorpayPaymentId,
            env('RAZORPAY_SECRET')
        );

        if ($generatedSignature !== $razorpaySignature) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed!'
            ], 400);
        }

        // Fetch cart items with books
        $cartItems = ShopCart::whereIn('id', $cartItemIds)
            ->where('user_id', Auth::id())
            ->with('book')
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No valid items found in your cart.'
            ], 400);
        }

        $orderedBooks = [];
        foreach ($cartItems as $item) {
            if (!$item->book) continue;

            $book = $item->book;
            $quantity = $item->quantity ?? 1;
            $discount = $book->discount_percentage ?? 0;
            $discountedPrice = round($book->price - ($book->price * ($discount / 100)), 2);

            DB::table('orders')->insert([
                'user_id' => Auth::id(),
                'book_id' => $book->id,
                'quantity' => $quantity,
                'total_price' => $discountedPrice * $quantity,
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_type' => 'online(razorpay)',
                'gateway_order_id' => $razorpayOrderId,
                'gateway_payment_id' => $razorpayPaymentId,
                'shipping_address' => $shippingAddress,
                'shipping_name' => $shippingName,
                'shipping_email' => $shippingEmail,
                'full_shippingaddress' => json_encode($fullShippingAddress),
                'shipping_contact' => $shippingContact,
                'shipping_status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $book->stock = max(0, $book->stock - $quantity);
            $book->save();
            $orderedBooks[] = "{$book->title} (x{$quantity})";
        }

        ShopCart::whereIn('id', $cartItemIds)->delete();
        
        $usertotalAmount = isset($request->total_amount) ? ($request->total_amount / 100) : 0;
        // try {
        //     $subject = "Order Confirmation - Thank you for your purchase!";
        //     $bookList = implode(", ", $orderedBooks);
        //     $message = "Hello {$user->name},\n\n".
        //               "Thank you for your order! Your payment has been successfully verified.\n\n".
        //               "Here are your order details:\n".
        //               "Books: {$bookList}\n".
        //               "Total Amount: â‚¹{$usertotalAmount}\n".
        //               "Shipping Name: {$shippingName}\n".
        //               "Shipping Email: {$shippingEmail}\n".
        //               "Shipping Address: {$shippingAddress}\n".
        //               "Contact: {$shippingContact}\n\n".
        //               "Weâ€™ll notify you once your order is shipped.\n\n".
        //               "Regards,\n" . config('app.name');

        //     Mail::raw($message, function ($mail) use ($user, $subject) {
        //         $mail->to($user->email)->subject($subject);
        //     });
        // } catch (\Exception $mailEx) {
        //     Log::error('Order confirmation email failed: ' . $mailEx->getMessage());
        // }
        
        // Send WhatsApp message
        try {
            self::sendBookOrderWhatsAppMessage(
                $user->name,
                $orderedBooks,
                $usertotalAmount,
                $shippingName,
                $shippingContact,
                $shippingAddress
            );
        } catch (\Exception $waEx) {
            Log::error('WhatsApp message failed: ' . $waEx->getMessage());
        }
        try {
    $subject = "Order Confirmation - Thank you for your purchase!";
    $bookList = implode(", ", $orderedBooks);
    
    $logoUrl = asset('path/to/your/logo.png'); // Update with your logo path
    $appName = config('app.name');
    $appUrl = config('app.url');
    
    $message = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Order Confirmation</title>
    </head>
    <body style='margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;'>
        <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f4f4f4; padding: 40px 0;'>
            <tr>
                <td align='center'>
                    <table role='presentation' style='width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden;'>
                        
                        <!-- Header with Logo -->
                        <tr>
                            <td style='background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 10px; text-align: center'>
                                <img src='https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png' alt='DivineTouch' style='max-width: 150px; height: auto; margin-bottom: 6px;'>
                                <h1 style='margin: 0; color: #ffffff; font-size: 26px; font-weight: 600;'>Order Confirmed!</h1>
                                <p style='margin: 10px 0 0 0; color: #ffffff; font-size: 14px;'>Thank you for your purchase</p>
                            </td>
                        </tr>
                        
                        <!-- Success Badge -->
                        <tr>
                            <td style='padding: 30px 30px 0 30px; text-align: center;'>
                                <div style='display: inline-block; background-color: #d1fae5; color: #065f46; padding: 10px 25px; border-radius: 50px; font-size: 14px; font-weight: 600;'>
                                    âœ“ Payment Verified Successfully
                                </div>
                            </td>
                        </tr>
                        
                        <!-- Content Section -->
                        <tr>
                            <td style='padding: 30px 30px 20px 30px;'>
                                <h2 style='margin: 0 0 15px 0; color: #333333; font-size: 22px; font-weight: 600;'>Hello {$user->name},</h2>
                                
                                <p style='margin: 0 0 25px 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    Thank you for your order! Your payment has been successfully verified and your order is being processed.
                                </p>
                            </td>
                        </tr>
                        
                        <!-- Order Details Box -->
                        <tr>
                            <td style='padding: 0 30px 30px 30px;'>
                                <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f9fafb; border-radius: 8px; overflow: hidden;'>
                                    <tr>
                                        <td style='padding: 20px; border-bottom: 2px solid #10b981;'>
                                            <h3 style='margin: 0; color: #10b981; font-size: 18px; font-weight: 600;'>ðŸ“¦ Order Details</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 20px;'>
                                            <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                                <tr>
                                                    <td style='padding: 10px 0; color: #6b7280; font-size: 14px; font-weight: 600;'>Books Ordered:</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 0 0 15px 0; color: #333333; font-size: 15px; line-height: 1.6;'>{$bookList}</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 15px 0; border-top: 1px solid #e5e7eb;'>
                                                        <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                                            <tr>
                                                                <td style='color: #6b7280; font-size: 14px; padding: 5px 0;'>Total Amount:</td>
                                                                <td style='color: #10b981; font-size: 18px; font-weight: 700; text-align: right; padding: 5px 0;'>â‚¹{$usertotalAmount}</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Shipping Details Box -->
                        <tr>
                            <td style='padding: 0 30px 30px 30px;'>
                                <table role='presentation' style='width: 100%; border-collapse: collapse; background-color: #f9fafb; border-radius: 8px; overflow: hidden;'>
                                    <tr>
                                        <td style='padding: 20px; border-bottom: 2px solid #10b981;'>
                                            <h3 style='margin: 0; color: #10b981; font-size: 18px; font-weight: 600;'>ðŸšš Shipping Information</h3>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 20px;'>
                                            <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                                <tr>
                                                    <td style='padding: 8px 0; color: #6b7280; font-size: 14px; width: 120px;'>Name:</td>
                                                    <td style='padding: 8px 0; color: #333333; font-size: 15px; font-weight: 500;'>{$shippingName}</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 8px 0; color: #6b7280; font-size: 14px;'>Email:</td>
                                                    <td style='padding: 8px 0; color: #333333; font-size: 15px;'>{$shippingEmail}</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 8px 0; color: #6b7280; font-size: 14px;'>Contact:</td>
                                                    <td style='padding: 8px 0; color: #333333; font-size: 15px;'>{$shippingContact}</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 8px 0; color: #6b7280; font-size: 14px; vertical-align: top;'>Address:</td>
                                                    <td style='padding: 8px 0; color: #333333; font-size: 15px; line-height: 1.6;'>{$shippingAddress}</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        
                        <!-- Info Box -->
                        <tr>
                            <td style='padding: 0 30px 30px 30px;'>
                                <table role='presentation' style='width: 100%; border-collapse: collapse;'>
                                    <tr>
                                        <td style='background-color: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 4px;'>
                                            <p style='margin: 0; color: #92400e; font-size: 14px; line-height: 1.6;'>
                                                <strong>ðŸ“¬ What's Next?</strong><br>
                                                We'll notify you via email once your order is packed and shipped. You can track your order status anytime.
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
                                    Thank you for shopping with us!
                                </p>
                                <p style='margin: 0; color: #666666; font-size: 16px; line-height: 1.6;'>
                                    <strong style='color: #333333;'>Warm regards,</strong><br>
                                    <span style='color: #10b981; font-weight: 600;'>The {$appName} Team</span>
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
                                    Need help? Contact our support team or visit our help center.
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
    
   if(!empty($shippingEmail)){
    Mail::send([], [], function ($mail) use ($user, $subject, $message) {
        $mail->to($shippingEmail)
             ->subject($subject)
             ->html($message);
    });
}
} catch (\Exception $mailEx) {
    Log::error('Order confirmation email failed: ' . $mailEx->getMessage());
}

        return response()->json([
            'success' => true,
            'message' => 'Payment verified, order created, and confirmation email sent successfully!'
        ]);

    } catch (\Exception $e) {
        Log::error('Payment Verification Error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Something went wrong!'
        ], 500);
    }
}

private static function sendBookOrderWhatsAppMessage($name, $books, $amount, $shippingName, $shippingContact, $shippingAddress)
{
    $phone = auth()->user()->phone;

    $bookList = implode(", ", $books);

    $message = "📚 *Book Order Confirmation* 📚\n\n" .
        "Hello *{$name}*,\n\n" .
        "Your book order has been placed successfully ✅.\n\n" .
        "📖 *Books Ordered:* {$bookList}\n\n" .
        "💰 *Total Amount:* ₹{$amount}\n\n" .
        "🚚 *Shipping Details:*\n" .
        "Name: {$shippingName}\n" .
        "Contact: {$shippingContact}\n" .
        "Address: {$shippingAddress}\n\n" .
        "📦 *Order Status:* Processing\n\n" .
        "We will notify you once your order is shipped.\n\n" .
        "🙏 Thank you for shopping with Divine Touch";

    $message = urlencode($message);

    $url = "https://listingbook.in/divine?number={$phone}&message={$message}";

   try {
        $response = @file_get_contents($url);
    } catch (\Exception $e) {
        Log::error('WhatsApp API Error: '.$e->getMessage());
    }
}

public function orders()
{
     $orders = \App\Models\Order::with(['book' => function($query) {
            $query->withTrashed(); // include soft deleted books
        }, 'user'])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();
    return view('frontend.default.student.orders.index', compact('orders'));
}

}
