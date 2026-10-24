<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
     
         public function studentRegisterForm()
    {
        $countries = DB::table('countries1')
            ->select('id','dial_code','name')
            ->get();
    
        return view('auth.student_register', compact('countries'));
    }
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'unique:users,email'],
            'password' => ['nullable', Rules\Password::defaults()],
             'phone' => ['required', 'digits:10','unique:users,phone'],
             'address' => ['nullable', 'string', 'max:500'],   // new
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user_data = [
            'name' => $request->name,
            'email' => $request->email,
             'phone'=>$request->phone,
            //  'address'=>$request->address,
            'role' => 'student',
            'status' => 1,
            'password' => Hash::make($request->password),
        ];
           
        if(get_settings('student_email_verification') != 1){
            $user_data['email_verified_at'] = Carbon::now();
        }

        $user = User::create($user_data);


        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    
       public function sendRegisterOtp(Request $request)
{
    $request->validate([
        'phone' => 'required'
    ]);

    $otp = rand(1000,9999);

    session([
        'register_otp' => $otp,
        'register_phone' => $request->phone,
        'register_name' => $request->name,
        'register_email' => $request->email,
        'register_password' => $request->password
    ]);

    $phone = $request->phone;

    $message = urlencode("Your Divine Touch signup OTP is $otp");

    $url = "https://listingbook.in/divine?number=$phone&message=$message";

    file_get_contents($url);

    return response()->json([
        'status'=>true
    ]);
}

public function verifyRegisterOtp(Request $request)
{
    $request->validate([
        'otp' => 'required'
    ]);

    if(session('register_otp') != $request->otp){
        return back()->with('error','Invalid OTP');
    }

    $user = User::create([
        'name' => session('register_name'),
        'email' => session('register_email'),
        'phone' => session('register_phone'),
        'password' => Hash::make(session('register_password')),
        'role' => 'student',
        'status' => 1
    ]);

    Auth::login($user);

    session()->forget([
        'register_otp',
        'register_phone',
        'register_name',
        'register_email',
        'register_password'
    ]);

    return redirect('/');
}
}
