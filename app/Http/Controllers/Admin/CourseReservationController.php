<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseReservation;
use Illuminate\Http\Request;

class CourseReservationController extends Controller
{
    /**
     * Display all course reservations
     */
  public function index(Request $request)
{
    $query = CourseReservation::query();

    // Single Search (Name / Email / Mobile)
    if ($request->filled('search')) {
        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('student_name', 'like', '%' . $search . '%')
              ->orWhere('student_email', 'like', '%' . $search . '%')
              ->orWhere('mobile_no', 'like', '%' . $search . '%');
        });
    }

    // Filter by Type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Filter by Payment Status
    if ($request->filled('payment_status')) {
        $query->where('payment_status', $request->payment_status);
    }

    $reservations = $query
        ->orderBy('id', 'desc')
        ->get();

    return view('admin.reservations.index', compact('reservations'));
}


}
