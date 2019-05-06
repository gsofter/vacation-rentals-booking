<?php
 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// -----------------------------------------
Route::post('/pusher/webhook/{event}', 'Front\PusherController@webhook');
Route::post('/getMail', 'Api\PostController@sendcontactinformation');
Route::get('/ImageFix/{from}/{to}', function($from, $to){
    $photos = App\Models\Front\RoomsPhotos::where('name' ,'like' ,'% %')->where('room_id' ,'>=' ,$from)->where('room_id' ,'<=' ,$to)->get()->pluck('id')->toArray();
    return view('imagefix',compact('photos'));
});
Route::get('/allImageUpload', function(){
    $photos = App\Models\Front\RoomsPhotos::where('storage', 'local')->where('room_id' ,'<' ,10300)->get()->pluck('id')->toArray();
    return view('imageupload',compact('photos'));
});
Route::get('/allImageUpload/{from}/{to}', function($from, $to){
    $photos = App\Models\Front\RoomsPhotos::where('storage', 'local')->where('room_id' ,'>=' ,$from)->where('room_id' ,'<=' ,$to)->get()->pluck('id')->toArray();
    return view('imageupload',compact('photos'));
});
Route::post('/ImageUploadToCloudinary', 'UploadController@allImageUpload');
Route::post('/ImageFix', 'UploadController@ImageFix');
Route::get('/configtesting',function(){
    dd(Auth::user()->profile_picture->src);
    // echo env('FB_CLIENT_SECRET').'\n';
    echo env('STRIPE_SECRET').'\n';
    exit;
});
Route::get('/verify-user/{id}', 'Auth\RegisterController@activateUser')->name('activate.user');
Route::get('/images/users/{user_id}/{file_name}', function($user_id, $file_name){
    $path = public_path('') . '/images/users/'.$user_id.'/' . $file_name;
    if(!File::exists($path)) {
        $user = App\Models\Front\User::find($user_id);
        if($user->gender == 'Male'){
            // $path = '/user_pic-225x225.png';
        }
        else{
            // $path = 'https://images.vexels.com/media/users/3/129677/isolated/preview/cad2cddbbee48118f17cf866279ccfd4-businesswoman-avatar-silhouette-by-vexels.png';
        }
        $path = public_path('') . '/images/user_pic-225x225.png';
        // $path = 'https://ui-avatars.com/api/?name=' . $user->full_name;
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response; // return 'http://www.ihps.si/wp-content/themes/ihps/images/my-placeholder.png';
});
Route::get('/images/pages/{file_name}', function($file_name){
    // dd($file_name);
    $path = public_path('') . '/images/pages/' . $file_name;
    if(!File::exists($path)) {
        $path = public_path('') . '/images/booking_1.jpg';
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response; // return 'http://www.ihps.si/wp-content/themes/ihps/images/my-placeholder.png';
});
Route::get('/images/rooms/{user_id}/{file_name}', function($user_id, $file_name){
    // dd($file_name);
    $path = public_path('') . '/images/rooms/'.$user_id.'/' . $file_name;
    if(!File::exists($path)) {
        $path = public_path('') . '/images/placeholder.png';
    }
    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response; // return 'http://www.ihps.si/wp-content/themes/ihps/images/my-placeholder.png';
});
/* ==============Admin Route ====================*/
// Admin Panel Routes
Route::prefix('admin')->group(function() {

    Route::get('/', function(){return Redirect::to('admin/dashboard');})->name('admin.index');

    /* Admin Login Routes */
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');

    /* Admin Dashboard Routes */
    Route::get('/dashboard', 'Admin\AdminController@index')->name('admin.dashboard');

    /* Admin Users Management Routes */
    Route::get('/admin_users', 'Admin\AdminusersController@users')->name('admin.admin.users');    
    Route::match(array('GET', 'POST'), '/add_admin_user', 'Admin\AdminusersController@add');
    Route::match(array('GET', 'POST'), '/edit_admin_user/{id}', 'Admin\AdminusersController@update')->where('id', '[0-9]+');
    Route::post('/delete_admin_user', 'Admin\AdminusersController@delete');

    /* Admin Users Roles Management Routes */    
    Route::get('/admin_roles', 'Admin\AdminusersController@roles')->name('admin.admin.roles');
    Route::match(array('GET', 'POST'), '/add_admin_role', 'Admin\AdminusersController@addRole');
    Route::match(array('GET', 'POST'), '/edit_admin_role/{id}', 'Admin\AdminusersController@updateRole')->where('id', '[0-9]+');
    Route::post('/delete_admin_role', 'Admin\AdminusersController@deleteRole');
    
    /* Users  Management Routes */    
    Route::get('/users', 'Admin\UsersController@users')->name('admin.users');
    Route::match(array('GET', 'POST'), '/add_user', 'Admin\UsersController@add');
    Route::match(array('GET', 'POST'), '/edit_user/{id}', 'Admin\UsersController@update')->where('id', '[0-9]+');
    Route::post('/delete_user', 'Admin\UsersController@delete');

    /* Properties  Management Routes */    
    Route::get('/rooms', 'Admin\RoomsController@rooms')->name('admin.rooms');
    Route::match(array('GET', 'POST'), '/add_room', 'Admin\RoomsController@add');
    Route::match(array('GET', 'POST'), '/edit_room/{id}', 'Admin\RoomsController@update')->where('id', '[0-9]+');
    Route::post('/delete_room', 'Admin\RoomsController@room_delete');    
    Route::match(array('GET', 'POST'), '/publish_room/{id}', 'Admin\RoomsController@publish')->where('id', '[0-9]+');
    Route::match(array('GET', 'POST'), '/popular_room/{id}', 'Admin\RoomsController@popular')->where('id', '[0-9]+');
    Route::match(array('GET', 'POST'), '/recommended_room/{id}', 'Admin\RoomsController@recommended')->where('id', '[0-9]+');

    /* Properties Tags  Management Properties */    
    Route::get('/rooms/tags', 'Admin\RoomTagController@index')->name('admin.rooms_tags');
    Route::match(array('GET', 'POST'), '/add_room_tag', 'Admin\RoomTagController@add');
    Route::match(array('GET', 'POST'), '/edit_room_tag/{id}', 'Admin\RoomTagController@update')->where('id', '[0-9]+');
    Route::post('/delete_room_tag', 'Admin\RoomTagController@delete');

    /* Reservations  Management Routes */
    Route::get('/reservations', 'Admin\ReservationsController@index')->name('admin.reservations');
    Route::get('/reservation/detail/{id}', 'Admin\ReservationsController@detail')->where('id', '[0-9]+');
    Route::get('/reservation/conversation/{id}', 'Admin\ReservationsController@conversation')->where('id', '[0-9]+');

    /* Email  Management Routes */
    Route::match(array('GET', 'POST'), '/send_email', 'Admin\EmailController@send_email')->name('admin.send_email');
    Route::match(array('GET', 'POST'), '/email_settings', 'Admin\EmailController@index')->name('admin.email_settings');

    /* Reviews  Management Routes */ 
    Route::match(array('GET', 'POST'), '/reviews', 'Admin\ReviewsController@reviews')->name('admin.reviews');
    Route::match(array('GET', 'POST'), '/edit_review/{id}', 'Admin\ReviewsController@update')->where('id', '[0-9]+');
    
    /* referrals  Management Routes */    
    Route::get('/referrals', 'Admin\ReferralsController@referrals')->name('admin.referrals');
    Route::get('/referrals_details/{id}', 'Admin\ReferralsController@details')->where('id', '[0-9]+')->name('admin.referrals.details');
    Route::match(array('GET', 'POST'), '/add_referral', 'Admin\ReferralsController@add');
    Route::match(array('GET', 'POST'), '/edit_referral/{id}', 'Admin\ReferralsController@update')->where('id', '[0-9]+');
    
    /* Wishlists  Management Routes */
	Route::get('/wishlists', 'Admin\WishlistController@wishlists')->name('admin.wishlists');
    Route::match(array('GET', 'POST'), '/pick_wishlist/{id}', 'Admin\WishlistController@pick')->where('id', '[0-9]+');
    
    /* CouponCode  Management Routes */
    Route::get('/coupon_code', 'Admin\CouponCodeController@coupon')->name('admin.coupon');
    Route::match(array('GET', 'POST'), '/add_coupon_code', 'Admin\CouponCodeController@add');
    Route::match(array('GET', 'POST'), '/edit_coupon_code/{id}', 'Admin\CouponCodeController@update')->where('id', '[0-9]+');
    Route::post('/delete_coupon_code', 'Admin\CouponCodeController@delete');

    /* Report  Management Routes */
    Route::match(['GET', 'POST'], '/reports', 'Admin\ReportsController@index')->name('admin.reports');
	Route::post('/reports/export/{from}/{to}/{category}', 'Admin\ReportsController@export');

    /* CouponCode  Management Routes */
    Route::get('/home_cities', 'Admin\HomeCitiesController@index')->name('admin.home_cities');
    Route::match(array('GET', 'POST'), '/add_home_city', 'Admin\HomeCitiesController@add');
    Route::match(array('GET', 'POST'), '/edit_home_city/{id}', 'Admin\HomeCitiesController@update')->where('id', '[0-9]+');
    Route::post('/delete_home_city', 'Admin\HomeCitiesController@delete');

    /* Homepage Image Slider  Management Routes */
    Route::get('/slider', 'Admin\SliderController@index')->name('admin.slider');
    Route::match(array('GET', 'POST'), '/add_slider', 'Admin\SliderController@add');
    Route::match(array('GET', 'POST'), '/edit_slider/{id}', 'Admin\SliderController@update')->where('id', '[0-9]+');
    Route::post('/delete_slider', 'Admin\SliderController@delete');

    /* Bottom Slider  Management Routes */
    Route::get('/bottom_slider', 'Admin\BottomSliderController@index')->name('admin.bottom_slider');
    Route::match(array('GET', 'POST'), '/add_bottom_slider', 'Admin\BottomSliderController@add');
    Route::match(array('GET', 'POST'), '/edit_bottom_slider/{id}', 'Admin\BottomSliderController@update')->where('id', '[0-9]+');
    Route::post('/delete_bottom_slider', 'Admin\BottomSliderController@delete')->where('id', '[0-9]+');

    /* Posts  Management Routes */
    Route::get('/posts', 'Admin\PostsController@index')->name('admin.posts');
    Route::match(array('GET', 'POST'), '/add_post', 'Admin\PostsController@add');
    Route::match(array('GET', 'POST'), '/edit_post/{id}', 'Admin\PostsController@update')->where('id', '[0-9]+');
    Route::post('/delete_post', 'Admin\PostsController@delete')->where('id', '[0-9]+');  

    /* Categories  Management Routes */
    Route::get('/categories', 'Admin\CategoriesController@index')->name('admin.categories');
    Route::match(array('GET', 'POST'), '/add_category', 'Admin\CategoriesController@add');
    Route::match(array('GET', 'POST'), '/edit_category/{id}', 'Admin\CategoriesController@update')->where('id', '[0-9]+');
    Route::post('/delete_category', 'Admin\CategoriesController@delete')->where('id', '[0-9]+');

    /* Tags  Management Routes */
    Route::get('/tags', 'Admin\TagsController@index')->name('admin.tags');
    Route::match(array('GET', 'POST'), '/add_tag', 'Admin\TagsController@add');
    Route::match(array('GET', 'POST'), '/edit_tag/{id}', 'Admin\TagsController@update')->where('id', '[0-9]+');
    Route::post('/delete_tag', 'Admin\TagsController@delete')->where('id', '[0-9]+');

    /* testimonials  Management Routes */
    Route::get('/testimonials', 'Admin\TestimonialsController@index')->name('admin.testimonials');
    Route::match(array('GET', 'POST'), '/add_testimonial', 'Admin\TestimonialsController@add');
    Route::match(array('GET', 'POST'), '/edit_testimonial/{id}', 'Admin\TestimonialsController@update')->where('id', '[0-9]+');
    Route::post('/delete_testimonial', 'Admin\TestimonialsController@delete')->where('id', '[0-9]+');

    /* Our Community Banners  Management Routes */
    Route::get('/our_community_banners', 'Admin\OurCommunityBannersController@index')->name('admin.our_community_banners');
    Route::match(array('GET', 'POST'), '/add_our_community_banners', 'Admin\OurCommunityBannersController@add');
    Route::match(array('GET', 'POST'), '/edit_our_community_banners/{id}', 'Admin\OurCommunityBannersController@update')->where('id', '[0-9]+');
    Route::post('/delete_our_community_banners', 'Admin\OurCommunityBannersController@delete')->where('id', '[0-9]+');

    /* Host Banners  Management Routes */
    Route::get('/host_banners', 'Admin\HostBannersController@index')->name('admin.host_banners');
    Route::match(array('GET', 'POST'), '/add_host_banners', 'Admin\HostBannersController@add');
    Route::match(array('GET', 'POST'), '/edit_host_banners/{id}', 'Admin\HostBannersController@update')->where('id', '[0-9]+');
    Route::post('/delete_host_banners', 'Admin\HostBannersController@delete')->where('id', '[0-9]+');
        
    /* Help  Management Routes */
    Route::get('/help', 'Admin\HelpController@index')->name('admin.help');
    Route::match(array('GET', 'POST'), '/add_help', 'Admin\HelpController@add');
    Route::match(array('GET', 'POST'), '/edit_help/{id}', 'Admin\HelpController@update')->where('id', '[0-9]+');
    Route::post('/delete_help', 'Admin\HelpController@delete')->where('id', '[0-9]+');

    /* Help Category Management Routes */
    Route::get('/help_category', 'Admin\HelpCategoryController@index')->name('admin.help_category');
    Route::match(array('GET', 'POST'), '/add_help_category', 'Admin\HelpCategoryController@add');
    Route::match(array('GET', 'POST'), '/edit_help_category/{id}', 'Admin\HelpCategoryController@update')->where('id', '[0-9]+');
    Route::post('/delete_help_category', 'Admin\HelpCategoryController@delete')->where('id', '[0-9]+');

    /* Help Subcategory Management Routes */
    Route::get('/help_subcategory', 'Admin\HelpSubCategoryController@index')->name('admin.help_subcategory');
    Route::match(array('GET', 'POST'), '/add_help_subcategory', 'Admin\HelpSubCategoryController@add');
    Route::match(array('GET', 'POST'), '/edit_help_subcategory/{id}', 'Admin\HelpSubCategoryController@update')->where('id', '[0-9]+');
    Route::post('/delete_help_subcategory', 'Admin\HelpSubCategoryController@delete')->where('id', '[0-9]+');
    Route::post('/ajax_help_subcategory/{id}', 'Admin\HelpController@ajax_help_subcategory')->where('id', '[0-9]+');

    /* Amenities Management Routes */
    Route::get('/amenities', 'Admin\AmenitiesController@index')->name('admin.amenities');
    Route::match(array('GET', 'POST'), '/add_amenity', 'Admin\AmenitiesController@add');
    Route::match(array('GET', 'POST'), '/edit_amenity/{id}', 'Admin\AmenitiesController@update')->where('id', '[0-9]+');
    Route::post('/delete_amenity', 'Admin\AmenitiesController@delete')->where('id', '[0-9]+');

    /* Amenities Type Management Routes */
    Route::get('/amenities_type', 'Admin\AmenitiesTypeController@index')->name('admin.amenities_type');
    Route::match(array('GET', 'POST'), '/add_amenities_type', 'Admin\AmenitiesTypeController@add');
    Route::match(array('GET', 'POST'), '/edit_amenities_type/{id}', 'Admin\AmenitiesTypeController@update')->where('id', '[0-9]+');
    Route::post('/delete_amenities_type', 'Admin\AmenitiesTypeController@delete')->where('id', '[0-9]+');
    
    /* Subscription Plan Management Routes */
    Route::get('/subscriptions_plan', 'Admin\SubscriptionController@plan_index')->name('admin.subscriptions_plan');
    Route::match(array('GET', 'POST'), '/add_subscription_plan', 'Admin\SubscriptionController@plan_add');
    Route::match(array('GET', 'POST'), '/edit_subscription_plan/{id}', 'Admin\SubscriptionController@plan_update')->where('id', '[0-9]+');
    Route::post('/delete_subscription_plan', 'Admin\SubscriptionController@plan_delete')->where('id', '[0-9]+');

    /* Subscription List Management Routes */
    Route::get('/subscriptions_free', 'Admin\SubscriptionController@free_index')->name('admin.subscriptions_free');  
    Route::match(array('GET', 'POST'), '/detail_subscription_free/{id}', 'Admin\SubscriptionController@free_detail')->where('id', '[0-9]+');

    /*Property manager Management Routes */
    Route::get('/property_manager', 'Admin\PropertyManagerController@index')->name('admin.property_manager');
	Route::match(array('GET', 'POST'), '/add_property_manager', 'Admin\PropertyManagerController@add');

    /*Property Type Management Routes */
    Route::get('/property_type', 'Admin\PropertyTypeController@index')->name('admin.property_type');
    Route::match(array('GET', 'POST'), '/add_property_type', 'Admin\PropertyTypeController@add');
    Route::match(array('GET', 'POST'), '/edit_property_type/{id}', 'Admin\PropertyTypeController@update')->where('id', '[0-9]+');
    Route::post('/delete_property_type', 'Admin\PropertyTypeController@delete')->where('id', '[0-9]+');

    /*Room Type Management Routes */
    Route::get('/room_type', 'Admin\RoomTypeController@index')->name('admin.room_type');
    Route::match(array('GET', 'POST'), '/add_room_type', 'Admin\RoomTypeController@add');
    Route::match(array('GET', 'POST'), '/edit_room_type/{id}', 'Admin\RoomTypeController@update')->where('id', '[0-9]+');
    Route::match(array('GET', 'POST'), '/status_check/{id}', 'Admin\RoomTypeController@chck_status')->where('id', '[0-9]+');
    Route::match(array('GET', 'POST'), '/bed_status_check/{id}', 'Admin\BedTypeController@chck_status')->where('id', '[0-9]+');
    Route::post('/delete_room_type', 'Admin\RoomTypeController@delete')->where('id', '[0-9]+');

    /*Bed Type Management Routes */
    Route::get('/bed_type', 'Admin\BedTypeController@index')->name('admin.bed_type');
    Route::match(array('GET', 'POST'), '/add_bed_type', 'Admin\BedTypeController@add');
    Route::match(array('GET', 'POST'), '/edit_bed_type/{id}', 'Admin\BedTypeController@update')->where('id', '[0-9]+');
    Route::post('/delete_bed_type', 'Admin\BedTypeController@delete')->where('id', '[0-9]+');

    /*Pages Management Routes */
    Route::get('/pages', 'Admin\PageController@index')->name('admin.pages');
    Route::match(array('GET', 'POST'), '/add_page', 'Admin\PageController@add');
    Route::match(array('GET', 'POST'), '/edit_page/{id}', 'Admin\PageController@update')->where('id', '[0-9]+');
    Route::post('/delete_page', 'Admin\PageController@delete')->where('id', '[0-9]+');

    /*Template Management Routes */
    Route::get('/templates', 'Admin\TemplateController@index')->name('admin.templates');
    Route::match(array('GET', 'POST'), '/add_template', 'Admin\TemplateController@add');
    Route::match(array('GET', 'POST'), '/edit_template/{id}', 'Admin\TemplateController@update')->where('id', '[0-9]+');
    Route::post('/delete_template', 'Admin\TemplateController@delete')->where('id', '[0-9]+');

    /*Currency Management Routes */
    Route::get('/currency', 'Admin\CurrencyController@index')->name('admin.currency');
    Route::match(array('GET', 'POST'), '/add_currency', 'Admin\CurrencyController@add');
    Route::match(array('GET', 'POST'), '/edit_currency/{id}', 'Admin\CurrencyController@update')->where('id', '[0-9]+');
    Route::post('/delete_currency', 'Admin\CurrencyController@delete')->where('id', '[0-9]+');
        
    /*Language Management Routes */
    Route::get('/language', 'Admin\LanguageController@index')->name('admin.language');
    Route::match(array('GET', 'POST'), '/add_language', 'Admin\LanguageController@add');
    Route::match(array('GET', 'POST'), '/edit_language/{id}', 'Admin\LanguageController@update')->where('id', '[0-9]+');
    Route::post('/delete_language', 'Admin\LanguageController@delete')->where('id', '[0-9]+');

    /*Country Management Routes */
    Route::get('/country', 'Admin\CountryController@index')->name('admin.country');
    Route::match(array('GET', 'POST'), '/add_country', 'Admin\CountryController@add');
    Route::match(array('GET', 'POST'), '/edit_country/{id}', 'Admin\CountryController@update')->where('id', '[0-9]+');
    Route::post('/delete_country', 'Admin\CountryController@delete')->where('id', '[0-9]+');

    /*Referral Settings  Management Routes */
    Route::match(array('GET', 'POST'), '/referral_settings', 'Admin\ReferralSettingsController@index')->name('admin.referral_settings');

    /*Discount  Management Routes */
    Route::match(array('GET', 'POST'), '/fees', 'Admin\FeesController@index')->name('admin.fees');

    /*Meta Management Routes */
    Route::get('/metas', 'Admin\MetasController@index')->name('admin.metas');
    Route::match(array('GET', 'POST'), '/add_meta', 'Admin\MetasController@add');
    Route::match(array('GET', 'POST'), '/edit_meta/{id}', 'Admin\MetasController@update')->where('id', '[0-9]+');
    Route::post('/delete_meta', 'Admin\MetasController@delete')->where('id', '[0-9]+');

    /*Api credentials  Management Routes */
    Route::match(array('GET', 'POST'), '/api_credentials', 'Admin\ApiCredentialsController@index')->name('admin.api_credentials');

    /*Payment Gateway  Management Routes */
    Route::match(array('GET', 'POST'), '/payment_gateway', 'Admin\PaymentGatewayController@index')->name('admin.payment_gateway');

    /*Join Us  Management Routes */
    Route::match(array('GET', 'POST'), '/join_us', 'Admin\JoinUsController@index')->name('admin.join_us');

    /*Theme Settings  Management Routes */
    Route::match(array('GET', 'POST'), '/theme_settings', 'Admin\ThemeSettingsController@index')->name('admin.theme_settings');

    /*Site Settings  Management Routes */
    Route::match(array('GET', 'POST'), '/site_settings', 'Admin\SiteSettingsController@index')->name('admin.site_settings');
});
Route::group(['middleware' => ['web']], function () {
    
    Route::post('/ajax/updateLoginStatus', 'HomeController@updateLoginStatus');

    Route::post('/ajax/login', 'Auth\LoginController@Login')->name('ajax.login');
    Route::post('/ajax/signup', 'Auth\RegisterController@register')->name('ajax.register');
    Route::post('/ajax/signupSocial', 'Auth\RegisterController@signupSocial')->name('ajax.signupSocial');
    Route::post('/ajax/helpSearch', 'Front\Help\HelpController@searchHelp')->name('ajax.helpsearch');
    Route::post('/ajax/getHelpListByCategory', 'Front\Help\HelpController@getHelpListByCategory')->name('ajax.getHelpListByCategory');
    Route::post('/ajax/getSubcategories', 'Front\Help\HelpController@getSubcategories')->name('ajax.getSubcategories');
    Route::post('/ajax/getQuestions', 'Front\Help\HelpController@getQuestions')->name('ajax.getQuestions');


    Route::post('/ajax/profilepictureupload', 'Front\DashboardController@profilepictureupload')->name('ajax.profilepictureupload');
    Route::post('/ajax/saveuserprofile', 'Front\DashboardController@saveuserprofile')->name('ajax.saveuserprofile');
    Route::post('/ajax/removeUserPhoneNumber', 'Front\DashboardController@removeUserPhoneNumber')->name('ajax.removeUserPhoneNumber');
    Route::post('/ajax/change_status_of_room', 'Front\RoomsController@changestatus')->name('ajax.changestatus');

    Route::get('/logout', 'Auth\LogoutController@logout')->name('logout');
    Route::get('/ajax/dashboard/index', 'Front\DashboardController@index')->name('logout');
    Route::get('/ajax/dashboard/getverifycation', 'Front\DashboardController@getverifycation')->name('logout');
    Route::post('/ajax/sendVerifyCode', 'Front\DashboardController@sendVerifyCode')->name('sendVerifyCode');
    Route::post('/ajax/verifyPhoneNumber', 'Front\DashboardController@verifyPhoneNumber')->name('verifyPhoneNumber');
    Route::get('/ajax/dashboard/getlistings', 'Front\RoomsController@index')->name('getlistings');
    Route::get('/ajax/dashboard/my_reservations', 'Front\ReservationController@my_reservations')->name('my_reservations');
    Route::post('/ajax/reservation/decline/{id}', 'Front\ReservationController@decline')->name('decline');
    Route::post('/ajax/reservation/accept/{id}', 'Front\ReservationController@accept')->name('accept');
    Route::post('/ajax/trips/cancel/{id}', 'Front\TripsController@guest_cancel_pending_reservation')->name('trips.guest_cancel_pending_reservation');





    Route::get('/ajax/dashboard/getUserList', 'Front\InboxController@getUserList')->name('getUserList');
    Route::get('/ajax/dashboard/getcurrentTripsList', 'Front\TripsController@current')->name('getcurrentTripsList');
    Route::get('/ajax/dashboard/getOldTripsList', 'Front\TripsController@previous')->name('getOldTripsList');
    Route::get('/ajax/dashboard/getmessages', 'Front\InboxController@getmessages')->name('getOldTripsList');

    // =======================Room Management Route
    Route::get('/ajax/rooms/new', 'Front\RoomsController@new_room')->name('get_new_room');
    Route::post('/ajax/rooms/create', 'Front\RoomsController@create');
    Route::get('/ajax/rooms/manage_listing/{id}/{page}', 'Front\RoomsController@manage_listing');
    Route::post('/ajax/rooms/saveOrUpdate_bedroom', 'Front\RoomsController@addupdatebedroom');
    Route::post('/ajax/rooms/saveOrUpdate_bathroom', 'Front\RoomsController@addupdatebathroom');
    Route::post('/ajax/rooms/delete_bedroom', 'Front\RoomsController@deletebedroom');
    Route::post('/ajax/rooms/delete_bathroom', 'Front\RoomsController@deletebathroom');
    Route::post('/ajax/rooms/manage-listing/{id}/lan_description', 'Front\RoomsController@lan_description');
    Route::post('/ajax/rooms/manage-listing/{id}/rooms_steps_status', 'Front\RoomsController@rooms_steps_status');
    Route::post('/ajax/rooms/manage-listing/{id}/add_description', 'Front\RoomsController@add_description');
    Route::post('/ajax/rooms/manage-listing/{id}/delete_language', 'Front\RoomsController@delete_language');
    Route::post('/ajax/rooms/manage-listing/{id}/get_all_language', 'Front\RoomsController@get_all_language');
    Route::post('/ajax/rooms/manage-listing/{id}/update_rooms', 'Front\RoomsController@update_rooms')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/update_description', 'Front\RoomsController@update_description')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/update_price', 'Front\RoomsController@update_price')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/get_additional_charges', 'Front\RoomsController@get_additional_charges')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/get_location', 'Front\RoomsController@get_location')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/get_amenities', 'Front\RoomsController@get_amenities')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/manage-listing/{id}/update_amenities', 'Front\RoomsController@update_amenities')->where('id', '[0-9]+');
    Route::match(['get', 'post'],'/ajax/rooms/manage-listing/update_additional_price', 'Front\RoomsController@update_additional_price');
    Route::match(['get', 'post'],'/ajax/rooms/manage-listing/get_last_min_rules', 'Front\RoomsController@get_last_min_rules');
    Route::post('/ajax/rooms/manage-listing/{id}/update_price_rules/{type}', 'Front\RoomsController@update_price_rules')->where('id', '[0-9]+');
    Route::post('/ajax/rooms/finish_address/{id}/{page}', 'Front\RoomsController@finish_address')
    ->where(['id' => '[0-9]+','page' => 'basics|description|location|amenities|photos|video|pricing|calendar|details|guidebook|terms|booking|plans']);
    Route::post('/ajax/rooms/add_photos/{id}', 'Front\RoomsController@add_photos')->where('id', '[0-9]+');
    Route::get('/ajax/manage-listing/{id}/photos_list', 'Front\RoomsController@photos_list')->where('id', '[0-9]+');
    Route::post('/ajax/manage-listing/featured_image', 'Front\RoomsController@featured_image');
    Route::post('/ajax/manage-listing/change_photo_order', 'Front\RoomsController@change_photo_order');
    Route::post('/ajax/manage-listing/photo_highlights', 'Front\RoomsController@photo_highlights');
    Route::post('/ajax/manage-listing/{id}/delete_photo', 'Front\RoomsController@delete_photo')->where('id', '[0-9]+');
    Route::get('/ajax/manage_listing/{id}/get_videoUrl', 'Front\RoomsController@get_videoUrl')->where('id', '[0-9]+');
    Route::get('/ajax/manage_listing/{id}/get_cancel_message', 'Front\RoomsController@get_cancel_message')->where('id', '[0-9]+');
    // ==============Calendar Route ======================

    Route::post('/ajax/rooms/manage-listing/{id}/check_season_name', 'Front\RoomsController@check_season_name');
    Route::post('/ajax/rooms/manage-listing/{id}/save_reservation', 'Front\CalendarController@save_reservation');
    Route::post('/ajax/rooms/manage-listing/{id}/{year}/{month}/get_calendar_data', 'Front\CalendarController@get_calendar_data');
    Route::post('/ajax/rooms/manage-listing/{id}/unavailable_calendar', 'Front\CalendarController@unavailable_calendar');
    Route::post('/ajax/rooms/manage-listing/{id}/seasonal_calendar', 'Front\CalendarController@seasonal_calendar');
    Route::post('/ajax/rooms/manage-listing/{id}/save_seasonal_price', 'Front\CalendarController@save_seasonal_price');
    Route::post('/ajax/rooms/manage-listing/{id}/delete_seasonal', 'Front\RoomsController@delete_seasonal');
    Route::post('/ajax/rooms/manage-listing/{id}/delete_reservation', 'Front\CalendarController@delete_reservation');
    Route::post('/ajax/rooms/manage-listing/{id}/delete_not_available_days', 'Front\CalendarController@delete_not_available_days');
    Route::post('/ajax/rooms/manage-listing/{id}/save_unavailable_dates', 'Front\CalendarController@save_unavailable_dates');
    Route::get('/calendar/ical/{id}', 'Front\CalendarController@ical_export');
    Route::get('/ajax/rooms/manage-listing/{id}/ical_delete', 'Front\CalendarController@ical_delete');
    Route::get('/ajax/rooms/manage-listing/{id}/ical_refresh', 'Front\CalendarController@ical_refresh');
    Route::post('/ajax/rooms/manage-listing/{id}/check_reservation_conflict_req', 'Front\RoomsController@check_reservation_conflict_req');

    Route::match(['get', 'post'],'/ajax/rooms/manage-listing/{id}/calendar_import', 'Front\CalendarController@ical_import')->where('id', '[0-9]+');




    // Room booking Route
    Route::post('/ajax/book/request/{id}', 'Front\RoomsController@roombooking')->name('rooms.booking');
    // ==============Home Page Route=================
    Route::get('/ajax/home/index', 'HomeController@index');
    // ==============Detail Page Route=================
    Route::get('/ajax/homes/{room_id}/unavailable_calendar', 'Front\RoomsController@unavailable_calendar');
    Route::get('/ajax/homes/review/{room_id}', 'Front\RoomsController@getRoomReviews');
    Route::get('/ajax/homes/similar/{room_id}', 'Front\RoomsController@getSimilarListings');
    Route::get('/ajax/homes/housetype/{room_id}', 'Front\RoomsController@getHouseType');
    Route::get('/ajax/homes/amenities_type/{room_id}', 'Front\RoomsController@get_amenities_type');
    Route::get('/ajax/homes/descriptions/{room_id}', 'Front\RoomsController@getRoomDescriptions');
    Route::get('/ajax/homes/seasonal_rate/{room_id}', 'Front\RoomsController@get_room_seasonal_rate');
    Route::get('/ajax/homes/photos/{room_id}', 'Front\RoomsController@getRoomPhotos');

    Route::get('/ajax/homes/{address_url}/{room_id}', 'Front\RoomsController@rooms_detail');
    Route::get('/ajax/homes/{room_id}', 'Front\RoomsController@rooms_short_detail');
    
    Route::post('/ajax/users/reviews', 'Front\ReviewController@store');
    Route::get('/ajax/wishlist_list', 'Front\WishlistController@wishlist_list')->name('wishlist.wishlist_list');
    Route::post('/ajax/wishlist_create', 'Front\WishlistController@create');
    Route::post('/ajax/save_wishlist', 'Front\WishlistController@save_wishlist');
    Route::post('/ajax/rooms/price_calculation', 'Front\RoomsController@price_calculation');
    // ==============Search Page Route ================
    Route::post('/ajax/searchIndex', 'Front\SearchController@index')->name('rooms.search');
    Route::post('/ajax/searchResult', 'Front\SearchController@searchResult')->name('rooms.searchResult');
    Route::post('/ajax/searchResultOnMap', 'Front\SearchController@searchResultOnMap')->name('rooms.searchResultOnMap');
    Route::post('/ajax/searchMapRooms', 'Front\SearchController@searchMapRooms')->name('rooms.searchMapRooms');
    //===============PricingPageRoute========================
    Route::get('/ajax/membershiptypes', 'Front\MembershipController@gettypes');
    Route::get('/ajax/membershiptype/{planId}', 'Front\MembershipController@gettype');
    Route::post('/ajax/membership/stripe', 'Front\MembershipController@stripe');
    Route::post('/ajax/membership/braintree_token', 'Front\MembershipController@Braintree_token');
    // Route::post('/ajax/paypal/subscribe/createplan', 'Front\MembershipController@paypal_createplan');
    Route::post('/ajax/paypal/subscribe/excute', 'Front\MembershipController@paypal_excute');
    //==============Listing Subscribe Page===========//
    Route::get('/ajax/rooms/getpublishlistings/{id}', 'Front\RoomsController@getpublishlistings');
    Route::post('/ajax/rooms/post_subscribe_property/{id}', 'Front\RoomsController@post_subscribe_property');
    Route::post('/ajax/rooms/post_subscribe_property_paypal/create_plan', 'Front\MembershipController@paypal_createplan');


    // ============= Chat Route ======================//
    Route::post('/ajax/chat/sendmessage', 'Front\ChatsController@sendMessage')->name('chat.sendmessage');
    Route::post('/ajax/chatcontact/updatestatus', 'Front\ChatsController@updatecontactstatus')->name('chat.updatecontactstatus');
    Route::post('/ajax/chat/readMessage', 'Front\ChatsController@readmessage')->name('chat.readmessage');
    Route::post('/ajax/chat/fileupload', 'Front\ChatsController@fileupload')->name('chat.fileupload');
    Route::post('/ajax/chat/isTyping', 'Front\ChatsController@isTyping')->name('chat.isTyping');
    
    Route::get('/ajax/chat/getmessages', 'Front\ChatsController@getmessages')->name('chat.getmessages');
    Route::get('/ajax/chat/getcontactlists', 'Front\ChatsController@getcontactlists')->name('chat.getcontactlists');
    Route::get('/ajax/chat/getContactId/{hostid}/{userid}', 'Front\ChatsController@getContactId')->name('chat.getContactId');
    /* ==============BLOG Route ====================*/
    Route::get('/ajax/blog/index', 'Front\PostController@index')->name('blog.index');
    Route::get('/ajax/blog/get_author_info/{author_id}', 'Front\PostController@getAuthorInfo')->name('blog.get_author_info');
    Route::get('/ajax/blog/category/{slug}', 'Front\PostController@searchByCategory')->name('blog.category');
    Route::get('/ajax/blog/tag/{slug}', 'Front\PostController@searchByTag')->name('blog.tag');
    Route::get('/ajax/blog/author/{author}', 'Front\PostController@searchByAuthor')->name('blog.searchByAuthor');
    Route::get('/ajax/blog/detail/{post}', 'Front\PostController@detail')->name('blog.detail');
});

