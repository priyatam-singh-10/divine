<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index()
    {
        return view('frontend.default.student.leads.index');
    }
    public function webinar_page()
    {
        return view('frontend.default.student.leads.webinar');
    }
    public function LeadsPayment()
    {
        return view('frontend.default.student.leads.payment');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullName' => 'required|string|min:3|max:50',
            'mobile' => 'required|digits:10',
        ]);

        $lead = Lead::create([
            'name' => $request->fullName,
            'mobile' => $request->mobile,
        ]);
        
        // SESSION  store
        session([
            'lead_purchase' => [
                'lead_id'   => $lead->id,
                'user_name' => $lead->name,
                'mobile' => $lead->mobile,
            ]
        ]);
    }
    
    public function saveOrUpdate(Request $request)
    {
        $request->validate([
            'fullName' => 'required',
            'mobile' => 'required|digits:10',
        ]);
    
        $leadId = session('lead_purchase.lead_id');
    
        if ($leadId) {
    
            $lead = Lead::find($leadId);
    
            if ($lead) {
                $lead->update([
                    'name' => $request->fullName,
                    'mobile' => $request->mobile,
                ]);
            }
    
        } else {
    
            $lead = Lead::create([
                'name' => $request->fullName,
                'mobile' => $request->mobile,
            ]);
        }
    
        session([
            'lead_purchase' => [
                'lead_id'   => $lead->id,
                'user_name' => $lead->name,
                'mobile'    => $lead->mobile,
            ]
        ]);
    
        // Razorpay order create
        $api = new \Razorpay\Api\Api(
            env('RAZORPAY_KEY'),
            env('RAZORPAY_SECRET')
        );
    
        $order = $api->order->create([
            'receipt' => 'lead_' . $lead->id,
            'amount' => 9900, // ₹99 = 9900 paise
            'currency' => 'INR'
        ]);
    
        return response()->json([
            'success' => true,
            'order_id' => $order['id'],
            'amount' => 9900
        ]);
    }

    public function ThankYou()
    {
        return view('frontend.default.success-page');
    }
}
