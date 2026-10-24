<?php

namespace App\Http\Controllers;

use App\Models\Payment_history;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ReportController extends Controller
{
    public function admin_revenue(Request $request)
    {
        if ($request->eDateRange) {
            $date                    = explode('-', $request->eDateRange);
            $start_date              = strtotime($date[0] . ' 00:00:00');
            $end_date                = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;

            $page_data['reports'] = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->latest('id')->paginate(10);
        }

        return view('admin.report.admin_revenue', $page_data);
    }

    public function admin_revenue_filter(Request $request)
    {
        if ($request->eDateRange) {
            $date                            = explode('-', $request->eDateRange);
            $start_date                      = strtotime($date[0] . ' 00:00:00');
            $end_date                        = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']         = $start_date;
            $page_data['end_date']           = $end_date;
            $page_data['reports'] = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('admin_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.admin_revenue');
    }

    public function admin_revenue_delete($id)
    {

        Payment_history::where('id', $id)->delete();
        Session::flash('success', get_phrase('Admin revenue delete successfully'));
        return redirect()->back();
    }

    public function instructor_revenue(Request $request)
    {
        if ($request->eDateRange) {
            $date                            = explode('-', $request->eDateRange);
            $start_date                      = strtotime($date[0] . ' 00:00:00');
            $end_date                        = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']         = $start_date;
            $page_data['end_date']           = $end_date;
            $page_data['reports'] = Payment_history::where('instructor_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10)->appends($request->query());
        } else {
            $start_date              = strtotime('first day of this month');
            $end_date                = strtotime('last day of this month');
            $page_data['start_date'] = $start_date;
            $page_data['end_date']   = $end_date;
            $page_data['reports']    = Payment_history::where('instructor_revenue', '!=', '')->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
                ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
                ->latest('id')->paginate(10);
        }
        return view('admin.report.instructor_revenue', $page_data);
    }

    public function instructor_revenue_delete($id)
    {

        Payment_history::where('id', $id)->delete();
        Session::flash('success', get_phrase('Instructor revenue delete successfully'));
        return redirect()->back();
    }

    // public function purchase_history(Request $request)
    // {
    //     if ($request->eDateRange) {
    //         $date                          = explode('-', $request->eDateRange);
    //         $start_date                    = strtotime($date[0] . ' 00:00:00');
    //         $end_date                      = strtotime($date[1] . ' 23:59:59');
    //         $page_data['start_date']       = $start_date;
    //         $page_data['end_date']         = $end_date;
    //         $page_data['reports'] = Payment_history::where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('id')->paginate(10)->appends($request->all());
    //     } else {
    //         $start_date              = strtotime('first day of this month');
    //         $end_date                = strtotime('last day of this month');
    //         $page_data['start_date'] = $start_date;
    //         $page_data['end_date']   = $end_date;
    //         $page_data['reports']    = Payment_history::where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
    //             ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))
    //             ->latest('id')->paginate(10);
    //     }
    //     return view('admin.report.purchase_history', $page_data);
    // }
    
    
          public function purchase_history(Request $request)
        {
            $page_data = [];
        
            // Base query with relations
            $query = Payment_history::query()->with(['users','course']);
        
            // 🔍 Search
            if ($request->filled('search')) {
                $search = $request->search;
        
                $query->where(function ($q) use ($search) {
                    $q->whereHas('users', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'LIKE', "%{$search}%")
                                  ->orWhere('email', 'LIKE', "%{$search}%");
                    })
                    ->orWhereHas('course', function ($courseQuery) use ($search) {
                        $courseQuery->where('title', 'LIKE', "%{$search}%");
                    });
                });
            }
        
            // 📅 Date filter
            if ($request->eDateRange) {
        
                $date = explode('-', $request->eDateRange);
        
                $start_date = date('Y-m-d 00:00:00', strtotime(trim($date[0])));
                $end_date   = date('Y-m-d 23:59:59', strtotime(trim($date[1])));
        
                $query->whereBetween('created_at', [$start_date,$end_date]);
        
                $page_data['start_date'] = $start_date;
                $page_data['end_date']   = $end_date;
        
            } else {
                $page_data['start_date'] = null;
                $page_data['end_date']   = null;
            }
        
            // DataTables requires full dataset
            $reports = $query->latest('id')->get();
        
            $page_data['reports'] = $reports;
        
            return view('admin.report.purchase_history', $page_data);
        }

    public function purchase_history_invoice($id = '')
    {
        $page_data['report'] = Payment_history::where('id', $id)->first();
        return view('admin.report.report_invoice', $page_data);
    }
    
  public function payment_history(Request $request)
{
    $query = DB::table('payment_logs as p')
        ->leftJoin('users as u', 'u.id', '=', 'p.user_id')
        ->select(
            'p.*',
            'u.name as user_name',
             
              'u.email as email',
              'u.phone as phone',
              'u.full_address as full_address',
            'u.photo as user_photo'
        );

    // Search filter
    if (isset($_GET['search']) && $_GET['search'] != '') {
        $search = $_GET['search'];
        $query->where(function($q) use ($search) {
            $q->where('u.name', 'LIKE', '%' . $search . '%')
              ->orWhere('u.email', 'LIKE', '%' . $search . '%')
              ->orWhere('p.payment_id', 'LIKE', '%' . $search . '%')
              ->orWhere('p.refrence', 'LIKE', '%' . $search . '%');
        });
    }

    // Date filters
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $query->whereBetween('p.created_at', [
            $_GET['start_date'] . ' 00:00:00',
            $_GET['end_date'] . ' 23:59:59'
        ]);
    } elseif (!empty($_GET['start_date'])) {
        $query->whereDate('p.created_at', '>=', $_GET['start_date']);
    } elseif (!empty($_GET['end_date'])) {
        $query->whereDate('p.created_at', '<=', $_GET['end_date']);
    }

    // $page_data['reports'] = $query->orderBy('p.created_at', 'desc')
    //                               ->paginate(10)
    //                               ->appends($request->all());
    $page_data['reports'] = $query
        ->orderBy('p.created_at', 'desc')
        ->get();

    $page_data['start_date'] = $_GET['start_date'] ?? null;
    $page_data['end_date'] = $_GET['end_date'] ?? null;
         
    return view('admin.report.payment_history', $page_data);
}

 public function destroy($id)
    {
        
        $payment = DB::table('payment_logs')->where('id', $id)->first();
          
        if (!$payment) {
            Session::flash('error', 'Payment not found.');
            return redirect()->back();
        }

        try {
            DB::table('payment_logs')->where('id', $id)->delete();
            Session::flash('success', 'Payment deleted successfully.');
            return redirect()->back();
        } catch (\Exception $e) {
            Session::flash('error', 'Failed to delete payment: ' . $e->getMessage());
            return redirect()->back();
        }
    }


}
