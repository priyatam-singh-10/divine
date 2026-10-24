<?php
namespace App\Http\Controllers;
use App\Mail\Mailer;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
class EnquiryController extends Controller
{
   public function store(Request $request)
{
    
    // Define validation rules
    $rules = [
        'name'    => 'required|string|max:40',
        'email'   => 'required|email|max:20',
        'phone'   => 'required|string|digits:10',
        'full_phone'=> 'required|string|max:20',
        'subject' => 'nullable|string|max:40',
        'message' => 'required|string|max:100',
    ];

    // Custom error messages (optional)
    $messages = [
        'name.required'    => 'Name is required.',
        'name.max'         => 'Name must not exceed 40 characters.',
        'email.required'   => 'Email is required.',
        'email.email'      => 'Please enter a valid email address.',
        'email.max'        => 'Email must not exceed 20 characters.',
        'phone.required'   => 'Phone number is required.',
        'phone.digits'     => 'Phone number must be exactly 10 digits.',
        'full_phone.required'  => 'Full phone number is required.',
        'subject.max'      => 'Subject must not exceed 40 characters.',
        'message.required' => 'Message is required.',
        'message.max'      => 'Message must not exceed 100 characters.',
    ];


    // Validate the request
    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'errors'  => $validator->errors()
        ], 422);
    }

    // Save enquiry
   // $enquiry = Enquiry::create($request->all());

     // Save enquiry (store full_phone in phone column)
    $enquiry = Enquiry::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'phone'    => $request->full_phone, // save full number here
        'subject'  => $request->subject,
        'message'  => $request->message,
    ]);


    // Return success response
    return response()->json([
        'success' => true,
        'message' => 'Thank you for your enquiry!'
    ]);
}

    public function index(Request $request)
    {
         $query = Enquiry::query();

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->orWhere('phone', 'like', '%' . $request->search . '%')
                // ->orWhere('service', 'like', '%' . $request->search . '%')
                ->orWhere('message', 'like', '%' . $request->search . '%');
        }

        $enquiries = $query->latest()->paginate(10);
            return view('admin.enquiries.index', compact('enquiries'));
    }

   public function reply(Request $request)
{
    // Validate request
    $request->validate([
        'send_to' => 'required|exists:enquiries,id',
        'subject' => 'required|string|max:255',
        'reply_message' => 'required|string'
    ]);

    // Get enquiry
    $enquiry = Enquiry::find($request->send_to);

    if (!$enquiry) {
        return redirect()->route('admin.enquiries')->with('error', get_phrase('Enquiry not found.'));
    }

    // Send mail and handle response
    $response = $this->send_mail($enquiry->name,$enquiry->email, $request->subject, $request->reply_message);

    if ($response['status'] === 'success') {
        // Optionally update enquiry as replied
      //  $enquiry->update(['replied' => 1]);

        return redirect()->route('admin.enquiries')->with('success', $response['message']);
    } else {
        return redirect()->route('admin.enquiries')->with('error', $response['message']);
    }
}

    public function send_mail($user_name,$user_email, $subject, $description)
{
    try {
        // Validate user email
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => "Recipient email '$user_email' is not valid."
            ];
        }

        // Fetch settings
        $protocol     = get_settings('protocol');
        $smtp_host    = get_settings('smtp_host');
        $smtp_port    = get_settings('smtp_port');
        $smtp_crypto  = get_settings('smtp_crypto');
        $smtp_user    = get_settings('smtp_user');
        $smtp_email   = get_settings('smtp_from_email');
        $smtp_pass    = get_settings('smtp_pass');

        // Validate required settings
        $required = compact('protocol', 'smtp_host', 'smtp_port', 'smtp_crypto', 'smtp_user', 'smtp_email', 'smtp_pass');

        foreach ($required as $key => $value) {
            if (empty($value)) {
                return [
                    'status' => 'error',
                    'message' => "SMTP setting '$key' is missing or empty."
                ];
            }
        }

        // Validate from email
        if (!filter_var($smtp_email, FILTER_VALIDATE_EMAIL)) {
            return [
                'status' => 'error',
                'message' => "SMTP 'from' email '$smtp_email' is not valid."
            ];
        }

        // Configure mail settings dynamically
        config([
            'mail.mailers.smtp.transport'  => $protocol,
            'mail.mailers.smtp.host'       => $smtp_host,
            'mail.mailers.smtp.port'       => $smtp_port,
            'mail.mailers.smtp.encryption' => $smtp_crypto,
            'mail.mailers.smtp.username'   => $smtp_email,
            'mail.mailers.smtp.password'   => $smtp_pass,
            'mail.from.address'            => $smtp_email,
            'mail.from.name'               => $smtp_user,
        ]);


        $system_title = get_settings('system_title');
        $system_email = get_settings('system_email');
        $system_phone = get_settings('phone');
        $logo_url     = "https://www.divinetouch.info/public/uploads/dark_logo/darklogo-1748955956.png";

          // Build HTML template
        $htmlContent = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>' . e($subject) . '</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color:#f4f4f4; margin:0; padding:20px;">
            <table align="center" cellpadding="0" cellspacing="0" width="600" style="background:#ffffff; border-radius:8px; overflow:hidden; box-shadow:0 2px 5px rgba(0,0,0,0.1);">
                <tr style="background:#4e73df;">
                    <td align="center" style="padding:15px;">
                        <img src="' . $logo_url . '" alt="' . e($system_title) . '" style="max-height:50px;">
                    </td>
                </tr>
                <tr>
                    <td style="padding:20px; color:#333; line-height:1.6;">
                        <p>Hello <strong>' . e($user_name) . '</strong>,</p>
                        <p>Thank you for contacting <strong>' . e($system_title) . '</strong>. Please find our reply below:</p>
                        <p style="background:#f9f9f9; padding:15px; border-left:4px solid #4e73df; border-radius:4px;">' . nl2br(e($description)) . '</p>
                        <p>If you have any further questions, feel free to reply to this email. We are always happy to assist you.</p>
                        <p style="margin-top:20px;">Regards,<br><strong>' . e($system_title) . ' Team</strong></p>
                    </td>
                </tr>
                <tr style="background:#f1f1f1;">
                    <td style="padding:15px; text-align:center; font-size:12px; color:#555;">
                        <p>Contact us: ' . e($system_email) . ' | ' . e($system_phone) . '</p>
                        <p>&copy; ' . date('Y') . ' ' . e($system_title) . '. All rights reserved.</p>
                    </td>
                </tr>
            </table>
        </body>
        </html>';

         // Send mail using raw html
        Mail::send([], [], function ($message) use ($user_email, $subject, $htmlContent) {
            $message->to($user_email)
                    ->subject($subject)
                    ->html($htmlContent);
        });
        // Prepare and send mail
        // $mail_data = [
        //     'subject' => $subject,
        //     'description' => $description
        // ];

        // Mail::to($user_email)->send(new Mailer($mail_data));

        return [
            'status' => 'success',
            'message' => 'Mail sent successfully.'
        ];

    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => $e->getMessage()
        ];
    }
}

    public function destroy($id)
    {
        Enquiry::findOrFail($id)->delete();
        return back()->with('success', 'Enquiry deleted successfully.');
    }

}
