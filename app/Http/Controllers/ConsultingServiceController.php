<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultingService;
use App\Models\consultation_slots;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\Mailer;
class ConsultingServiceController extends Controller
{
    // Get all bookings (Admin side)
  
   public function index(Request $request)
{
    $search = $request->input('search');

      $services = ConsultingService::with('slot') // eager load slot
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('service', 'like', "%{$search}%")
                ->orWhere('page', 'like', "%{$search}%")
                ->orWhere('date', 'like', "%{$search}%")
                ->orWhereHas('slot', function ($q) use ($search) {
                    $q->where('start_time', 'like', "%{$search}%")
                      ->orWhere('end_time', 'like', "%{$search}%");
                })
                ->orWhere('status', 'like', "%{$search}%");
        })
        ->orderBy('created_at', 'desc')
        ->paginate(10);
        return view('admin.consulting_services.index', compact('services'));
}

    public function reschedule(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $service = ConsultingService::findOrFail($id);
        $service->date = $request->date;
        $service->start_time = $request->start_time;
        $service->end_time = $request->end_time;
        $service->save();

        return redirect()->back()->with('success', 'Appointment rescheduled successfully.');
    }


    

    // Store new booking (User side)
    // public function store(Request $request)
    // {
       
    
    //     $validated = $request->validate([
    //         'name'    => 'required|string|max:255',
    //         'email'   => 'required|email',
    //         'phone'   => 'required|string|max:15',
    //         'service' => 'nullable|string',
    //         'page' => 'nullable|string',
    //         'additional_details' => 'nullable|string',
    //         'date'    => 'required|date',
    //         'status'   =>'nullable',
    //         'time'    => 'required'  // here time is slot id
    //     ]);
    //       $slotId = $validated['time'];

    //         // Fetch the slot from DB
    //         $slot = consultation_slots::find($slotId);

    //         if (!$slot) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Invalid slot selected.',
    //             ], 422);
    //         }

    //         // Add slot_id, start_time and end_time to validated data
    //         $validated['slot_id'] = $slotId;
    //         $validated['start_time'] = $slot->start_time;
    //         $validated['end_time'] = $slot->end_time;

    //         unset($validated['time']); // remove the temporary 'time'
    //     //dd( $validated );
    //     $booking = ConsultingService::create($validated);
        
    //     return response()->json([
    //         'status' => true,
    //         'message' => 'Consultation request submitted successfully!',
    //         'data' => $booking
    //     ], 201);
    // }
    
    public function store(Request $request)
{
  
    $validated = $request->validate([
        'name'    => 'required|string|max:255',
        'email'   => 'required|email',
        'phone'   => 'required|string|max:15',
        'service' => 'nullable|string',
        'page'    => 'nullable|string',
        'additional_details' => 'nullable|string',
        'date'    => 'required|date',
        'status'  => 'nullable',
        'time'    => 'required', // here 'time' is the slot id
    ]);

    $slotId = $validated['time']; // e.g., Hypnosis_2025-10-16_18:00

    // Extract date and hour from slotId if it’s a hardcoded slot
    $slotParts = explode('_', $slotId); 
    // format: Service_YYYY-MM-DD_HH:MM
    $slotService = $slotParts[0] ?? null;
    $slotDate    = $slotParts[1] ?? null;
    $slotStart   = $slotParts[2] ?? null;

    // Determine default end_time
    if ($slotStart) {
        $startTime = \Carbon\Carbon::parse($slotStart)->format('H:i:s');
        $endTime   = \Carbon\Carbon::parse($slotStart)->addHour()->format('H:i:s');
    } else {
        return response()->json([
            'status' => false,
            'message' => 'Invalid slot selected.',
        ], 422);
    }

    // If slot exists in DB, fetch it; otherwise just use dynamic start/end
    $slot = consultation_slots::find($slotId);

    $validated['slot_id']    = $slotId;
    $validated['start_time'] = $slot ? $slot->start_time : $startTime;
    $validated['end_time']   = $slot ? $slot->end_time : $endTime;

    unset($validated['time']); // remove temporary 'time'

    $booking = ConsultingService::create($validated);
        try {
           $subject = "Appointment Booked - " . ($validated['page'] ?? 'Consultation');
$logoUrl = get_image(get_frontend_settings('dark_logo'));

// HTML email content
$description = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f6f6f6; margin:0; padding:0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f6f6f6; padding: 20px 0;">
        <tr>
            <td align="center">
                <table style="width: 600px; max-width: 100%; border-collapse: collapse; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); overflow: hidden">
                    <!-- Logo -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 10px; text-align: center">
                            <img src="https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png" alt="Logo" height="50" style="display: block; margin: 0 auto; padding-bottom:4px;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 26px; font-weight: 600">Appointment Booked!</h1>
                        </td>
                    </tr>
                    <!-- Greeting -->
                    <tr>
                        <td style="padding: 30px;">
                            <h2 style="color: #333333;">Dear '.htmlspecialchars($validated['name']).',</h2>
                            <p style="color: #555555; font-size: 16px; line-height: 1.5;">
                                Congratulations! Your appointment for <strong>'.htmlspecialchars($validated['page'] ?? 'N/A').'</strong> with <strong>Divine Touch</strong> has been successfully booked.
                            </p>
                            <!-- Appointment Details -->
                            <h3 style="color: #333333;">Appointment Details</h3>
                            <table cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 15px;">
                                <tr>
                                    <td style="font-weight: bold; width: 150px;">Date & Time:</td>
                                    <td>'.htmlspecialchars($validated['date']).' | '.($slot ? $slot->start_time : $startTime).' - '.($slot ? $slot->end_time : $endTime).'</td>
                                </tr>
                                <tr>
                                    <td style="font-weight: bold;">Phone:</td>
                                    <td>'.htmlspecialchars($validated['phone']).'</td>
                                </tr>
                            </table>
                            <!-- Footer -->
                            <p style="color: #555555; font-size: 16px; margin-top: 20px;">
                                We look forward to serving you!
                            </p>
                            <p style="color: #555555; font-size: 16px;">
                                <strong style="color: #333333">Regards</strong>,<br>
                                <span style="color: #10b981; font-weight: 600">Divine Touch</strong>
                            </p>
                        </td>
                    </tr>
                    <!-- Bottom Note -->
                    <tr>
                        <td style="padding: 15px; text-align: center; background-color: #f8f9fa; color: #999999; font-size: 13px;">
                            &copy; '.date('Y').' Divine Touch. All rights reserved.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
';


// Send the email
Mail::to($validated['email'])->send(new Mailer([
    'subject' => $subject,
    'description' => $description
]));
           
        } catch (\Exception $e) {
            \Log::error('Failed to send confirmation email: '.$e->getMessage());
        }
        
        
          
    return response()->json([
        'status'  => true,
        'message' => 'Consultation request submitted successfully!',
        'data'    => $booking
    ], 201);
}

    public function updateStatus(Request $request, $id)
{
    
    $request->validate([
        'status' => 'required|in:confirmed,cancelled',
    ]);

    $service = ConsultingService::findOrFail($id);
    $service->status = $request->status;
    $service->save();
      
    try {
    // Set subject based on appointment status
    $subject = $service->status === 'confirmed'
        ? "Your Appointment Has Been Confirmed"
        : "Your Appointment Has Been Cancelled";

    // Prepare the HTML description
    $logoUrl = asset(get_frontend_settings('dark_logo'));
    $statusText = $service->status === 'confirmed' ? 'Confirmed' : 'Cancelled';
    $statusColor = $service->status === 'confirmed' ? '#28a745' : '#dc3545';

    $description = '
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Appointment Status Update</title>
    </head>
    <body style="font-family: Arial, sans-serif; background-color: #f6f6f6; margin:0; padding:0;">
        <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f6f6f6; padding: 20px 0;">
            <tr>
                <td align="center">
                    <table width="600" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <!-- Logo -->
                        <tr>
                            <td style="background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 10px; text-align: center">
                                <img src="https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png" alt="Logo" height="50" style="display: block; margin: 0 auto">
                            </td>
                        </tr>
                        <!-- Greeting -->
                        <tr>
                            <td style="padding: 30px;">
                                <h2 style="color: #333;">Hello '.htmlspecialchars($service->name).',</h2>
                                <p style="color: #555; font-size: 16px; line-height: 1.5;">
                                    Your appointment has been <span style="color: '.$statusColor.'; font-weight: bold;">'.$statusText.'</span>.
                                </p>
                                <h3 style="color: #333;">Appointment Details</h3>
                                <table cellpadding="5" cellspacing="0" style="width: 100%; border-collapse: collapse; font-size: 15px;">
                                    <tr>
                                        <td style="font-weight: bold; width: 150px;">Service:</td>
                                        <td>'.htmlspecialchars($service->service ?? 'N/A').'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Date:</td>
                                        <td>'.htmlspecialchars($service->date).'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Time:</td>
                                        <td>'.htmlspecialchars($service->start_time).' - '.htmlspecialchars($service->end_time).'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight: bold;">Phone:</td>
                                        <td>'.htmlspecialchars($service->phone).'</td>
                                    </tr>
                                </table>
                                <p style="color: #555; font-size: 16px; margin-top: 20px;">
                                    We look forward to serving you!
                                </p>
                                <p style="color: #555555; font-size: 16px">
                                    <strong style="color: #333333">Regards</strong>,<br>
                                        <span style="color: #10b981; font-weight: 600">Divine Touch
                                    </span>
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 0 30px">
                                <div style="border-top: 1px solid #e0e0e0"></div>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 15px; text-align: center; background-color: #f1f1f1; color: #777; font-size: 13px;">
                                &copy; '.date('Y').' '.config('app.name').'. All rights reserved.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>';

    // Send the email using the Mailer Mailable class
    Mail::to($service->email)->send(new \App\Mail\Mailer([
        'subject' => $subject,
        'description' => $description
    ]));

} catch (\Exception $e) {
    \Log::error('Failed to send appointment status email: '.$e->getMessage());
}


    return redirect()->back()->with('success', 'Status updated successfully and email sent.');
}


     public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $session = ConsultingService::findOrFail($id);
        $session->delete();

        return redirect()->route('admin.consultation-services')
            ->with('success', 'Consultation service deleted successfully.');
    }

        public function index_slots(Request $request)
    {
        $query = consultation_slots::query();
    
        // Optional search by service name
        if ($request->has('search') && $request->search != '') {
            $query->where('service', 'like', '%' . $request->search . '%');
        }
    
        // Get paginated results (10 per page)
        $slots = $query->orderByRaw('GREATEST(created_at, updated_at) DESC')->paginate(10);
    
        return view('admin.consulting_services.slot_index', compact('slots'));
     }

      public function slots_create()
    {
        return view('admin.consulting_services.slot_create');
    }


    public function slots_store(Request $request)
        {
            $request->validate([
                'service'    => 'required|string|max:255',
                'slot_date'  => 'required|date|after_or_equal:today',
                'start_time' => 'required|date_format:H:i',
                'end_time'   => 'required|date_format:H:i|after:start_time',
                'is_booked'  => 'nullable|boolean',
            ], [
                'slot_date.after_or_equal' => 'The slot date must be today or a future date.',
                'end_time.after'           => 'The end time must be after the start time.',
            ]);

            // Extra check for "today's slots"
            $slotDate  = \Carbon\Carbon::parse($request->slot_date);
            $startTime = \Carbon\Carbon::parse($request->slot_date . ' ' . $request->start_time);

            if ($slotDate->isToday() && $startTime->isPast()) {
                return back()->withErrors([
                    'start_time' => 'Start time must be in the future for today\'s slots.'
                ])->withInput();
            }

            consultation_slots::create($request->all());

            return redirect()
                ->route('admin.consultation-services-slots')
                ->with('success', 'Consultation slot created successfully.');
        }


     // Show edit form
    public function slots_edit($id)
    {
        
        $slot = consultation_slots::findOrFail($id);
       
        return view('admin.consulting_services.slot_edit', compact('slot'));
    }
      // Update slot
   public function slots_update(Request $request, $id)
{
    $request->validate([
        'service'    => 'required|string|max:255',
        'slot_date'  => 'required|date|after_or_equal:today', // today or future
        'start_time' => 'required|date_format:H:i',
        'end_time'   => 'required|date_format:H:i|after:start_time',
        'is_booked'  => 'nullable|boolean',
    ], [
        'slot_date.after_or_equal' => 'The slot date must be today or a future date.',
        'end_time.after'           => 'The end time must be after the start time.',
    ]);

    $slotDate  = \Carbon\Carbon::parse($request->slot_date);
    $startTime = \Carbon\Carbon::parse($request->slot_date . ' ' . $request->start_time);

    if ($slotDate->isToday() && $startTime->isPast()) {
        return back()->withErrors([
            'start_time' => 'Start time must be in the future for today\'s slots.'
        ])->withInput();
    }

    $slot = consultation_slots::findOrFail($id);
    $slot->update($request->all());

    return redirect()
        ->route('admin.consultation-services-slots')
        ->with('success', 'Consultation slot updated successfully.');
}


     // Delete slot
    public function slots_delete($id)
    {
       
        $slot = consultation_slots::findOrFail($id);
        $slot->delete();

        return redirect()->route('admin.consultation-services-slots')
                         ->with('success', 'Consultation slot deleted successfully.');
    }
     
     
     public function getAvailableDates(Request $request)
{
    $request->validate([
        'service' => 'required|string',
    ]);

      // Get unique available dates from today onward
    $dates = consultation_slots::where('service', $request->service)
        ->where('is_booked', 0)
        ->whereDate('slot_date', '>=', \Carbon\Carbon::today()) // only today or future
        ->pluck('slot_date')
        ->unique()
        ->map(function ($date) {
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        })
        ->values();
       
        
    return response()->json([
        'status' => 'success',
        'dates' => $dates
    ]);
}
   public function getAvailableSlots(Request $request)
{
    $request->validate([
        'service' => 'required|string',
        'date' => 'required|date',
    ]);

    $slots = consultation_slots::where('service', $request->service)
        ->where('slot_date', $request->date)
        ->where('is_booked', 0) // only available
        ->orderBy('start_time', 'asc')
        ->get(['id', 'start_time', 'end_time']);

    if ($slots->isEmpty()) {
        return response()->json([
            'status' => 'error',
            'message' => 'No slots available for the selected date.'
        ]);
    }

    return response()->json([
        'status' => 'success',
        'slots' => $slots
    ]);
}


public function getHardcodedSlots(Request $request)
{
  
    $request->validate([
        'service' => 'required|string',
        'date'    => 'required|date',
    ]);

    $service = $request->service;
    $date    = $request->date;

    $dateObj = \Carbon\Carbon::parse($date);
    $dayOfWeek = $dateObj->dayOfWeek; // 0 = Sunday, 1 = Monday, ... 6 = Saturday

    $slots = [];

    if ($dayOfWeek == 0) {
        // Sunday: 10 AM - 7 PM
        $startTime = 10;
        $endTime   = 19;
    } else {
        // Mon-Sat: 5 PM - 10 PM
        $startTime = 17;
        $endTime   = 22;
    }

    for ($hour = $startTime; $hour < $endTime; $hour++) {
        $start = \Carbon\Carbon::createFromTime($hour, 0, 0)->format('H:i');
        $end   = \Carbon\Carbon::createFromTime($hour + 1, 0, 0)->format('H:i');

        $slots[] = [
            'id'         => $service . '_' . $date . '_' . $start, // unique id for frontend select
            'start_time' => $start,
            'end_time'   => $end,
        ];
    }

    return response()->json([
        'status' => 'success',
        'slots'  => $slots,
    ]);
}



}



