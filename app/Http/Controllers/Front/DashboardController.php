<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\UserRegistrationRequest;
use App\Models\PropertyManager;
use Illuminate\Support\Facades\Cookie;
use Propaganistas\LaravelPhone\Validation\Phone;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Route;
use App\Http\Start\Helpers;
use App\Http\Helper\FacebookHelper;
use Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Validator;
use App\Models\Front\User;
use App\Models\Front\ProfilePicture;
use App\Models\Front\Country;
use App\Models\Front\Currency;
use App\Models\Front\Timezone;
use App\Models\Front\PasswordResets;
use App\Models\Front\Messages;
use App\Models\Front\PayoutPreferences;
use App\Models\Front\Rooms;
use App\Models\Front\Payouts;
use App\Models\Front\Reviews;
use App\Models\Front\Reservation;
use App\Models\Front\UsersVerification;
use App\Models\Front\Wishlists;
use App\Models\Front\ReferralSettings;
use App\Models\Front\Referrals;
use App\Models\Front\UsersPhoneNumbers;
use App\Models\Front\Language;
use App\Models\Front\PaymentGateway;
use Socialite; // This package have all social media API integration
use Mail;
use DateTime;
use Hash;
use Excel;
use DB;
use Image;
use Session;
use File;
use Twilio;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\AuthController;

// Facebook API
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use Twilio\Rest\Client;
use Log;

class DashboardController extends Controller
{
    //
    public function index(){
       
		$logedInUser = Auth::user();
		$logedInUser = User::find($logedInUser->id);
		$logedInUser->phone_number = UsersPhoneNumbers::where('user_id', Auth::user()->id)->get();
		$logedInUser->profile_pic = ProfilePicture::find($logedInUser->id);
        $sess=Session::getId();
		$data['user'] = $user = Auth::user();
		$data['user_id'] = $user_id = Auth::user()->id;
		// $data['all_message']  = Messages::whereIn('id', function($query)
		// {
		// 	$query->select(DB::raw('max(id)'))
		// 	      ->from('messages')->groupby('reservation_id');
		// })->with(['user_details' => function($query) {
		// 	$query->with('profile_picture');
		// }])->with('rooms_address')->where('user_to', $data['user_id'])->where('read',0)->orderBy('id','desc')->get();

		// $data['unread']  =  Messages::whereIn('id', function($query) use($user_id)
		// {
		// 	$query->select(DB::raw('max(id)'))->from('messages')->where('user_to', $user_id)->groupby('reservation_id');
		// })->with(['user_details' => function($query) {
		// 	$query->with('profile_picture');
		// }])->with('rooms_address')->where('read',0)->orderBy('id','desc')->get();

		$data['profile_pic'] = $logedInUser->profile_picture->src;
		$listed = Rooms::where('user_id','=', Auth::user()->id)->where('status','=','Listed');
		$data['option'] = $listed->count() ? 'hosted_dashboard' : 'guest_dashboard';
		if($listed->count() > 0){
			$currentMonth = date('m');
			$currentYear = date('Y');
			$pending_counts=0;
			$notification_count1=0;

		 

			$data['notification_count']=User::find(Auth::user()->id)->inbox_count();
			$data['pending_trip_count']=Reservation::with('users','rooms')->where('type','!=','contact')
			->where(function($query){
				$query->where('status','Pending')->orwhere('status','Pre-Accepted');
			})
			->where('checkin', '>=', date('Y-m-d'))
			->where('user_id',Auth::user()->id)->count();

			$data['current_trip_count']= Reservation::with('users','rooms')->where(function($query){
				$query->where(function($query) {
					$query->where('checkin','>=',date('Y-m-d'))->where('checkout','<=',date('Y-m-d'));
				})->orWhere(function($query) {
					$query->where('checkin','<=',date('Y-m-d'))->where('checkout','>=',date('Y-m-d'));
				});
			})->where('status','!=','Pending')->where('status','!=','Pre-Accepted')->where('status','!=','Pre-Approved')->where('type','!=','contact')->where('user_id',Auth::user()->id)->count();

			$data['upcoming_trip_count']= Reservation::with('users','rooms')->where('checkin','>',date('Y-m-d'))->where('type','!=','contact')->where('status','!=','Pre-Accepted')->where('status','!=','')->where('status','!=','Pending')->where('status','!=','Pre-Approved')->where('user_id',Auth::user()->id)->count();

			$data['all_trip_count'] = Reservation::with('users','rooms')->where('checkin','>',date('Y-m-d'))->where('type','!=','contact')->where('status','!=','Pre-Accepted')->where('status','!=','')->where('status','!=','Pending')->where('status','!=','Pre-Approved')->where('user_id',Auth::user()->id)->count();

			$data['pending_reservation_count']= Reservation::with('users','rooms')->where('type','!=','contact')
			                                           ->where(function($query){
				                                           $query->where('status','Pending')->orwhere('status','Pre-Accepted');
			                                           })
			                                           ->where('checkin', '>=', date('Y-m-d'))
			                                           ->where('host_id',Auth::user()->id)->count();
			$data['current_reservation_count'] = Reservation::with('users','rooms')->where(function($query){
															$query->where(function($query) {
																$query->where('checkin','>=',date('Y-m-d'))->where('checkout','<=',date('Y-m-d'));
															})->orWhere(function($query) {
																$query->where('checkin','<=',date('Y-m-d'))->where('checkout','>=',date('Y-m-d'));
															});
														})->where('status','=','Accepted')->where('type','!=','contact')->where('host_id',Auth::user()->id)->count();
			$data['upcoming_reservation_count']= Reservation::with('users','rooms')->where('checkin','>',date('Y-m-d'))->where('type','!=','contact')->where('status','=','Accepted')->where('host_id',Auth::user()->id)->count();

			$data['listing_count'] = Rooms::where('user_id','=', Auth::user()->id)->where('status','=','Listed')->count();
            //dd($data);
            return array(
                'status' => 'success',
                'user_info' => $logedInUser,
				'data' => $data,
			 
            );
			// return view('users.host_dashboard', $data);
		}else{
		 
            return array(
                'status' => 'success',
				'user_info' => $logedInUser,
				'countries' => Country::all(),
				'data' => $data,
				'languages' => Language::where('status', 'Active')->get(),
				'timezones' => Timezone::all()
				
            );
			// return view('users.guest_dashboard', $data);
		}
        return array(
            'status' => 'success',
			'user_info' => $logedInUser,
			'languages' => Language::where('status', 'Active')->get()
			
        );
    }


