<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\FileUploader;
use App\Models\Payout;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\Message;
use App\Models\MessageThread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;


class UsersController extends Controller
{

    public function admin_index(Request $request)
    {
        $query = User::where('role', 'admin');
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $query = $query->where('name', 'LIKE', '%' . $_GET['search'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $_GET['search'] . '%');
        }
        $page_data['admins'] = $query->paginate(10);
        return view('admin.admin.index', $page_data);
    }

    public function admin_create()
    {
        return view('admin.admin.create_admin');
    }
    public function admin_store(Request $request)
    {

        $validated = $request->validate([
            'name'     => "required",
            'email'    => 'required|email|unique:users',
            'password' => "required|min:8",
        ]);

        $data['name']     = $request->name;
        $data['about']    = $request->about;
        $data['phone']    = $request->phone;
        $data['address']  = $request->address;
        $data['email']    = $request->email;
        $data['password'] = Hash::make($request->password);
        $data['facebook'] = $request->facebook;
        $data['twitter']  = $request->twitter;
        $data['website']  = $request->website;
        $data['linkedin'] = $request->linkedin;
        $data['role']     = 'admin';
        $data['status']     = '1';

        if (isset($request->photo) && $request->hasFile('photo')) {
            $path = "uploads/users/instructor/" . nice_file_name($request->name, $request->photo->extension());
            FileUploader::upload($request->photo, $path, 400, null, 200, 200);
            $data['photo'] = $path;
        }

        $done = User::insert($data);

        if ($done) {
            $admin_id = User::latest('id')->first();
            Permission::insert(['admin_id' => $admin_id->id]);
        }
        Session::flash('success', get_phrase('Admin add successfully'));
        return redirect()->route('admin.admins.index');
    }

    public function admin_edit($id)
    {
        $page_data['admin'] = User::where('id', $id)->first();
        return view('admin.admin.edit_admin', $page_data);
    }
    public function admin_update(Request $request, $id)
    {

        $validated = $request->validate([
            'name'  => 'required|max:255',
            'email' => "required|email|unique:users,email,$id",
        ]);

        $data['name']     = $request->name;
        $data['about']    = $request->about;
        $data['phone']    = $request->phone;
        $data['address']  = $request->address;
        $data['email']    = $request->email;
        $data['facebook'] = $request->facebook;
        $data['twitter']  = $request->twitter;
        $data['website']  = $request->website;
        $data['linkedin'] = $request->linkedin;
        
        if (isset($request->photo) && $request->hasFile('photo')) {
            remove_file(User::where('id', $id)->first()->photo);
            $path = "uploads/users/instructor/" . nice_file_name($request->name, $request->photo->extension());
            FileUploader::upload($request->photo, $path, 400, null, 200, 200);
            $data['photo'] = $path;
        }

        User::where('id', $request->id)->update($data);
        Session::flash('success', get_phrase('Admin update successfully'));
        return redirect()->route('admin.admins.index');
    }

    public function admin_delete($id)
    {
        $threads = MessageThread::where('contact_one', $id)
                    ->orWhere('contact_two', $id)
                    ->pluck('id');

        if ($threads->isNotEmpty()) {
            Message::whereIn('thread_id', $threads)->delete();
            MessageThread::whereIn('id', $threads)->delete();
        }

        $done = User::where('id', $id)->delete();
        if ($done) {
            Permission::where('admin_id', $id)->delete();
        }
        Session::flash('success', get_phrase('Admin delete successfully'));
        return redirect()->back();
    }

    public function admin_permission($user_id)
    {
        $page_data['admin'] = User::where('id', $user_id)->firstOrNew();
        return view('admin.admin.permission', $page_data);
    }
    public function admin_permission_store(Request $request)
    {
        $user_id = $request->user_id;

        $permission = Permission::where('admin_id', $user_id)->first();

        if ($permission) {
            $set_permission = json_decode($permission->permissions, true) ?? [];
            if (in_array($request->permission, $set_permission)) {
                $pos = array_search($request->permission, $set_permission);
                array_splice($set_permission, $pos, 1);
            } else {
                array_push($set_permission, $request->permission);
            }
            Permission::where('admin_id', $user_id)->update(['permissions' => $set_permission]);
            return true;
        } else {
            $set_per = json_encode([$request->permission]);
            Permission::insert(['admin_id' => $user_id, 'permissions' => $set_per]);
            return true;
        }
    }