Route::group(['name' => 'bookingautomation'], function() {
    Route::post('/ba/account/register', 'BA\BookingAutomationController@createAccount');
    Route::get('/ba/account/getpropid', 'BA\BookingAutomationController@getPropId');
    Route::get('/ba/account/getcredential', 'BA\BookingAutomationController@getCredential');
    Route::get('/ba/account/getba_credential', 'BA\BookingAutomationController@getBaCredential');

    Route::group(['name' => 'api'], function() {
        Route::get('/ba/api/get_pricing/{room_id}', 'BA\BookingAutomationController@getPricing');
        Route::get('/ba/api/get_property/', 'BA\BookingAutomationController@getProperty');
        Route::get('/ba/api/get_room/{room_id}', 'BA\BookingAutomationController@getRoom');
        Route::get('/ba/api/get_availability/{room_id}/{start}/{end}', 'BA\BookingAutomationController@getAvailability');
        Route::get('/ba/api/get_room_dates', 'BA\BookingAutomationController@getRoomDates');
        Route::get('/ba/api/get_room_status', 'BA\BookingAutomationController@getRoomStatus');


        Route::get('/ba/api/getroomlistings', 'BA\BookingAutomationController@getListingsHasBa');
        Route::get('/ba/api/update', 'BA\BookingAutomationController@update');
        Route::get('/ba/api/set_baroomid', 'BA\BookingAutomationController@setBaRoomId');
        Route::get('/ba/api/get_baroomid', 'BA\BookingAutomationController@getBaRoomId');
        Route::get('/ba/api/get_bookings', 'BA\BookingAutomationController@getBookings');
        
    });
}); 
Route::get('/', 'HomeController@indexpage');
Route::get('/login', function(){return view('login');})->name('login');
Route::get('/help', function(){return view('help');});
Route::get('/faq', function(){return view('help');});
Route::get('/search', function(){return view('search');});
  
