<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $monthly_amount = array(0);
        for ($i = 1; $i <= 12; $i++) {
            $total_amount = date('t', strtotime(date("Y-$i-1 00:00:00")));
            $amount       = Payment_history::whereDate('created_at', '>=', date("Y-$i-1 00:00:00"))->whereDate('created_at', '<=', date("Y-$i-$total_amount 23:59:59"))->get();
            if (count($amount) > 0) {
                array_push($monthly_amount, array_sum($amount->pluck('admin_revenue')->toArray()));
            } else {
                array_push($monthly_amount, 0);
            }
        }
        $page_data['monthly_amount'] = $monthly_amount;
        return view('admin.dashboard.index', $page_data);
    }
    
    public function link_enrolls(){
        
        $purchases = DB::connection('mysql2') // second database
        ->table('purchases') // replace with your table name
        ->orderBy('purchase_date', 'desc')
        ->get();
        
    //  $purchases = DB::table('divine15_whatsaap.purchases')
    // ->orderBy('purchase_date','desc')
    // ->get();
        
         return view('admin.enroll.link_enroll_purchase_histroy', compact('purchases'));
    }
    
  

        public function updatePurchaseLink(Request $request)
        {
            DB::table('settings')->updateOrInsert(
                ['type' => 'purchase_link'],
                [
                    'description' => $request->purchase_link,
                    'updated_at' => now()
                ]
            );
        
            return back()->with('success','Purchase link updated successfully.');
        }
}
