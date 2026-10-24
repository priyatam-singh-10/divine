<?php

use App\Http\Controllers\CommonController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadPurchaseController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\frontend\BookController;
use App\Http\Controllers\ConsultingServiceController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\CourseReservationController;
//Cache clear route
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Cache::flush();

    return 'Application cache cleared';
});



// use Illuminate\Support\Facades\Mail;

// Route::get('/mail-test', function () {
//     try {
//         Mail::send([], [], function ($message) {
//             $message->to('nagarchiranji@gmail.com')
//                 ->from('testmail@divinetouch.info', 'Divine Touch')
//                 ->subject('Laravel Test Mail')
//                 ->html('<p>This is a test email from <strong>Divine Touch</strong>!</p>');
//         });

//         return '✅ Mail sent successfully. Check spam folder.';
//     } catch (\Exception $e) {
//         return '❌ Error: '.$e->getMessage();
//     }
// });




Route::get('home/switch/{id}', [HomeController::class, 'homepage_switcher'])->name('home.switch');

Route::post('/get-item-names', function (\Illuminate\Http\Request $request) {
    $reference = $request->input('reference');
    $itemIds = $request->input('items', []);

    if (!is_array($itemIds)) {
        return response()->json([]);
    }

    $table = $reference === 'book_purchase' ? 'books' :
             ($reference === 'course_purchase' ? 'courses' : null);

    if (!$table) {
        return response()->json([]);
    }

    $items = DB::table($table)
        ->whereIn('id', $itemIds)
        ->pluck('title', 'id');
dd(  $items );
    return response()->json($items);
});
Route::get('/get-states/{country}', function ($country) {
    return response()->json(
        DB::table('states')
            ->where('country_id', $country)
            ->select('id', 'name')
            ->get()
    );
})->name('get.states');

Route::get('/get-cities/{state}', function ($state) {
    return response()->json(
        DB::table('cities')
            ->where('state_id', $state)
            ->select('id', 'name')
            ->get()
    );
})->name('get.cities');


//Redirect route
Route::get('/dashboard', function () {
    if (auth()->user()->role == 'admin') {
        return redirect(route('admin.dashboard'));
    }elseif(auth()->user()->role == 'student'){
        return redirect(route('my.courses'));
    } else {
        return redirect(route('home'));
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/enquiry', [EnquiryController::class, 'store'])->name('enquiry.store');
//books
Route::get('/book/{slug}', [BookController::class, 'show'])->name('book.show');


// For admin panel
Route::get('/admin/enquiries', [EnquiryController::class, 'index'])->name('admin.enquiries');
//Common modal route
Route::get('modal/{view_path}', [ModalController::class, 'common_view_function'])->name('modal');
Route::any('get-video-details/{url?}', [CommonController::class, 'get_video_details'])->name('get.video.details');
Route::get('view/{path}', [CommonController::class, 'rendered_view'])->name('view');

Route::get('closed_back_to_mobile_ber', function () {
    session()->forget('app_url');
    return redirect()->back();
})->name('closed_back_to_mobile_ber');

//Installation routes
Route::controller(InstallController::class)->group(function () {
    Route::get('/install_ended', 'index');
    Route::get('install/step0', 'step0')->name('step0');
    Route::get('install/step1', 'step1')->name('step1');
    Route::get('install/step2', 'step2')->name('step2');
    Route::any('install/step3', 'step3')->name('step3');
    Route::get('install/step4', 'step4')->name('step4');
    Route::get('install/step4/{confirm_import}', 'confirmImport')->name('step4.confirm_import');
    Route::get('install/install', 'confirmInstall')->name('confirm_install');
    Route::post('install/validate', 'validatePurchaseCode')->name('install.validate');
    Route::any('install/finalizing_setup', 'finalizingSetup')->name('finalizing_setup');
    Route::get('install/success', 'success')->name('success');
});
//Installation routes

Route::get('/available-slots', [ConsultingServiceController::class, 'getAvailableSlots']);
Route::get('/available-dates', [ConsultingServiceController::class, 'getAvailableDates'])->name('available.dates');
Route::get('/hardcoded-slots', [ConsultingServiceController::class, 'getHardcodedSlots']);

Route::get('/countries', [HomeController::class, 'getCountries']);
Route::get('/states/{countryId}', [HomeController::class, 'getStates']);
Route::get('/cities/{stateId}', [HomeController::class, 'getCities']);


    Route::post('/cart/add', [ShopCartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [ShopCartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/{id}', [ShopCartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/cart/update-qty', [ShopCartController::class, 'updateQty'])->name('cart.updateQty');
    


Route::post('/razorpay/webhook', [ShopCartController::class, 'handleWebhook']);

// Add this to your routes/web.php file
Route::post('/contact/store', [ContactController::class, 'store'])->name('contact.store');
Route::get('/ai-wealth-creation-webinar', [HomeController::class, 'AiWealthWebinar'])->name('ai.wealth.webinar');
Route::get('/thank-you', [HomeController::class, 'Thankyou'])->name('webinar.thankyou');
Route::get('/ai-wealth-business-growth-accelerator', [HomeController::class, 'AiWealthBusiness'])->name('ai.wealth.business');


Route::get('/webinar-checkout', [HomeController::class, 'checkout2'])->name('checkout2');
Route::post('/save-lead', [LeadController::class, 'store'])->name('leads.store');
Route::post('/create-webinar-purchase-order', [LeadPurchaseController::class, 'createOrder'])->name('leads.order');
Route::post('/webinar-purchase/payment-success', [LeadPurchaseController::class, 'paymentSuccess'])->name('leads.payment.success');