    public function instructor_index()
    {
        $query = User::where('role', 'instructor');
        if (isset($_GET['search']) && $_GET['search'] != '') {
            $query = $query->where('name', 'LIKE', '%' . $_GET['search'] . '%')
                ->orWhere('email', 'LIKE', '%' . $_GET['search'] . '%');
        }
        $page_data['instructors'] = $query->paginate(10);
        return view('admin.instructor.index', $page_data);
    }

    public function instructor_create()
    {
        return view('admin.instructor.create_instructor');
    }
    public function instructor_edit($id = '')
    {
        $page_data['instructor'] = User::where('id', $id)->first();
        return view('admin.instructor.edit_instructor', $page_data);
    }
    public function instructor_store(Request $request, $id = '')
    {
        $validated = $request->validate([
            'name'     => "required|max:255",
            'email'    => 'required|email|unique:users',
            'password' => "required|min:8",
        ]);

        if(get_settings('student_email_verification') != 1){
            $data['email_verified_at'] = date('Y-m-d H:i:s');
        }

        $data['name']        = $request->name;
        $data['about']       = $request->about;
        $data['phone']       = $request->phone;
        $data['address']     = $request->address;
        $data['email']       = $request->email;
        $data['facebook']    = $request->facebook;
        $data['twitter']     = $request->twitter;
        $data['website']     = $request->website;
        $data['linkedin']    = $request->linkedin;
        $data['paymentkeys'] = json_encode($request->paymentkeys);
        $data['status']     = '1';

        $data['password'] = Hash::make($request->password);
        $data['role']     = 'instructor';

        if (isset($request->photo) && $request->hasFile('photo')) {
            $path = "uploads/users/instructor/" . nice_file_name($request->name, $request->photo->extension());
            FileUploader::upload($request->photo, $path, 400, null, 200, 200);
            $data['photo'] = $path;
        }
        $user = User::create($data);

        if(get_settings('student_email_verification') == 1) {
            $user->sendEmailVerificationNotification();
        }

        Session::flash('success', get_phrase('Instructor add successfully'));

        return redirect()->route('admin.instructor.index');
    }

    public function instructor_update(Request $request, $id = '')
    {
        
        $validated = $request->validate([
            'name'  => 'required|max:255',
            'email' => "required|email|unique:users,email,$id",
        ]);

        $data['name']        = $request->name;
        $data['about']       = $request->about;
        $data['phone']       = $request->phone;
        $data['address']     = $request->address;
        $data['email']       = $request->email;
        $data['facebook']    = $request->facebook;
        $data['twitter']     = $request->twitter;
        $data['website']     = $request->website;
        $data['linkedin']    = $request->linkedin;
        $data['paymentkeys'] = json_encode($request->paymentkeys);

        if (isset($request->photo) && $request->hasFile('photo')) {
            remove_file(User::where('id', $id)->first()->photo);
            $path = "uploads/users/instructor/" . nice_file_name($request->name, $request->photo->extension());
            FileUploader::upload($request->photo, $path, 400, null, 200, 200);
            $data['photo'] = $path;
        }

        User::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Instructor update successfully'));
        return redirect()->route('admin.instructor.index');
    }

    public function instructor_delete($id)
    {
        $threads = MessageThread::where('contact_one', $id)
                    ->orWhere('contact_two', $id)
                    ->pluck('id');

        if ($threads->isNotEmpty()) {
            Message::whereIn('thread_id', $threads)->delete();
            MessageThread::whereIn('id', $threads)->delete();
        }
        
        User::where('id', $id)->delete();
        Session::flash('success', get_phrase('Instructor delete successfully'));
        return redirect()->back();
    }

    public function instructor_view_course(Request $request)
    {
        $course = Course::where('user_id', $request->id)->get();
    }