Route::get('/homes/{address_url}/{room_id}', 'Front\RoomsController@room_details')->name('rooms.detail');
Route::group(['middleware' => ['auth']], function () {
    Route::get('/inbox', function(){
        return view('inbox');
    });
    Route::get('/dashboard', function(){
        return view('dashboard');
    });
    Route::get('/dashboard/{url}', function(){
        return view('dashboard');
    });
    Route::get('/dashboard/{url}/{id}', function(){
        return view('dashboard');
    });
    
    Route::get('/rooms/manage-listing/{id}/{page}', function(){
        return view('managelisting');
    })->where(['id' => '[0-9]+','page' => 'basics|description|location|amenities|photos|video|pricing|calendar|details|guidebook|terms|booking|plans|subscribe_property|baroom']);
    Route::get('/rooms/{id}/subscribe_property', function(){
        return view('managelisting');
    });
    Route::get('/rooms/new', function(){
        
        return view('managelisting');
    });
});

Route::get('/blog', function(){
    return view('blog');
});
Route::get('/blog/{url}', function(){
    return view('blog');
});
Route::get('/blog/category/{slug}', function(){
    return view('blog');
});
Route::get('/blog/tag/{slug}', function(){
    return view('blog');
});
Route::get('/blog/author/{slug}', function(){
    return view('blog');
});
Route::get('/pricing',function(){
    return view('pricing');
});
Route::get('/contactus',function(){
    return view('contactus');
});
Route::get('/pricingplan/{planid}',function(){
    return view('pricing');
});
Route::get('/about-us/{name}', function(){
    return view('aboutus');
});
Route::get('/users/signup_social', 'Auth\SocialAuthController@signup_social')->name('social.signup_social');
// UserController@create_social
Route::get('/login/{provider}', 'Auth\SocialAuthController@redirectToProvider')->name('social.login');
Route::get('/login/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback')->name('social.callback');
 
