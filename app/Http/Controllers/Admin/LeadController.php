<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\LeadPurchase;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::query();

        // Date Filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        $leads = $query->latest()->get();

        return view('admin.leads.index', compact('leads'));
    }

    public function LeadPurchase(Request $request)
    {
        $query = LeadPurchase::query()
            ->whereIn('payment_status', ['paid', 'failed']);;
        // Date Filter
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }
        $leads = $query->latest()->get();
        return view('admin.leads.purchase', compact('leads'));
    }
}