    public function instructor_payout(Request $request)
    {
        $start_date                              = strtotime('first day of this month');
        $end_date                                = strtotime('last day of this month');
        $page_data['start_date']                 = $start_date;
        $page_data['end_date']                   = $end_date;
        $page_data['instructor_payout_complete'] = Payout::where('status', 1)->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
            ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->paginate(10);
        $page_data['instructor_payout_incomplete'] = Payout::where('status', 0)->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
            ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->paginate(10);
        return view('admin.instructor.payout', $page_data);
    }
    public function instructor_payout_filter(Request $request)
    {

        $date                    = explode('-', $request->eDateRange);
        $start_date              = strtotime($date[0] . ' 00:00:00');
        $end_date                = strtotime($date[1] . ' 23:59:59');
        $page_data['start_date'] = $start_date;
        $page_data['end_date']   = $end_date;

        $page_data['instructor_payout_complete'] = Payout::where('status', 1)->where('created_at', '>=', date('Y-m-d H:i:s', $start_date))
            ->where('created_at', '<=', date('Y-m-d H:i:s', $end_date))->paginate(10);
        $page_data['instructor_payout_incomplete'] = Payout::where('status', 0)->paginate(10);

        return view('admin.instructor.payout', $page_data);
    }

    public function instructor_payout_invoice($id = '')
    {
        if ($id != '') {
            $page_data['invoice_info'] = Payout::where('status', 1)->first();
            $page_data['invoice_data'] = Payout::where('status', 1)->get();
            $page_data['invoice_id']   = $id;

            return view('admin.instructor.instructor_invoice', $page_data);
        }
    }

    public function instructor_payment(Request $request)
    {
        $id              = $request->user_id;
        $payable_amount  = $request->amount;
        $start_timestamp = time();
        $end_timestamp   = time();

        $payment_details = [
            'items'          => [
                [
                    'id'                  => $id,
                    'title'               => get_phrase('Pay for instructor payout'),
                    'subtitle'            => get_phrase(''),
                    'price'               => $payable_amount,
                    'discount_price'      => $payable_amount,
                    'discount_percentage' => 0,
                ],
            ],
            'custom_field'   => [
                'start_date' => date('Y-m-d H:i:s', $start_timestamp),
                'end_date'   => date('Y-m-d H:i:s', $end_timestamp),
                'user_id'    => auth()->user()->id,
                'payout_id'  => $request->payout_id,

            ],
            'success_method' => [
                'model_name'    => 'InstructorPayment',
                'function_name' => 'instructor_payment',
            ],
            'tax'            => 0,
            'coupon'         => null,
            'payable_amount' => $payable_amount,
            'cancel_url'     => route('admin.instructor.payout'),
            'success_url'    => route('payment.success'),
        ];
        session(['payment_details' => $payment_details]);
        return redirect()->route('payment');
    }

    public function instructor_setting()
    {
        $page_data['allow_instructor']   = Setting::where('type', 'allow_instructor')->first();
        $page_data['application_note']   = Setting::where('type', 'instructor_application_note')->first();
        $page_data['instructor_revenue'] = Setting::where('type', 'instructor_revenue')->first();
        return view('admin.instructor.instructor_setting', $page_data);
    }

    public function instructor_setting_store(Request $request)
    {

        if ($request->first == 'item_1') {

            $key_found = Setting::where('type', 'instructor_application_note')->exists();
            if ($key_found) {
                $data['description'] = $request->instructor_application_note;

                Setting::where('type', 'instructor_application_note')->update($data);
            } else {
                $data['type']        = 'instructor_application_note';
                $data['description'] = $request->instructor_application_note;

                Setting::insert($data);
            }

            $key_founds = Setting::where('type', 'allow_instructor')->exists();
            if ($key_founds) {
                $data['description'] = $request->allow_instructor;

                Setting::where('type', 'allow_instructor')->update($data);
            } else {

                $data['type']        = 'allow_instructor';
                $data['description'] = $request->allow_instructor;

                Setting::insert($data);
            }
        }
        if ($request->second == 'item_2') {

            $key_found = Setting::where('type', 'instructor_revenue')->exists();
            if ($key_found) {
                $data['description'] = $request->instructor_revenue;

                Setting::where('type', 'instructor_revenue')->update($data);
            } else {
                $data['type']        = 'instructor_revenue';
                $data['description'] = $request->instructor_revenue;

                Setting::insert($data);
            }
        }

        Session::flash('success', get_phrase('Instructor setting updated'));
        return redirect()->back();
    }

