<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CourseReservation;
use Illuminate\Support\Str;
use Razorpay\Api\Api;

class CourseReservationController extends Controller
{
    /**
     * Store reservation & redirect to payment
     */
       public function store(Request $request)
    {
       
       
        $request->validate([
            'student_name' => 'required',
            'father_name'  => 'nullable',
            'mobile_no'    => 'required',
            'city'         => 'required',
            'target_exam'  => 'required',
        ]);
    
        $reservation = CourseReservation::create([
            'student_name' => $request->student_name,
            'father_name'  => $request->father_name,
            'mobile_no'    => $request->mobile_no,
            'city'         => $request->city,
            'type'         => $request->type,
            'target_exam'  => $request->target_exam,
            'student_email'       => $request->student_mail,
            'reservation_token' => Str::uuid(),
            'payment_status' => 'PENDING',
            'payment_amount' => 491
        ]);
        // dd($reservation);
        // Razorpay Order
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
        $order = $api->order->create([
            'receipt'  => $reservation->reservation_token,
            'amount'   => 491 * 100,
            'currency' => 'INR'
        ]);
    
        $reservation->update([
            'payment_order_id' => $order['id']
        ]);
    
        return response()->json([
            'order_id' => $order['id'],
            'amount'   => 491,
            'name'     => $reservation->student_name,
            'email'    => $reservation->student_mail,
            'type'    => $reservation->type,
            'mobile'  => $reservation->mobile_no,
            'token'    => $reservation->reservation_token
        ]);
    }
      public function storecourse(Request $request)
    {
       
       
        $request->validate([
            'student_name' => 'required',
            'father_name'  => 'nullable',
            'mobile_no'    => 'required',
            'city'         => 'required',
            'target_exam'  => 'required',
        ]);
    
        $reservation = CourseReservation::create([
            'student_name' => $request->student_name,
            'father_name'  => $request->father_name,
            'mobile_no'    => $request->mobile_no,
            'city'         => $request->city,
            'type'         => $request->type,
            'target_exam'  => $request->target_exam,
            'student_email'       => $request->student_mail,
            'reservation_token' => Str::uuid(),
            'payment_status' => 'PENDING',
            'payment_amount' => 99
        ]);
        // dd($reservation);
        // Razorpay Order
        
        $testkey="rzp_test_J60bqBOi1z1aF5";
        $testscrete="uk935K7p4j96UCJgHK8kAU4q";
        $api = new Api( $testkey, $testscrete);
    
        $order = $api->order->create([
            'receipt'  => $reservation->reservation_token,
            'amount'   => 99 * 100,
            'currency' => 'INR'
        ]);
    
        $reservation->update([
            'payment_order_id' => $order['id']
        ]);
    
        return response()->json([
            'order_id' => $order['id'],
            'amount'   => 99,
            'name'     => $reservation->student_name,
            'email'    => $reservation->student_mail,
            'type'    => $reservation->type,
            'mobile'  => $reservation->mobile_no,
            'token'    => $reservation->reservation_token
        ]);
    }
    /**
     * Payment page
     */
    public function paymentPage($token)
    {
        $reservation = CourseReservation::where('reservation_token', $token)->firstOrFail();

        return view('payment.index', compact('reservation'));
    }
    
    public function thankyou_course($token){
        
        $reservation = CourseReservation::where('reservation_token', $token)->firstOrFail();

        return view('quantum-wealth-thank-you', compact('reservation'));
    }
}