    public function profilepictureupload(Request $request){
        // dd($request->file('myFile'));
        if($image = $request->file('myFile')){
			$extension      =   $image->getClientOriginalExtension();
			$file_name_time = time();
			$filename       =   'profile_pic_' . $file_name_time . '.' . $extension;
			$imageRealPath  =   $image->getRealPath();
			$extension=strtolower($extension);

			if ($extension != 'jpg' && $extension != 'jpeg' && $extension != 'png' && $extension != 'gif' ) {
                return array(
                    'status' => 'error',
                    'message' => trans('messages.profile.cannot_upload')
                );
            }
				$img = Image::make($imageRealPath)->orientate();
				
				$path = dirname($_SERVER['SCRIPT_FILENAME']).'/images/users/'.Auth::user()->id;
				if(!file_exists($path)) {
					if ( ! mkdir( $concurrentDirectory = dirname( $_SERVER['SCRIPT_FILENAME'] ) . '/images/users/' . Auth::user()->id, 0777, true ) && ! is_dir( $concurrentDirectory ) ) {
						throw new \RuntimeException( sprintf( 'Directory "%s" was not created', $concurrentDirectory ) );
					}
				}
				$success = $img->save('images/users/'.Auth::user()->id.'/'.$filename);
				$img1 = Image::make($imageRealPath);
				$img->resize(225, 225);
				$filename1       =   'profile_pic_' . $file_name_time . '_225x225.' . $extension;
				$success = $img->save('images/users/'.Auth::user()->id.'/'.$filename1);
				// $compress_success = $this->helper->compress_image('images/users/'.Auth::user()->id.'/'.$filename, 'images/users/'.Auth::user()->id.'/'.$filename, 80);
				// //change compress image in 510*510
				// $compress_success = $this->helper->compress_image('images/users/'.Auth::user()->id.'/'.$filename, 'images/users/'.Auth::user()->id.'/'.$filename, 80,510,510);
				//end change
				if(!$success) {
                    return array(
                        'status' => 'error',
                        'message' => trans('messages.profile.cannot_upload')
                    );
				 
                }
            $user_pic = ProfilePicture::find(Auth::user()->id) ? ProfilePicture::find(Auth::user()->id) : new ProfilePicture;
            
			$user_pic->user_id      =   Auth::user()->id;
			$user_pic->src          =   $filename;
			$user_pic->photo_source =   'Local';

			$user_pic->save();  // Update a profile picture record
            return array(
                'status' => 'success',
                'message' =>  trans('messages.profile.picture_uploaded'),
                'file_url' => asset('images/users/'.Auth::user()->id.'/'.$filename)
            );
			// $this->helper->flash_message('success', trans('messages.profile.picture_uploaded'));
            }
	}
	