    public function instructor_application()
    {
        return view('admin.instructor.application');
    }
    public function instructor_application_approve($id)
    {
        $query         = Application::where('id', $id);
        $update_status = $query->update(['status' => 1]);
        if ($update_status) {
            $user_id = $query->first();
            User::where('id', $user_id->user_id)->update(['role' => 'instructor']);
            Session::flash('success', get_phrase('Application approve successfully'));
        }
        return redirect()->back();
    }
    public function instructor_application_delete($id)
    {
        Application::where('id', $id)->delete();
        Session::flash('success', get_phrase('Application delete successfully'));
        return redirect()->back();
    }
    public function instructor_application_download($id)
    {
        $path = Application::where('id', $id)->first();

        if (file_exists(public_path($path->document))) {
            return response()->download(public_path($path->document));
        } else {
            Session::flash('error', get_phrase('File does not exists'));
            return redirect()->back();
        }
    }

    // public function student_index()
    // {
    //     $query = User::where('role', 'student');
    //     if (isset($_GET['search']) && $_GET['search'] != '') {
    //         $query = $query->where('name', 'LIKE', '%' . $_GET['search'] . '%')
    //             ->orWhere('email', 'LIKE', '%' . $_GET['search'] . '%');
    //     }
        
    //      if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    //             $query->whereBetween('created_at', [
    //                 $_GET['start_date'] . ' 00:00:00',
    //                 $_GET['end_date'] . ' 23:59:59'
    //             ]);
    //         } elseif (!empty($_GET['start_date'])) {
    //             $query->whereDate('created_at', '>=', $_GET['start_date']);
    //         } elseif (!empty($_GET['end_date'])) {
    //             $query->whereDate('created_at', '<=', $_GET['end_date']);
    //         }
    //     $page_data['students'] = $query->orderBy('id', 'desc')->paginate(10);
    //     return view('admin.student.index', $page_data);
    // }
    
    
    public function student_index()
{
    $query = User::where('role', 'student');

    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    // Keep existing date filters
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $query->whereBetween('created_at', [
            $_GET['start_date'].' 00:00:00',
            $_GET['end_date'].' 23:59:59'
        ]);
    } elseif (!empty($_GET['start_date'])) {
        $query->whereDate('created_at', '>=', $_GET['start_date']);
    } elseif (!empty($_GET['end_date'])) {
        $query->whereDate('created_at', '<=', $_GET['end_date']);
    }

    $students = $query->orderBy('id', 'desc')->paginate(10);

  if (request()->ajax()) {
    $html = '';
    foreach ($students as $key => $row) {
        $html .= '<tr>';
        $html .= '<th scope="row"><p class="row-number">'.($key+1).'</p></th>';
        $html .= '<td>
                    <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                        <div class="dAdmin_profile_img">
                            <img class="img-fluid rounded-circle image-45" width="45" height="45"
                            src="'.($row->photo && file_exists(public_path($row->photo)) 
                                ? asset($row->photo) 
                                : asset("uploads/users/student/placeholder/placeholder.PNG")).'" />
                        </div>
                        <div class="ms-1">
                            <h4 class="title fs-14px">'.ucwords($row->name).'</h4>
                        </div>
                    </div>
                  </td>';
                  
                  
$addr = $row->full_address ?? [];
$country = isset($addr['country']) ? \DB::table('countries')->where('id', $addr['country'])->value('name') : '';
$state   = isset($addr['state']) ? \DB::table('states')->where('id', $addr['state'])->value('name') : '';
$city    = isset($addr['city']) ? \DB::table('cities')->where('id', $addr['city'])->value('name') : '';
$street  = $addr['address'] ?? '';
$zip     = $addr['zipcode'] ?? '';
$fullAddress = trim("{$street}, {$city}, {$state}, {$country}, {$zip}", ', ');

$fullAddress = trim("{$street}, {$city}, {$state}, {$country}, {$zip}", ', ');
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.$row->phone.'</p></div></td>';
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.$fullAddress.'</p></div></td>';
        $html .= '<td>'.\App\Models\Enrollment::where("user_id",$row->id)->count().' '.get_phrase("Courses").'</td>';
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.($row->created_at ? $row->created_at->format("d M Y, h:i A") : "-").'</p></div></td>';
        $html .= '<td><div class="form-check form-switch"><input class="form-check-input changeStatus" type="checkbox" data-id="'.$row->id.'" '.($row->status==1?"checked":"").'></div></td>';
        $html .= '<td class="print-d-none">
                    <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#studentModal'.$row->id.'"><i class="fi-rr-eye me-2"></i> '.get_phrase("View").'</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="'.route('admin.student.edit', $row->id).'"><i class="fi-rr-edit me-2"></i> '.get_phrase("Edit").'</a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="confirmModal(\''.route('admin.student.delete', $row->id).'\')" href="javascript:void(0)"><i class="fi-rr-trash me-2"></i> '.get_phrase("Delete").'</a>
                            </li>
                        </ul>
                    </div>
                  </td>';
        $html .= '</tr>';
    }

