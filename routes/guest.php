<?php

use App\Http\Controllers\frontend\AboutController;
//use App\Http\Controllers\frontend\HypnosisController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\BootcampController;
use App\Http\Controllers\frontend\ServicesController;
use App\Http\Controllers\frontend\ContactController;
use App\Http\Controllers\frontend\CourseController;
use App\Http\Controllers\frontend\BookController;
use App\Http\Controllers\frontend\ShopController;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\InstructorController;
use App\Http\Controllers\frontend\NewsletterController;
use App\Http\Controllers\frontend\TeamTrainingController;
use App\Http\Controllers\frontend\TutorBookingController;
use App\Http\Controllers\CourseReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\CourseReservation;

use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/update_watch_history', 'update_watch_history_with_duration')->name('update_watch_history');
});

//session page
    Route::get('exam-2026', function () {
        return view('exam-2026');
        // return "Exam session page under construction!";
    })->name('exam-2026');
    
    
//session page
Route::get('exam-26', function () {
    return view('exam-26');
    // return "Exam session page under construction!";
})->name('exam-26');


//session page
Route::get('quantum-wealth-course
', function () {
    return view('quantum-wealth-course
');
    // return "Exam session page under construction!";
})->name('course-26');
  
   
   
   
    

 // coursereservations routes
// Form submit
Route::post('/reserve-seat', [CourseReservationController::class, 'store'])->name('reserve.seat');
Route::post('/reserve-seat/course', [CourseReservationController::class, 'storecourse'])->name('reserve.seat.course');
// Payment page
Route::get('/payment/{token}', [CourseReservationController::class, 'paymentPage'])->name('payment.page');
Route::get('/thankyou/{token}', [CourseReservationController::class, 'thankyou_course'])->name('thankyou.page');

Route::get('/thank-you', function (Request $request) {

    $reservation = CourseReservation::where(
        'payment_order_id',
        $request->order_id
    )->firstOrFail();
    
        // dd($reservation);
    $reservation->update([
        'payment_status'          => 'SUCCESS',
        'payment_transaction_id'  => $request->payment_id
    ]);

    /* =========================
       SEND CONFIRMATION EMAIL
       ========================= */

    $user = (object) [
        'email' => $reservation->student_email
    ];

    $subject = "✅ Registration Confirmed – Divine Touch Session";

    $message = "
        <h2>Dear {$reservation->student_name},</h2>

        <p>Thank you for registering for the <strong>Quantum-Wealth</strong>.</p>

        <h4>📌 Registration Details</h4>
        <ul>
             <li><strong>Type:</strong> {$reservation->type}</li>
            <li><strong>Name:</strong> {$reservation->student_name}</li>
            <li><strong>Type:</strong> {$reservation->type}</li>
            <li><strong>Father's Name:</strong> {$reservation->father_name}</li>
            <li><strong>Mobile:</strong> {$reservation->mobile_no}</li>
            <li><strong>City:</strong> {$reservation->city}</li>
            <li><strong>Target Exam:</strong> {$reservation->target_exam}</li>
            <li><strong>Amount Paid:</strong> ₹{$reservation->payment_amount}</li>
            <li><strong>Transaction ID:</strong> {$reservation->payment_transaction_id}</li>
        </ul>

        <p>🧘‍♂️ Our team will contact you shortly with session details.</p>

        <br>
        <p><strong>Divine Touch Wellness</strong><br>
        Kota, Rajasthan</p>
    ";
    
     
    Mail::send([], [], function ($mail) use ($user, $subject, $message) {
        $mail->to($user->email)
             ->subject($subject)
             ->html($message);
    });

    return view('quantum-wealth-thank-you');
});

Route::get('/payment-success', function (Request $request) {

    $reservation = CourseReservation::where(
        'payment_order_id',
        $request->order_id
    )->firstOrFail();
    
        // dd($reservation);
    $reservation->update([
        'payment_status'          => 'SUCCESS',
        'payment_transaction_id'  => $request->payment_id
    ]);

    /* =========================
       SEND CONFIRMATION EMAIL
       ========================= */

    $user = (object) [
        'email' => $reservation->student_email
    ];

    $subject = "✅ Registration Confirmed – Divine Touch Session";

    $message = "
        <h2>Dear {$reservation->student_name},</h2>

        <p>Thank you for registering for the <strong>Student Empowerment</strong>.</p>

        <h4>📌 Registration Details</h4>
        <ul>
             <li><strong>Type:</strong> {$reservation->type}</li>
            <li><strong>Name:</strong> {$reservation->student_name}</li>
            <li><strong>Type:</strong> {$reservation->type}</li>
            <li><strong>Father's Name:</strong> {$reservation->father_name}</li>
            <li><strong>Mobile:</strong> {$reservation->mobile_no}</li>
            <li><strong>City:</strong> {$reservation->city}</li>
            <li><strong>Target Exam:</strong> {$reservation->target_exam}</li>
            <li><strong>Amount Paid:</strong> ₹{$reservation->payment_amount}</li>
            <li><strong>Transaction ID:</strong> {$reservation->payment_transaction_id}</li>
        </ul>

        <p>🧘‍♂️ Our team will contact you shortly with session details.</p>

        <br>
        <p><strong>Divine Touch Wellness</strong><br>
        Kota, Rajasthan</p>
    ";
    
     
    Mail::send([], [], function ($mail) use ($user, $subject, $message) {
        $mail->to($user->email)
             ->subject($subject)
             ->html($message);
    });

    return view('frontend.default.payment.success');
});
// coursereservations routes    
// services pages
Route::controller(ServicesController::class)->group(function () {
    Route::get('/hypnosis', 'hypnosis')->name('services.hypnosis');
    Route::get('/reiki', 'reiki')->name('services.reiki');
    Route::get('/healing', 'healing')->name('services.healing');
    Route::get('/nlp', 'nlp')->name('services.nlp');
    Route::get('/yoga', 'yoga')->name('services.yoga');
});