	public function saveuserprofile(Request $request){
		// dd($request);
		$user = User::find(Auth::user()->id);
		
		$user->first_name = $request->first_name;
		$user->last_name = $request->last_name;
		$user->email = $request->email;
		$user->user_type = $request->user_type;
		$user->dob = $request->dob;
		$user->gender = $request->gender;
		$user->live = $request->live;
		$user->about = $request->about;
		$user->website = $request->website;
		$user->school = $request->school;
		$user->work = $request->work;
		$user->timezone = $request->timezone;
		$phone_number_array = $request->phone_number;
		foreach($phone_number_array as $phone_number){
			// var_dump($phone_number);
			if($phone_number['id']){
				$phoneNumber = UsersPhoneNumbers::find($phone_number['id']);
			}
			else {
				$phoneNumber = new UsersPhoneNumbers();
			}
			$phoneNumber->user_id = Auth::user()->id;
			$phoneNumber->country_name = $phone_number['country_name'];
			$phone_number['phone_number'] = str_replace(array( '(', ')', '-', ' ' ), '', $phone_number['phone_number']);

			$phoneNumber->phone_number=$phone_number['phone_number'];
			$phoneNumber->status=$phone_number['status'] ? $phone_number['status'] : 'Pending';
			$phoneNumber->otp = $this->generatePIN();
			$phoneNumber->save();
		}
		// $user->languages = implode(',', $request->languages) ;
		// dd($user);
		$user->save();
		$logedInUser = User::find(Auth::user()->id);
		$logedInUser->phone_number = UsersPhoneNumbers::where('user_id', Auth::user()->id)->get();
		return array(
			'status' => 'success',
			'message' => 'Saved Successfully',
			'userinfo' => $logedInUser
		);
	}
	function generatePIN($digits = 4){
		$i = 0; //counter
		$pin = ""; //our default pin is blank.
		while($i < $digits){
			//generate a random number between 0 and 9.
			$pin .= mt_rand(0, 9);
			$i++;
		}
		return $pin;
	}
	public function removeUserPhoneNumber(Request $request){
		UsersPhoneNumbers::find($request->phone_number_id)->delete();
		return array(
			'status' => 'success',
			'message' => 'Removed your phonenumber',
			'phone_number_id' => $request->phone_number_id
		);
		exit;
	}

	public function getverifycation(){
		return array(
			'user_info' => Auth::user(),
			'verifycation' => UsersVerification::find(Auth::user()->id),
			'phone_numbers' => UsersPhoneNumbers::where('user_id', Auth::user()->id)->get()
		);
	}
	public function sendVerifyCode( Request $request){
	 
		$phone_number = UsersPhoneNumbers::find($request->phone_number_id);
		return Twilio::message($phone_number->phone_number_full, $phone_number->verification_message_text);

		return;
		
		// Twilio::message($user->phone, $message);
	}
	public function verifyPhoneNumber(Request $request){
		// echo $request->phone_number_id.'____________'.$request->code;
		
		$phone_number = UsersPhoneNumbers::find($request->phone_number_id);
		if($phone_number->otp == $request->code){
			$phone_number->status = 'Confirmed';
			$phone_number -> save();
			$count_unverified = UsersPhoneNumbers::where('user_id', Auth::user()->id)->where('status', 'Null')->count();
			$count_pending = UsersPhoneNumbers::where('user_id', Auth::user()->id)->where('status', 'Pending')->count();
			
			if($count_pending == 0 && $count_unverified == 0){
				$verifycation = UsersVerification::find(Auth::user()->id);
				$verifycation->phone = 'yes';
				$verifycation->save();
			}
			return array(
				'status' => 'success',
				'message' => 'Verified your phone number!',
				'count_unverified' => $count_unverified,
				'count_pending' => $count_pending,
				'phone_numbers' => UsersPhoneNumbers::where('user_id', Auth::user()->id)->get()
			);
		}
		else{
			$count_unverified = UsersPhoneNumbers::where('user_id', Auth::user()->id)->where('status', 'Null')->count();
			$count_pending = UsersPhoneNumbers::where('user_id', Auth::user()->id)->where('status', 'Pending')->count();
			return array(
				'status' => 'false',
				'count_unverified' => $count_unverified,
				'count_pending' => $count_pending,
				'message' => 'Please input correct code!',
				'phone_numbers' => UsersPhoneNumbers::where('user_id', Auth::user()->id)->get()
			);
		}
		exit;
	}
}