    return response()->json(['html' => $html]);
}


    return view('admin.student.index', ['students' => $students]);
}


public function deleteduserindex(){
    
   $query = User::onlyTrashed()->where('role', 'student');

    if (!empty($_GET['search'])) {
        $search = $_GET['search'];
        $query->where(function($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
              ->orWhere('email', 'LIKE', "%{$search}%")
              ->orWhere('phone', 'LIKE', "%{$search}%");
        });
    }

    // Keep existing date filters
    if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
        $query->whereBetween('created_at', [
            $_GET['start_date'].' 00:00:00',
            $_GET['end_date'].' 23:59:59'
        ]);
    } elseif (!empty($_GET['start_date'])) {
        $query->whereDate('created_at', '>=', $_GET['start_date']);
    } elseif (!empty($_GET['end_date'])) {
        $query->whereDate('created_at', '<=', $_GET['end_date']);
    }

    $students = $query->orderBy('id', 'desc')->paginate(10);

  if (request()->ajax()) {
    $html = '';
    foreach ($students as $key => $row) {
        $html .= '<tr>';
        $html .= '<th scope="row"><p class="row-number">'.($key+1).'</p></th>';
        $html .= '<td>
                    <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                        <div class="dAdmin_profile_img">
                            <img class="img-fluid rounded-circle image-45" width="45" height="45"
                            src="'.($row->photo && file_exists(public_path($row->photo)) 
                                ? asset($row->photo) 
                                : asset("uploads/users/student/placeholder/placeholder.PNG")).'" />
                        </div>
                        <div class="ms-1">
                            <h4 class="title fs-14px">'.ucwords($row->name).'</h4>
                        </div>
                    </div>
                  </td>';
                  
                  
$addr = $row->full_address ?? [];
$country = isset($addr['country']) ? \DB::table('countries')->where('id', $addr['country'])->value('name') : '';
$state   = isset($addr['state']) ? \DB::table('states')->where('id', $addr['state'])->value('name') : '';
$city    = isset($addr['city']) ? \DB::table('cities')->where('id', $addr['city'])->value('name') : '';
$street  = $addr['address'] ?? '';
$zip     = $addr['zipcode'] ?? '';
$fullAddress = trim("{$street}, {$city}, {$state}, {$country}, {$zip}", ', ');

$fullAddress = trim("{$street}, {$city}, {$state}, {$country}, {$zip}", ', ');
        $html .= '<td><div class="dAdmin_info_name min-w-200px"><p>'.$row->email.'</p></div></td>';
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.$row->phone.'</p></div></td>';
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.$fullAddress.'</p></div></td>';
        $html .= '<td>'.\App\Models\Enrollment::where("user_id",$row->id)->count().' '.get_phrase("Courses").'</td>';
        $html .= '<td><div class="dAdmin_info_name min-w-150px"><p>'.($row->created_at ? $row->created_at->format("d M Y, h:i A") : "-").'</p></div></td>';
        $html .= '<td><div class="form-check form-switch"><input class="form-check-input changeStatus" type="checkbox" data-id="'.$row->id.'" '.($row->status==1?"checked":"").'></div></td>';
        $html .= '<td class="print-d-none">
                    <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                        <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fi-rr-menu-dots-vertical"></span>
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#studentModal'.$row->id.'"><i class="fi-rr-eye me-2"></i> '.get_phrase("View").'</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="'.route('admin.student.edit', $row->id).'"><i class="fi-rr-edit me-2"></i> '.get_phrase("Edit").'</a>
                            </li>
                            <li>
                                <a class="dropdown-item" onclick="confirmModal(\''.route('admin.student.delete', $row->id).'\')" href="javascript:void(0)"><i class="fi-rr-trash me-2"></i> '.get_phrase("Delete").'</a>
                            </li>
                        </ul>
                    </div>
                  </td>';
        $html .= '</tr>';
    }

    return response()->json(['html' => $html]);
}


    return view('admin.student.deleteduserindex', ['students' => $students]);
}

    

    public function student_create()
    {
        return view('admin.student.create_student');
    }
    public function student_edit($id = '')
    {
        $page_data['student'] = User::where('id', $id)->first();
        return view('admin.student.edit_student', $page_data);
    }
     public function student_store(Request $request, $id = '')
{
    $validated = $request->validate([
        'name'     => 'required|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'phone' => ['required', 'regex:/^\+[1-9]\d{6,14}$/', 'unique:users,phone'],
        'address'  => 'nullable|string|max:500',
        'country'  => 'required',
        'state'    => 'required',
        'city'     => 'required',
        'address'  => 'required|string|max:500',
        'zipcode'  => 'required|digits:6',
    ]);

    // Check if email already exists
    if(User::where('email', $request->email)->exists()) {
        return back()->withInput()->withErrors(['email' => 'This email is already registered.']);
    }

    if(get_settings('student_email_verification') != 1){
        $data['email_verified_at'] = now();
    }
    
    $full_address = [
    'country' => $request->country,
    'state'   => $request->state,
    'city'    => $request->city,
    'address' => $request->address,
    'zipcode' => $request->zipcode,
  ];
  
     
    
    $data['name']        = $request->name;
    $data['about']       = $request->about;
    $data['phone']       = $request->phone;
    $data['address']     = $request->address;
    $data['full_address'] = json_encode($full_address);
    $data['email']       = $request->email;
    $data['facebook']    = $request->facebook;
    $data['twitter']     = $request->twitter;
    $data['website']     = $request->website;
    $data['linkedin']    = $request->linkedin;
    $data['paymentkeys'] = json_encode($request->paymentkeys);
    $data['status']     = '1';
    $data['password']   = Hash::make($request->password);
    $data['role']       = 'student';

    if ($request->hasFile('photo')) {
        $path = "uploads/users/student/" . nice_file_name($request->name, $request->photo->extension());
        FileUploader::upload($request->photo, $path, 400, null, 200, 200);
        $data['photo'] = $path;
    }

    $user = User::create($data);

    if(get_settings('student_email_verification') == 1) {
        $user->sendEmailVerificationNotification();
    }

    Session::flash('success', get_phrase('Student added successfully'));

    return redirect()->route('admin.student.index');
}

    public function student_update(Request $request, $id = '')
    {
        
        
        $validated = $request->validate([
            'name'  => 'required|max:255',
            'email' => "required|email|unique:users,email,$id",
            'phone' => ['required', 'regex:/^\+[1-9]\d{6,14}$/', "unique:users,phone,$id"],
            'password'  => 'nullable',
            'address' => 'required|string|max:500',
            'city'    => 'required|integer|exists:cities,id',
            'state'   => 'required|integer|exists:states,id',
            'country' => 'required|integer|exists:countries,id',
            'zipcode' => ['required', 'regex:/^[0-9]{6}$/'], // exactly 6 digits only
        ]);

        $data['name']        = $request->name;
        $data['about']       = $request->about;
        $data['phone']       = $request->phone;
        $data['address']     = $request->address;
        $data['full_address'] = json_encode([
            'address' => $request->address,
            'city'    => $request->city,
            'state'   => $request->state,
            'zipcode' => $request->zipcode,
            'country' => $request->country,
        ]);
        $data['email']       = $request->email;
        $data['facebook']    = $request->facebook;
        $data['twitter']     = $request->twitter;
        $data['website']     = $request->website;
        $data['linkedin']    = $request->linkedin;
        $data['paymentkeys'] = json_encode($request->paymentkeys);
        
         if (!empty($request->password)) {
             $data['password'] = Hash::make($request->password);
         }
        if (isset($request->photo) && $request->hasFile('photo')) {
            remove_file(User::where('id', $id)->first()->photo);
            $path = "uploads/users/student/" . nice_file_name($request->name, $request->photo->extension());
            FileUploader::upload($request->photo, $path, 400, null, 200, 200);
            $data['photo'] = $path;
        }

        User::where('id', $id)->update($data);
        Session::flash('success', get_phrase('Student update successfully'));
        return redirect()->route('admin.student.index');
    }
    
     public function changeStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status changed to ' . ($user->status ? 'Active' : 'Inactive'),
            'status'  => $user->status
        ]);
    }
    
    public function toggleVerify($id)
    {
        $student = User::findOrFail($id);
    
        if ($student->email_verified_at) {
            // Unverify
            $student->email_verified_at = null;
            $student->save();
            return back()->with('success', 'Email unverified successfully.');
        } else {
            // Verify manually
            $student->email_verified_at = now();
            $student->save();
            return back()->with('success', 'Email verified successfully.');
        }
    }
    

    public function student_delete($id)
    {
        $threads = MessageThread::where('contact_one', $id)
                    ->orWhere('contact_two', $id)
                    ->pluck('id');

        if ($threads->isNotEmpty()) {
            Message::whereIn('thread_id', $threads)->delete();
            MessageThread::whereIn('id', $threads)->delete();
        }

        $query = User::where('id', $id);
        remove_file($query->first()->photo);
        $query->delete();
        return redirect(route('admin.student.index'))->with('success', get_phrase('User deleted successfully'));
    }
    
    public function restore($id)
{
    $student = User::onlyTrashed()->findOrFail($id);
    $student->restore();
    return back()->with('success', 'Student restored successfully.');
}

