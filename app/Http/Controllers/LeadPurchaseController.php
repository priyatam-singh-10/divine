<?php

namespace App\Http\Controllers;

use App\Models\LeadPurchase;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;



class LeadPurchaseController extends Controller
{
    // Create Razorpay Order

    public function createOrder(Request $request)
    {
        $request->validate([
            'fullName' => 'required',
            'mobile'   => 'required|digits:10',
            'amount'   => 'required|numeric|min:1',
        ]);
    
        // Lead Insert / Update
        $leadId = session('lead_purchase.lead_id');
    
        if ($leadId) {
    
            $lead = Lead::find($leadId);
    
            if ($lead) {
                $lead->update([
                    'name'   => $request->fullName,
                    'mobile' => $request->mobile,
                ]);
            } else {
                $lead = Lead::create([
                    'name'   => $request->fullName,
                    'mobile' => $request->mobile,
                ]);
            }
    
        } else {
    
            $lead = Lead::create([
                'name'   => $request->fullName,
                'mobile' => $request->mobile,
            ]);
        }
    
        // Session Update
        session([
            'lead_purchase' => [
                'lead_id'   => $lead->id,
                'user_name' => $lead->name,
                'mobile'    => $lead->mobile,
            ]
        ]);
    
        $amount = (int) $request->amount;
    
        // Razorpay Order Create
        $api = new Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );
    
        $order = $api->order->create([
            'receipt'  => 'lead_' . $lead->id,
            'amount'   => $amount * 100, // 51 => 5100
            'currency' => 'INR'
        ]);
    
        // Purchase Entry
        LeadPurchase::create([
            'webinar_name'    => "AI Webinar",
            'user_name'       => $lead->name,
            'mobile'          => $lead->mobile,
            'price'           => $amount,
            'payment_gateway' => 'razorpay',
            'order_id'        => $order['id'],
            'payment_status'  => 'pending',
            'payment_id'      => null
        ]);
    
        return response()->json([
            'success'  => true,
            'order_id' => $order['id'],
            'amount'   => $amount * 100,
            'key'      => env('RAZORPAY_KEY')
        ]);
    }

    // Payment Success Save
    public function paymentSuccess(Request $request)
    {
        // First get record
        $leadPurchase = LeadPurchase::where(
            'order_id',
            $request->razorpay_order_id
        )->first();

        if (!$leadPurchase) {
            return response()->json([
                'status' => false,
                'message' => 'Purchase not found'
            ]);
        }

        // Update payment details
        $leadPurchase->update([
            'payment_id'     => $request->razorpay_payment_id,
            'payment_status'     => 'paid',
        ]);
        
        $liveClass = DB::table('bootcamp_live_classes as blc')
            ->join('bootcamp_modules as bm', 'bm.id', '=', 'blc.module_id')
            ->join('bootcamps as b', 'b.id', '=', 'bm.bootcamp_id')
            ->where('b.status', 1)
            ->select('blc.joining_data')
            ->first();
        $joinUrl = '';
        if ($liveClass) {
            $joiningData = json_decode($liveClass->joining_data, true);
            $joinUrl = $joiningData['join_url'] ?? '';
        }
        
        // Phone number
        $phone = $leadPurchase->mobile; // column name check karo

        // WhatsApp Message
        $message = "🎉 *Webinar Purchase Confirmation* 🎉\n\n" .
                    "Hello *{$leadPurchase->user_name}*,\n\n" .
                    "Your registration for the webinar *{$leadPurchase->webinar_name}* has been successfully confirmed ✅.\n\n" .
                    "🧾 *Price:* ₹ {$leadPurchase->price}\n\n" .
                    "🔗 *Join Webinar Link:*\n{$joinUrl}\n\n" .
                    "⏳ Please join 10 minutes before the scheduled time.\n\n" .
                    "🙏 Regards,\n" .
                    "The Sommnath Bhattacharyaa Occult Sciences";

        $message = urlencode($message);

        $url = "https://listingbook.in/divine?number=91{$phone}&message={$message}";

        try {
            Http::timeout(1)->get($url);
        } catch (\Exception $e) {
            Log::error('WhatsApp API Error: ' . $e->getMessage());
        }

        session()->forget('lead_purchase');

        return response()->json([
            'status' => true,
            'redirect_url' => route('webinar.thankyou')
        ]);
    }

}