// course page
Route::controller(CourseController::class)->group(function () {
    Route::get('courses/{category?}', 'index')->name('courses');
    Route::get('change/layout', 'change_layout')->name('change.layout');
    Route::get('course/{slug}', 'course_details')->name('course.details');
});

// books page
// Route::controller(BookController::class)->middleware('book.visibility')->group(function () {
//     Route::get('books/{category?}', 'index')->name('books');
//     Route::get('book/{slug?}', 'book_details')->name('book.details');
//     Route::get('books-list/{id}', 'book_by_category')->name('book.by.category');
// });

// books page
Route::controller(BookController::class)->group(function () {
    Route::get('books/', 'index')->name('books');
    Route::get('books/{id}', 'details')->name('books.details');
});

// blogs page
Route::controller(BlogController::class)->middleware('blog.visibility')->group(function () {
    Route::get('blogs/{category?}', 'index')->name('blogs');
    Route::get('blog/{slug?}', 'blog_details')->name('blog.details');
    Route::get('blogs-list/{id}', 'blog_by_category')->name('blog.by.category');
});


// shop pages
Route::controller(ShopController::class)->group(function () {
    Route::get('/shop', 'shop')->name('shop');
    Route::get('/shop/detail', 'detail')->name('shop.detail');
});



// newsletter
Route::controller(NewsletterController::class)->group(function () {
    Route::post('newsletter/store', 'store')->name('newsletter.store');
});

// contact us
Route::controller(ContactController::class)->group(function () {
    Route::get('contact-us/', 'index')->name('contact.us');
    Route::post('contact/', 'store')->name('contact.store');
});

// about us
Route::controller(AboutController::class)->group(function () {
    Route::get('about-us/', 'index')->name('about.us');
});

// coming soon
Route::get('/coming-soon', function () {
    return view('errors.coming-soon');
})->name('coming.soon');


// // Hypnosis
// Route::controller(HypnosisController::class)->group(function () {
//     Route::get('hypnosis/', 'index')->name('hypnosis');
// });


// instructor details
Route::controller(InstructorController::class)->group(function () {
    Route::get('instructors', 'index')->name('instructors');
    Route::get('instructor-details/{name}/{id}', 'show')->name('instructor.details');
});

// privacy and policy
Route::get('/privacy-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.privacy_policy.index';
    return view($view_path);
})->name('privacy.policy');

// refund policy
Route::get('/refund-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.refund_policy.index';
    return view($view_path);
})->name('refund.policy');

//FAQ
Route::get('/faq', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.faq.index';
    return view($view_path);
})->name('faq');

// terms and condition
Route::get('/terms-and-condition', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.terms_and_condition.index';
    return view($view_path);
})->name('terms.condition');

Route::get('/cookie-policy', function () {
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.cookie_policy.index';
    return view($view_path);
})->name('cookie.policy');

//Bootcamp
Route::controller(BootcampController::class)->group(function () {
    Route::get('webinar', 'index')->name('webinars');
    Route::get('webinar/{slug}', 'show')->name('webinar.details');
});

// team training
Route::controller(TeamTrainingController::class)->group(function () {
    Route::get('team-packages/{course_category?}', 'index')->name('team.packages');
    Route::get('team-package/{slug}', 'show')->name('team.package.details');
});

// tutor booking
Route::controller(TutorBookingController::class)->group(function () {
    Route::get('tutors', 'index')->name('tutor_list');
    Route::get('tutor-schedule/{id}/{user}', 'tutor_schedule')->name('tutor_schedule');
    Route::get('tutor-schedule/{date}', 'getSchedulesForDate')->name('tutor.getSchedulesForDate');
    Route::get('tutor-schedule-by-calender-date/{date}', 'getSchedulesByCalenderDate')->name('tutor.getSchedulesByCalenderDate');
});