public function forceDelete($id)
{
    $student = User::onlyTrashed()->findOrFail($id);
    $student->forceDelete();
    return back()->with('success', 'Student permanently deleted.');
}

    public function student_enrol()
    {
        return view('admin.enroll.course_enrollment');
    }
    public function student_get(Request $request)
    {

        $user = User::where('role', 'student')->where('name', 'LIKE', '%' . $request->searchVal . '%')->get();

        foreach ($user as $row) {
            $response[] = ['id' => $row->id, 'text' => $row->name];
        }
        return json_encode($response);
    }

    // public function student_post(Request $request)
    // {
    //     for ($i = 0; $i < count($request->user_id); $i++) {
    //         for ($j = 0; $j < count($request->course_id); $j++) {
    //             $data['user_id']    = $request->user_id[$i];
    //             $data['course_id']  = $request->course_id[$j];
    //             $data['entry_date'] = time();
    //             $user               = Enrollment::where('user_id', $request->user_id[$i])->where('course_id', $request->course_id[$j])->exists();
    //             $data['enroll_by_admin'] = 1;
    //             if (!$user) {

    //                 Enrollment::insert($data);
    //             }
    //         }
    //     }

    //     Session::flash('success', get_phrase('Student add successfully'));
    //     return redirect()->route('admin.enroll.history');
    // }
      public function student_post(Request $request)
    {

        $alreadyEnrolled = false;
        for ($i = 0; $i < count($request->user_id); $i++) {
            for ($j = 0; $j < count($request->course_id); $j++) {
                $data['user_id']    = $request->user_id[$i];
                $data['course_id']  = $request->course_id[$j];
                $data['batch_id']  = $request->batch_id;
                $data['entry_date'] = time();
                $data['enroll_by_admin'] = auth()->id();

                $course_details = $course_details = get_course_info($request->course_id[$j]);


                if ($course_details->expiry_period > 0) {
                    $days = $course_details->expiry_period * 30;
                    $data['expiry_date'] = strtotime("+" . $days . " days");
                } else {
                    $data['expiry_date'] = null;
                }

                $user               = Enrollment::where('user_id', $request->user_id[$i])->where('course_id', $request->course_id[$j])->exists();

                if ($user) {
                    Enrollment::where('user_id', $data['user_id'])->where('course_id', $data['course_id'])->update(['expiry_date' => $data['expiry_date']]);
                    $alreadyEnrolled = true;
                } else {
                    // dd($data);
                    Enrollment::insert($data);
                }
            }
        }

        if ($alreadyEnrolled) {
            Session::flash('warning', get_phrase('Student already enrolled in this course'));
        } else {
            Session::flash('success', get_phrase('Student add successfully'));
        }
        return redirect()->route('admin.enroll.history');
    }

    public function enroll_history(Request $request)
    {        
        // $query = User::where('role', 'student');
         $query = Enrollment::query();

    // 
    if ($request->filled('search')) {
        $search = $request->input('search');

        $query->where(function ($q) use ($search) {
            // Match user name/email
            $q->whereHas('users', function ($u) use ($search) {
                $u->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            // Match enrolled course title
            ->orWhereHas('course', function ($c) use ($search) {
                $c->where('title', 'like', "%{$search}%");
            })
            // Match Enrolled By name (admin)
            ->orWhereHas('admin', function ($a) use ($search) {
                $a->where('name', 'like', "%{$search}%");
            })
            // Match by enrolled date (if user enters a date)
            ->orWhere('entry_date', 'like', "%{$search}%");
        });
    }
        if ($request->eDateRange) {
            $date                        = explode('-', $request->eDateRange);
            $start_date                  = strtotime($date[0] . ' 00:00:00');
            $end_date                    = strtotime($date[1] . ' 23:59:59');
            $page_data['start_date']     = $start_date;
            $page_data['end_date']       = $end_date;
            $page_data['enroll_history'] = Enrollment::where('entry_date', '>=', $start_date)
                ->where('entry_date', '<=', $end_date)->orderBy('entry_date', 'desc')
                ->paginate(10)->appends($request->query());
        } else {
            $start_date                  = strtotime('first day of this month ');
            $end_date                    = strtotime('last day of this month');
            $page_data['start_date']     = $start_date;
            $page_data['end_date']       = $end_date;
            $page_data['enroll_history'] = Enrollment::where('entry_date', '>=', $start_date)
                ->where('entry_date', '<=', $end_date)->orderBy('entry_date', 'desc')->paginate(10);
        }
        
          $page_data['enroll_history'] = $query
        ->whereBetween('entry_date', [$start_date, $end_date])
        ->orderBy('entry_date', 'desc')
        ->paginate(10)
        ->appends($request->query());
        
        //dd($page_data);
        return view('admin.enroll.enroll_history', $page_data);
    }

    public function enroll_history_delete($id)
    {

        Enrollment::where('id', $id)->delete();
        Session::flash('success', get_phrase('Enroll delete successfully'));
        return redirect()->back();
    }

    public function manage_profile()
    {
        return view('admin.profile.index');
    }
    public function manage_profile_update(Request $request)
    {
        
        
        if ($request->type == 'general') {
            $profile['name']      = $request->name;
            $profile['email']     = $request->email;
            $profile['facebook']  = $request->facebook;
            $profile['linkedin']  = $request->linkedin;
            $profile['twitter']  = $request->twitter;
            $profile['about']     = $request->about;
            $profile['skills']    = $request->skills;
            $profile['biography'] = $request->biography;

            if ($request->photo) {
                if (isset($request->photo) && $request->photo != '') {
                    $profile['photo'] = "uploads/users/admin/" . nice_file_name($request->title, $request->photo->extension());
                    FileUploader::upload($request->photo, $profile['photo'], 400, null, 200, 200);
                }
            }
            User::where('id', auth()->user()->id)->update($profile);
        } else {
            $old_pass_check = Auth::attempt(['email' => auth()->user()->email, 'password' => $request->current_password]);

            if (!$old_pass_check) {
                Session::flash('error', get_phrase('Current password wrong.'));
                return redirect()->back();
            }
            
                 // trim and check if empty
                    $newPassword = trim($request->new_password);
                    $confirmPassword = trim($request->confirm_password);
                    if ($newPassword === '' || $confirmPassword === '') {
                    Session::flash('error', get_phrase('Password cannot be empty.'));
                    return redirect()->back();
                  }
    
                // Length check (must be exactly 8)
                if (strlen($newPassword) !== 8) {
                    Session::flash('error', get_phrase('Password must be exactly 8 characters.'));
                    return redirect()->back();
                }

            if ($request->new_password != $request->confirm_password) {
                Session::flash('error', get_phrase('Confirm password not same'));
                return redirect()->back();
            }

            $password = Hash::make($request->new_password);
            User::where('id', auth()->user()->id)->update(['password' => $password]);
        }
        Session::flash('success', get_phrase('Your changes has been saved.'));
        return redirect()->back();
    }
}