Route::get('/users/signup_social', 'Auth\SocialAuthController@signup_social')->name('social.signup_social');
//create listing
Route::post('/createList', 'Api\PostController@createlist');



Route::get('/{address_url}/{room_id}', 'Front\RoomsController@room_details');




Route::get('sitemap.xml', function() {

	// create new sitemap object
	$sitemap = App::make('sitemap');

	// set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
	// by default cache is disabled
	// $sitemap->setCache('laravel.sitemap', 60);

	// check if there is cached sitemap and build new only if is not
	if (!$sitemap->isCached()) {
		// add item to the sitemap (url, date, priority, freq)
		$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
	
		// // get all posts from db
		// $posts = DB::table('posts')->orderBy('created_at', 'desc')->get();
        $rooms = DB::table('rooms')->where('status', 'Listed')->orderBy('created_at', 'desk')->get();
        // dd($rooms);
		// // add every post to the sitemap
        foreach ($rooms as $room) {
		 	$sitemap->add(URL::to("/homes/$room->slug/$room->id"), $room->updated_at, '1.0', 'daily');
        }
	}

	// show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
	return $sitemap->render('xml');
});

Route::get('sitemap', function() {

	// create new sitemap object
	$sitemap = App::make('sitemap');

	// set cache key (string), duration in minutes (Carbon|Datetime|int), turn on/off (boolean)
	// by default cache is disabled
	// $sitemap->setCache('laravel.sitemap', 60);

	// check if there is cached sitemap and build new only if is not
	if (!$sitemap->isCached()) {
		// add item to the sitemap (url, date, priority, freq)
		$sitemap->add(URL::to('/'), date('Y-m-d H:i:s'), '1.0', 'daily');
	
		// // get all posts from db
		// $posts = DB::table('posts')->orderBy('created_at', 'desc')->get();
        $rooms = DB::table('rooms')->where('status', 'Listed')->orderBy('created_at', 'desk')->get();
        // dd($rooms);
		// // add every post to the sitemap
        foreach ($rooms as $room) {
		 	$sitemap->add(URL::to("/homes/$room->slug/$room->id"), $room->updated_at, '1.0', 'daily');
        }
	}

	// show your sitemap (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
	return $sitemap->render('xml');
});

Route::get('/{url}','HomeController@indexpage');


Route::get('/rooms/{url}', 'HomeController@indexpage');
Route::get('/managelist/{url}','HomeController@indexpage');
Route::get('/managelist/{id}/{url}', 'HomeController@indexpage');