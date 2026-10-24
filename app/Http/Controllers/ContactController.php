<?php
namespace App\Http\Controllers;
use App\Mail\Mailer;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        Contact::where('has_read', null)->update(['has_read' => 1]);
        if($request->search){
            $contact = Contact::where('email', 'like', "%$request->search%")
            ->orWhere('address', 'like', "%$request->search%")
            ->orWhere('phone', 'like', "%$request->search%")
            ->orWhere('message', 'like', "%$request->search%")
            ->orWhere('name', 'like', "%$request->search%");
        }else{
            $contact = Contact::latest();
        }
        
        $contacts = $contact->latest()->paginate(20);
        
        $page_data['contacts'] = $contacts;
        return view('admin.contact.index', $page_data);
    }

   public function store(Request $request)
{
    // Validate input
    $validator = Validator::make($request->all(), [
        'name'      => 'required|string|max:100',
        'email'     => 'required|email|max:70',
        'phone'     => 'required|numeric|digits_between:10,12',
        'message'   => 'required|string|max:500',
        'full_phone'=> 'nullable|string|max:20', // include this field
    ]);

    if ($validator->fails()) {
        return redirect()->back()
            ->withErrors($validator)
            ->withInput();
    }

    // Store both phone formats
    Contact::create([
        'name'       => $request->name,
        'email'      => $request->email,
        'phone'      =>  $request->full_phone,          // raw number
        // 'full_phone' => $request->full_phone,     // with country code
        'message'    => $request->message,
        'has_read'   => 0,
    ]);

    Session::flash('success', get_phrase('Message sent successfully'));
    return redirect()->back();
}

    public function contact_delete($id)
    {
        Contact::where('id', $id)->delete();
        Session::flash('success', get_phrase('Contact delete successfully'));
        return redirect()->back();
    }

    public function reply(Request $request)
    {
        $email = Contact::where('id', $request->send_to)->first();
        $this->send_mail($email->email, $request->subject, $request->reply_message);
        $data['replied'] = 1;
        $email = Contact::where('id', $request->send_to)->update($data);
        Session::flash('success', get_phrase('Email sent successfully'));
        return redirect()->route('admin.contacts');
    }

    public function send_mail($user_email, $subject, $description)
    {
        config([
            'mail.mailers.smtp.transport'  => get_settings('protocol'),
            'mail.mailers.smtp.host'       => get_settings('smtp_host'),
            'mail.mailers.smtp.port'       => get_settings('smtp_port'),
            'mail.mailers.smtp.encryption' => get_settings('smtp_crypto'),
            'mail.mailers.smtp.username'   => get_settings('smtp_from_email'),
            'mail.mailers.smtp.password'   => get_settings('smtp_pass'),
            'mail.from.address'            => get_settings('smtp_from_email'),
            'mail.from.name'               => get_settings('smtp_user'),
        ]);
        $mail_data['subject']     = $subject;
        $mail_data['description'] = $description;
        $send = Mail::to($user_email)->send(new Mailer($mail_data));
        return $send;
    }
}