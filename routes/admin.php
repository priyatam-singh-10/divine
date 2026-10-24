<?php

use App\Http\Controllers\Admin\BootcampCategoryController;
use App\Http\Controllers\Admin\BootcampController;
use App\Http\Controllers\Admin\BootcampLiveClassController;
use App\Http\Controllers\Admin\BootcampModuleController;
use App\Http\Controllers\Admin\BootcampResourceController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\OfflinePaymentController;
use App\Http\Controllers\Admin\OpenAiController;
use App\Http\Controllers\Admin\PageBuilderController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\TeamTrainingController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\AiWealthInquiryController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\frontend\LanguageController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\LiveClassController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SeoController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Updater;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Admin\TutorBookingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ConsultingServiceController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopCartController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CourseReservationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

Route::name('admin.')->prefix('admin')->middleware('admin')->group(function () {

    //dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('phpinfo', function(){
        phpinfo();
    });
    
   Route::get('link-enroll/purchase-history', [DashboardController::class, 'link_enrolls'])
    ->name('link-enroll.purchasehistory');
   Route::post('/update-purchase-link',[DashboardController::class,'updatePurchaseLink'])
   ->name('update.purchase.link');
    #reseravations seats 
     Route::get('/reservations', [CourseReservationController::class, 'index'])->name('reservations');
    //###
    //Enquiry
    Route::get('/admin/enquiries', [EnquiryController::class, 'index'])->name('enquiries');
    Route::get('/admin/enquiry/delete/{id}', [EnquiryController::class, 'destroy'])->name('enquiry.delete');
    Route::post('/enquiries/reply/{id}', [EnquiryController::class, 'reply'])->name('enquiries.reply');
    
      //Product Shop 
     // Product Categories
    Route::get('/productcategories', [ProductCategoryController::class, 'index'])->name('productcategories.index');
    Route::get('/productcategories/create', [ProductCategoryController::class, 'create'])->name('productcategories.create');
    Route::post('/productcategories', [ProductCategoryController::class, 'store'])->name('productcategories.store');
    Route::get('/productcategories/{category}/edit', [ProductCategoryController::class, 'edit'])->name('productcategories.edit');
    Route::put('/productcategories/{category}', [ProductCategoryController::class, 'update'])->name('productcategories.update');
    Route::delete('/productcategories/{category}', [ProductCategoryController::class, 'destroy'])->name('productcategories.destroy');

    // Products (single controller, admin methods)
    Route::get('/products', [ProductController::class, 'adminIndex'])->name('products');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/delete/{id}', [ProductController::class, 'destroy'])->name('products.delete');
    
    
    //Books 
      Route::get('/books', [BookController::class, 'index'])->name('books');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books/store', [BookController::class, 'store'])->name('books.store');
    Route::get('/books/{id}/edit', [BookController::class, 'edit'])->name('books.edit');
    Route::put('/books/{id}/update', [BookController::class, 'update'])->name('books.update');
    Route::get('/books/{id}/delete', [BookController::class, 'destroy'])->name('books.delete');
    
    
    //Book Orders
    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders');
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
      Route::get('/orders/{id}/delete', [OrderController::class, 'destroy'])->name('orders.delete');
     Route::put('/orders/{id}/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/orders/{id}/update-payment-status', [OrderController::class, 'updatePaymentStatus'])->name('orders.updatePaymentStatus');
    Route::put('/orders/{id}/update-shipping-status', [OrderController::class, 'updateShippingStatus'])->name('orders.updateShippingStatus');
    
    
    //consulting service
    Route::get('/consultation-services', [ConsultingServiceController ::class, 'index'])->name('consultation-services');
    Route::put('consulting-services/{id}/update-status', [ConsultingServiceController::class, 'updateStatus'])->name('consulting-services.update-status');
    Route::put('consulting-services/{id}/reschedule', [ConsultingServiceController::class, 'reschedule'])->name('consulting-services.reschedule');
    Route::get('consulting-services/{id}/delete', [ConsultingServiceController::class, 'destroy'])->name('consulting-services.delete');
    
     //slots 
     Route::get('/consultation-services-slots', [ConsultingServiceController ::class, 'index_slots'])->name('consultation-services-slots');
     Route::get('/consultation-services-slots-create', [ConsultingServiceController ::class, 'slots_create'])->name('consultation-services-slots-create');
     Route::post('/consultation-services-slots-store', [ConsultingServiceController ::class, 'slots_store'])->name('consultation-services-slots-store');
     Route::get('/consultation-services-slots-edit/{id}', [ConsultingServiceController ::class, 'slots_edit'])->name('consultation-services-slots-edit');
     Route::PUT('/consultation-services-slots-update/{id}', [ConsultingServiceController ::class, 'slots_update'])->name('consultation-services-slots-update');
     Route::get('/consultation-services-slots-delete/{id}', [ConsultingServiceController ::class, 'slots_delete'])->name('consultation-services-slots-delete');
     
     
     Route::post('get-cart-item-details', [ShopCartController::class, 'getCartItemDetails'])
    ->name('get_cart_item_details');

    
     //###
    //Category
    Route::get('categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::post('category/update/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::get('category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

    //Courses
    Route::get('courses', [CourseController::class, 'index'])->name('courses');
    Route::get('course/create', [CourseController::class, 'create'])->name('course.create');
    Route::post('course/store', [CourseController::class, 'store'])->name('course.store');
    Route::any('course/edit/{id}', [CourseController::class, 'edit'])->name('course.edit');
    Route::post('course/update/{id}', [CourseController::class, 'update'])->name('course.update');
    Route::get('course/duplicate/{id}', [CourseController::class, 'duplicate'])->name('course.duplicate');
    Route::get('course/status/{type}/{id}', [CourseController::class, 'status'])->name('course.status');
    Route::get('course/delete/{id}', [CourseController::class, 'delete'])->name('course.delete');
    Route::get('course/draft/{id}', [CourseController::class, 'draft'])->name('course.draft');
    Route::post('course/approval/{id}', [CourseController::class, 'approval'])->name('course.approval');

    //invoice
    Route::get('invoice/{id?}', [InvoiceController::class, 'invoice'])->name('invoice');

    Route::controller(Updater::class)->middleware('auth', 'verified')->group(function () {

        Route::post('admin/addon/create', 'update')->name('addon.create');
        Route::post('admin/addon/update', 'update')->name('addon.update');
        Route::post('admin/product/update', 'update')->name('product.update');
    });

    //curriculum
    Route::controller(CurriculumController::class)->group(function () {

        //Section route
        Route::post('section', 'store')->name('section.store');
        Route::post('section/update', 'update')->name('section.update');
        Route::get('section/delete/{id}', 'delete')->name('section.delete');
        Route::post('section/sort', 'section_sort')->name('section.sort');

        // lesson route
        Route::post('lesson', 'lesson_store')->name('lesson.store');
        Route::post('lesson/edit', 'lesson_edit')->name('lesson.edit');
        Route::get('lesson/delete/{id}', 'lesson_delete')->name('lesson.delete');
        Route::post('lesson/sort', 'lesson_sort')->name('lesson.sort');
    });

    Route::controller(UsersController::class)->group(function () {

        //admins route
        Route::get('admins', 'admin_index')->name('admins.index');
        Route::get('admin/create', 'admin_create')->name('admins.create');
        Route::post('admin/store', 'admin_store')->name('admins.store');
        Route::get('admin/edit/{id}', 'admin_edit')->name('admins.edit');
        Route::post('admin/update/{id}', 'admin_update')->name('admins.update');
        Route::get('admin/delete/{id}', 'admin_delete')->name('admins.delete');

        Route::get('admin/permissions/{user_id}', 'admin_permission')->name('admins.permission');
        Route::any('admin/permissions/store/{user_id?}', 'admin_permission_store')->name('admins.permission.store');

        //manage profile
        Route::get('manage_profile', 'manage_profile')->name('manage.profile');
        Route::post('manage_profile/update', 'manage_profile_update')->name('manage.profile.update');

        // Instructors route
        Route::get('instructor', 'instructor_index')->name('instructor.index');
        Route::get('instructor_create/{id?}', 'instructor_create')->name('instructor.create');
        Route::post('instructor/store/{id?}', 'instructor_store')->name('instructor.store');
        Route::get('instructor_edit/{id?}', 'instructor_edit')->name('instructor.edit');
        Route::post('instructor/update/{id}', 'instructor_update')->name('instructor.update');
        Route::get('instructor/delete/{id}', 'instructor_delete')->name('instructor.delete');
        Route::get('instructor/view_course', 'instructor_view_course')->name('instructor.course');
        Route::get('instructor_payout', 'instructor_payout')->name('instructor.payout');
        Route::get('instructor_payout/filter', 'instructor_payout_filter')->name('instructor.payout.filter');
        Route::get('instructor_payout/invoice/{id?}', 'instructor_payout_invoice')->name('instructor.payout.invoice');
        Route::post('instructor_payment', 'instructor_payment')->name('instructor.payment');
        Route::get('instructor_setting', 'instructor_setting')->name('instructor.setting');
        Route::post('instructor/setting/store', 'instructor_setting_store')->name('instructor.setting.store');
        Route::get('instructor_application', 'instructor_application')->name('instructor.application');
        Route::get('instructor_application/approve/{id}', 'instructor_application_approve')->name('instructor.application.approve');
        Route::get('instructor_application/delete/{id}', 'instructor_application_delete')->name('instructor.application.delete');
        Route::get('instructor_application/document/download/{id}', 'instructor_application_download')->name('instructor.application.download');

        // Student route
        Route::get('user', 'student_index')->name('student.index');
        Route::get('userdeleted', 'deleteduserindex')->name('student.deleteduserindex');

        Route::get('user/create', 'student_create')->name('student.create');
        Route::post('user/store/{id?}', 'student_store')->name('student.store');
        Route::get('user/edit/{id}', 'student_edit')->name('student.edit');
        Route::post('user/update/{id}', 'student_update')->name('student.update');
        Route::get('user/delete/{id}', 'student_delete')->name('student.delete');
        Route::post('student/status/{id}', 'changeStatus')->name('student.status');
        Route::get('student/{id}/toggle-verify','toggleVerify')->name('student.toggleVerify');
       
        Route::get('/restore/{id}', 'restore')->name('student.restore');
        Route::get('/force-delete/{id}', 'forceDelete')->name('student.forcedelete');
           

        
        
        Route::get('admin/create', 'admin_create')->name('admins.create');
        Route::post('admin/store', 'admin_store')->name('admins.store');

        // course enrolment route
        Route::get('enroll_history', 'enroll_history')->name('enroll.history');
        Route::get('enroll_history/delete/{id}', 'enroll_history_delete')->name('enroll.history.delete');
        Route::get('enroll_course', 'student_enrol')->name('student.enroll');
        Route::get('get/students', 'student_get')->name('student.get');
        Route::post('post/students', 'student_post')->name('student.post');
    });

    Route::controller(ReportController::class)->group(function () {

        // admin revenue
        Route::get('admin_revenue', 'admin_revenue')->name('revenue');
        Route::get('admin_revenue/delete/{id}', 'admin_revenue_delete')->name('revenue.delete');

        //instructor revenue
        Route::get('instructor_revenue', 'instructor_revenue')->name('instructor.revenue');
        Route::get('instructor_revenue/delete/{id}', 'instructor_revenue_delete')->name('instructor_revenue.delete');

        // purchase history
        Route::get('purchase_history', 'purchase_history')->name('purchase.history');
        Route::get('payment_history', 'payment_history')->name('payment.history');
        Route::get('purchase_history/invoice/{id?}', 'purchase_history_invoice')->name('purchase.history.invoice');
        Route::delete('/payments/{id}', 'destroy')->name('payments.destroy');
    });

    // newsletter
    Route::controller(NewsletterController::class)->group(function () {
        Route::get('newsletters', 'index')->name('newsletter');
        Route::post('newsletter/store', 'store')->name('newsletter.store');
        Route::get('newsletters/delete/{id}', 'delete')->name('newsletter.delete');
        Route::post('newsletter/update/{id}', 'update')->name('newsletter.update');

        Route::get('newsletter/subscribers', 'subscribers')->name('subscribed_user');
        Route::get('subscribed_user/delete/{id}', 'subscribed_user_delete')->name('subscribed_user.delete');
        Route::get('newsletters_form', 'newsletters_form')->name('newsletters.form');
        Route::get('get_user', 'get_user')->name('get.user');

        Route::post('send/newsletters', 'send_newsletters')->name('send.newsletters');
    });

    // blogs route
    Route::controller(BlogController::class)->group(function () {
        Route::get('blogs', 'index')->name('blogs');
        Route::get('blog/create', 'create')->name('blog.create');
        Route::post('blog/store', 'store')->name('blog.store');
        Route::get('blog/edit/{id}', 'edit')->name('blog.edit');
        Route::get('blog/delete/{id}', 'delete')->name('blog.delete');
        Route::post('blog/update/{id}', 'update')->name('blog.update');
        Route::get('blog/status/{id}', 'status')->name('blog.status');

        Route::get('blog/pending', 'pending')->name('blog.pending');
        Route::get('blog/settings', 'settings')->name('blog.settings');
        Route::post('blog/settings/update', 'update_settings')->name('blog.settings.update');
    });

    // blog categories route
    Route::controller(BlogCategoryController::class)->group(function () {
        Route::get('blog/category', 'index')->name('blog.category');
        Route::post('blog/category/create', 'create')->name('blog.category.create');
        Route::post('blog/category/store', 'store')->name('blog.category.store');
        Route::get('blog/category/delete/{id}', 'delete')->name('blog.category.delete');
        Route::post('blog/category/update/{id}', 'update')->name('blog.category.update');
    });
    
    // blog categories route
        Route::controller(LeadController::class)->group(function () {
            Route::get('leads', 'index')->name('leads.list');
            Route::get('leads/purchase', 'LeadPurchase')->name('leads.purchase');
    });

    Route::controller(AiWealthInquiryController::class)->group(function () {
        Route::get('ai-wealth-crm/inquiry', 'index')->name('ai-wealth-crm.inquiries');
        Route::post('ai-wealth-crm/inquiry/import', 'import')->name('ai-wealth-crm.inquiries.import');
        Route::post('ai-wealth-crm/inquiry/whatsapp', 'sendWhatsapp')->name('ai-wealth-crm.inquiries.whatsapp');
    });

    Route::controller(SettingController::class)->group(function () {

        // system settings
        Route::get('system_settings', 'system_settings')->name('system.settings');
        Route::post('system_settings/update', 'system_settings_update')->name('system.settings.update');

        //website settings
        Route::get('website_settings', 'website_settings')->name('website.settings');
        Route::post('website_settings/update', 'website_settings_update')->name('website.settings.update');

        //Drip content settings
        Route::get('drip_content_settings', 'drip_content_settings')->name('drip.settings');
        Route::post('drip_content_settings/update', 'drip_content_settings_update')->name('drip.settings.update');

        //payment settings
        Route::get('payment_settings', 'payment_settings')->name('payment.settings');
        Route::post('payment_settings/update', 'payment_settings_update')->name('payment.settings.update');

        // language settings
        Route::get('manage_language', 'manage_language')->name('manage.language');
        Route::post('language/store', 'language_store')->name('language.store');
        Route::post('language/direction/update', 'language_direction_update')->name('language.direction.update');
        Route::post('language/import', 'language_import')->name('language.import');
        Route::get('language/delete/{id}', 'language_delete')->name('language.delete');

        Route::get('language/phrase/edit/{lan_id}', 'edit_phrase')->name('language.phrase.edit');
        Route::post('language/phrase/update/{phrase_id?}', 'update_phrase')->name('language.phrase.update');
        Route::get('language/phrase/import/{lan_id}', 'phrase_import')->name('language.phrase.import');

        // Notification settings
        Route::get('notification_settings', 'notification_settings')->name('notification.settings');
        Route::any('notification_settings/store/{param1}/{id?}', 'notification_settings_store')->name('notification.settings.store');

        // player settings
        Route::get('player-settings', 'player_settings')->name('player.settings');
        Route::post('player-settings/update', 'player_settings_update')->name('player.settings.update');

        // About settings
        Route::get('about', 'about')->name('about');
        Route::any('admin/save_valid_purchase_code/{action_type?}', 'save_valid_purchase_code')->name('save_valid_purchase_code');

        // Certificate settings
        Route::get('certificate_settings', 'certificate')->name('certificate.settings');
        Route::post('certificate/update/template', 'certificate_update_template')->name('certificate.update.template');
        Route::get('certificate/builder', 'certificate_builder')->name('certificate.builder');
        Route::post('certificate/builder/update', 'certificate_builder_update')->name('certificate.certificate.builder.update');

        // Admin User Review Add
        Route::get('user/review', 'user_review_add')->name('review.create');
        Route::post('user/review/stor', 'user_review_stor')->name('review.store');
        Route::get('user/review/edit/{id}', 'review_edit')->name('review.edit');
        Route::post('user/review/update/{id}', 'review_update')->name('review.update');
        Route::get('user/review/delete/{id}', 'review_delete')->name('review.delete');

        // Home Page Dynamic Field
        Route::post('update/home/{id}', 'update_home')->name('update.home');
    });

    Route::controller(LiveClassController::class)->group(function () {
        Route::post('live-class/store/{course_id}', 'live_class_store')->name('live.class.store');
        Route::post('live-class/update/{id}', 'live_class_update')->name('live.class.update');
        Route::get('live-class/delete/{id}', 'live_class_delete')->name('live.class.delete');

        Route::get('live-class/start/{id}', 'live_class_start')->name('live.class.start');

        Route::get('live-class/settings', 'live_class_settings')->name('live.class.settings');
        Route::post('live-class/settings/update', 'update_live_class_settings')->name('live.class.settings.update');
    });

    Route::controller(OpenAiController::class)->group(function () {
        Route::get('open-ai/settings', 'settings')->name('open.ai.settings');
        Route::post('open-ai/settings/update', 'settings_update')->name('open.ai.settings.update');
        Route::post('open-ai/generate', 'generate')->name('open.ai.generate');
    });

    Route::controller(PageBuilderController::class)->group(function () {
        Route::get('pages', 'page_list')->name('pages');
        Route::get('page/create', 'page_create')->name('page.create');
        Route::post('page/store', 'page_store')->name('page.store');
        Route::get('page/edit/{id}', 'page_edit')->name('page.edit');
        Route::post('page/update/{id}', 'page_update')->name('page.update');
        Route::get('page/delete/{id}', 'page_delete')->name('page.delete');
        Route::get('page/status/{id}', 'page_status')->name('page.status');

        //return developer file content
        Route::any('page/all-builder-developer-file', 'developer_file_content')->name('page.all.builder.developer.file');

        Route::get('page/layout/edit/{id}', 'page_layout_edit')->name('page.layout.edit');
        Route::any('page/layout/update/{id}', 'page_layout_update')->name('page.layout.update');
        Route::post('page/layout/image/update', 'page_layout_image_update')->name('page.layout.image.update');
        Route::get('page/preview/{page_id}', 'preview')->name('page.preview');
    });

    Route::controller(ContactController::class)->group(function () {
        Route::any('contacts', 'index')->name('contacts');
        Route::post('reply', 'reply')->name('reply');
        Route::get('contact/delete/{id}', 'contact_delete')->name('contact.delete');
    });

    Route::controller(MessageController::class)->group(function () {
        Route::post('message/store', 'store')->name('message.store');
        Route::post('message/thread/store', 'thread_store')->name('message.thread.store');
        Route::get('message/{message_thread?}', 'message')->name('message');
    });

    Route::controller(SeoController::class)->group(function () {
        //seo settings
        Route::get('seo_settings/{route?}', 'seo_settings')->name('seo.settings');
        Route::post('seo_settings/update/{route}', 'seo_settings_update')->name('seo.settings.update');
    });

    //API Configurations
    Route::get('api/configurations', [SettingController::class, 'api_configurations'])->name('api.configurations');
    Route::post('api/configuration/update/{type}', [SettingController::class, 'api_configuration_update'])->name('api.configuration.update');

    // offline payment
    Route::controller(OfflinePaymentController::class)->group(function () {
        Route::get('offline-payments', 'index')->name('offline.payments');
        Route::get('offline-payment/doc/{id}', 'download_doc')->name('offline.payment.doc');
        Route::get('offline-payment/accept/{id}', 'accept_payment')->name('offline.payment.accept');
        Route::get('offline-payment/decline/{id}', 'decline_payment')->name('offline.payment.decline');
        Route::get('offline-payment/delete/{id}', 'delete_payment')->name('offline.payment.delete');
    });

    // coupon
    Route::controller(CouponController::class)->group(function () {
        Route::get('coupons', 'index')->name('coupons');
        Route::get('coupon/create', 'create')->name('coupon.create');
        Route::post('coupon/store', 'store')->name('coupon.store');
        Route::get('coupon/delete/{id}', 'delete')->name('coupon.delete');
        Route::get('coupon/edit/{id}', 'edit')->name('coupon.edit');
        Route::post('coupon/update/{id}', 'update')->name('coupon.update');
        Route::get('coupon/status/{id}', 'status')->name('coupon.status');
    });

    // course quiz
    Route::controller(QuizController::class)->group(function () {
        Route::post('course/quiz/store', 'store')->name('course.quiz.store');
        Route::get('course/quiz/delete/{id}', 'delete')->name('course.quiz.delete');
        Route::post('course/quiz/update/{id}', 'update')->name('course.quiz.update');
        Route::get('quiz/participant/result', 'result')->name('quiz.participant.result');
        Route::get('quiz/result/preview', 'result_preview')->name('quiz.result.preview');
    });

    // question route
    Route::controller(QuestionController::class)->group(function () {
        Route::post('course/question/store', 'store')->name('course.question.store');
        Route::get('course/question/delete/{id}', 'delete')->name('course.question.delete');
        Route::post('course/question/update/{id}', 'update')->name('course.question.update');
        Route::get('course/question/sort/', 'sort')->name('course.question.sort');

        Route::get('load/question/type/', 'load_type')->name('load.question.type');
    });

    // bootcamp category
    Route::controller(BootcampCategoryController::class)->group(function () {
        Route::get('webinar/categories', 'index')->name('webinar.categories');
        Route::post('webinar/category/store', 'store')->name('webinar.category.store');
        Route::get('webinar/category/delete/{id}', 'delete')->name('webinar.category.delete');
        Route::post('webinar/category/update/{id}', 'update')->name('webinar.category.update');
    });

    // bootcamp
    Route::controller(BootcampController::class)->group(function () {
        Route::get('webinars/{type?}', 'index')->name('webinars');
        Route::get('webinar/create', 'create')->name('webinar.create');
        Route::get('webinar/edit/{id}', 'edit')->name('webinar.edit');
        Route::post('webinar/store', 'store')->name('webinar.store');
        Route::get('webinar/delete/{id}', 'delete')->name('webinar.delete');
        Route::post('webinar/update/{id}', 'update')->name('webinar.update');
        Route::get('webinar/status/{id}', 'status')->name('webinar.status');
        Route::get('webinar/duplicate/{id}', 'duplicate')->name('webinar.duplicate');
        Route::get('webinar/purchase/history', 'purchase_history')->name('webinar.purchase.history');
        Route::get('webinar/purchase/invoice/{id}', 'invoice')->name('webinar.purchase.invoice');
    });

    // bootcamp module
    Route::controller(BootcampModuleController::class)->group(function () {
        Route::post('webinar/module/store', 'store')->name('webinar.module.store');
        Route::get('webinar/module/delete/{id}', 'delete')->name('webinar.module.delete');
        Route::post('webinar/module/update/{id}', 'update')->name('webinar.module.update');
        Route::get('webinar/module/sort', 'sort')->name('webinar.module.sort');
    });

    // bootcamp live class
    Route::controller(BootcampLiveClassController::class)->group(function () {
        Route::post('webinar/live-class/store', 'store')->name('webinar.live.class.store');
        Route::get('webinar/live-class/delete/{id}', 'delete')->name('webinar.live.class.delete');
        Route::post('webinar/live-class/update/{id}', 'update')->name('webinar.live.class.update');
        Route::get('webinar/live-class/sort', 'sort')->name('webinar.live.class.sort');

        Route::get('webinar/live/class/join/{topic}', 'join_class')->name('webinar.live.class.join');
        Route::get('webinar/live/class/end/{id}', 'stop_class')->name('webinar.class.end');
        Route::get('update/on/class/end/', 'update_on_end_class')->name('update.on.end.class');
    });
    
 // batch enrollments
Route::resource('batch', BatchController::class);

Route::post('batch/enroll-student', [BatchController::class, 'enrollStudent'])
    ->name('batch.enroll.student');

Route::get('get-batches', [BatchController::class, 'getBatches'])
    ->name('get.batches');
    // bootcamp resource
    Route::controller(BootcampResourceController::class)->group(function () {
        Route::post('webinar/resource/store', 'store')->name('webinar.resource.store');
        Route::get('webinar/resource/delete/{id}', 'delete')->name('webinar.resource.delete');
        Route::get('webinar/resource/download/{id}', 'download')->name('webinar.resource.download');
    });

    // team training
    Route::controller(TeamTrainingController::class)->group(function () {
        Route::get('team-packages', 'index')->name('team.packages');
        Route::view('team-packages/create', 'admin.team_training.create')->name('team.packages.create');
        Route::post('team-packages/store', 'store')->name('team.packages.store');
        Route::get('team-packages/purchase/history', 'purchase_history')->name('team.packages.purchase.history');

        Route::middleware(['record.exists:team_training_packages,id,user_id'])->group(function () {
            Route::get('team-packages/edit/{id}', 'edit')->name('team.packages.edit');
            Route::post('team-packages/update/{id}', 'update')->name('team.packages.update');
            Route::get('team-packages/delete/{id}', 'delete')->name('team.packages.delete');
            Route::get('team-packages/duplicate/{id}', 'duplicate')->name('team.packages.duplicate');
            Route::get('team-packages/toggle-status/{id}', 'toggle_status')->name('team.toggle.status');
            Route::get('team-packages/purchase/invoice/{id}', 'invoice')->name('team.packages.purchase.invoice');
        });

        Route::get('get-courses-by-privacy/', 'get_courses')->name('get.courses.by.privacy');
        Route::get('get-courses-price/', 'get_course_price')->name('get.course.price');
    });

    // tutor booking
    Route::controller(TutorBookingController::class)->group(function () {

        // subjects route
        Route::get('tutor-booking/subjects', 'subjects')->name('tutor_subjects');
        Route::get('tutor-booking/subject/create', 'tutor_subject_create')->name('tutor_subject_create');
        Route::post('tutor-booking/subject/store', 'tutor_subject_store')->name('tutor_subject_store');
        Route::get('tutor-booking/subject/edit', 'tutor_subject_edit')->name('tutor_subject_edit');
        Route::post('tutor-booking/subject/update/{id}', 'tutor_subject_update')->name('tutor_subject_update');
        Route::get('tutor-booking/subject/subject-status-update/{id}/{status}', 'tutor_subject_status')->name('tutor_subject_status');
        Route::get('tutor-booking/subject/delete/{id}', 'tutor_subject_delete')->name('tutor_subject_delete');

        //category route
        Route::get('tutor-booking/tutor-categories', 'tutor_categories')->name('tutor_categories');
        Route::get('tutor-booking/category/create', 'tutor_category_create')->name('tutor_category_create');
        Route::post('tutor-booking/category/store', 'tutor_category_store')->name('tutor_category_store');
        Route::get('tutor-booking/category/edit', 'tutor_category_edit')->name('tutor_category_edit');
        Route::post('tutor-booking/category/update/{id}', 'tutor_category_update')->name('tutor_category_update');
        Route::get('tutor-booking/category/category-status-update/{id}/{status}', 'tutor_category_status')->name('tutor_category_status');
        Route::get('tutor-booking/category/delete/{id}', 'tutor_category_delete')->name('tutor_category_delete');

    });

    Route::get('select-language/{language}', [LanguageController::class, 'select_lng'])->name('select.language');
});
