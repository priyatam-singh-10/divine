<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\FileUploader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MyProfileController extends Controller
{
   public function index()
{
   // dd("hello");
    $user = User::find(auth()->user()->id);
    $countries = DB::table('countries')->orderBy('name')->get();

    return view(
        'frontend.' . get_frontend_settings('theme') . '.student.my_profile.index',
        [
            'user_details' => $user,
            'countries' => $countries,
        ]
    );
}

public function update(Request $request, $user_id)
{
    $rules = [
        'name'    => 'required|string|max:255',
        'email'   => 'nullable|email|unique:users,email,' . $user_id,
        'phone' => [
                'required',
                'regex:/^\+[1-9]\d{6,14}$/',
                'unique:users,phone,' .  $user_id,
            ],
        'address' => 'required|string|max:500',
        'city'    => 'required|integer|exists:cities,id',
        'state'   => 'required|integer|exists:states,id',
        'country' => 'required|integer|exists:countries,id',
        'zipcode' => ['required', 'regex:/^[0-9]{6}$/'], // exactly 6 digits only
    ];

    $messages = [
        'zipcode.regex' => 'ZIP code must be exactly 6 digits and contain only numbers.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    $data = [
        'name'      => $request->name,
        'email'     => $request->email,
        'phone'     => $request->phone,
        'website'   => $request->website,
        'facebook'  => $request->facebook,
        'twitter'   => $request->twitter,
        'linkedin'  => $request->linkedin,
        'skills'    => $request->skills,
        'biography' => $request->biography,
        'full_address' => json_encode([
            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
        ]),
    ];

    User::where('id', $user_id)->update($data);

    Session::flash('success', get_phrase('Profile updated successfully.'));
    return redirect()->back();
}


    public function update_profile_picture(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,webp,tiff|max:3072',
        ]);

        // process file
        $file      = $request->photo;
        $file_name = Str::random(20) . '.' . $file->extension();
        $path      = 'uploads/users/' . auth()->user()->role . '/' . $file_name;
        FileUploader::upload($file, $path, null, null, 300);

        User::where('id', auth()->user()->id)->update(['photo' => $path]);
        Session::flash('success', get_phrase('Profile picture updated.'));
        return redirect()->back();
    }
}
