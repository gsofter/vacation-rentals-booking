<?php

/**
 * Email Controller
 *
 * @package     Makent
 * @subpackage  Controller
 * @category    Email
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mail;
use Config;
use Auth;
use DateTime;
use DateTimeZone;
use App\Models\Front\PasswordResets;
use App\Models\Front\User;
use App\Models\Front\Rooms;
use App\Models\Front\HostExperiences;
use App\Models\Front\Reservation;
use App\Models\Front\SiteSettings;
use App\Models\Front\PayoutPreferences;
use App\Models\Front\ReferralSettings;
use App\Models\Front\Currency;
use App\Models\Front\Reviews;
use App\Models\Front\Admin;
use App\Models\Front\PropertyManager;
use App;
use JWTAuth;

use App\Mail\MailQueue;

/**
 * Class EmailController
 *
 * @package App\Http\Controllers
 */
class EmailController extends Controller
{
	/**
	 * Send Welcome Mail to Users with Confirmation Link
	 *
	 * @param array $user User Details
	 *
	 * @return true
	 * @throws \RuntimeException
	 */
	public function welcome_email_confirmation($user)
	{
		$data['first_name'] = $user->first_name;
		$data['email'] = $user->email;
		$data['token'] = str_random(100); // Generate random string values - limit 100
		$data['type'] = 'welcome';
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$password_resets = new PasswordResets;

		$password_resets->email      = $user->email;
		$password_resets->token      = $data['token'];
		$password_resets->created_at = date('Y-m-d H:i:s');

		$password_resets->save(); // Insert a generated token and email in password_resets table

		$data['subject'] = trans('messages.email.confirm_email_address');

		// Send Forgot password email to give user email
		/*Mail::queue('emails.email_confirm', $data, function($message) use($data) {
			$message->to($data['email'], $data['first_name'])->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.email_confirm';
		Mail::to($data['email'], $data['first_name'])->queue(new MailQueue($data));

		return true;
	}


	/**
	 * Send Welcome Mail to Users with Confirmation Link
	 *
	 * @param $user_contact
	 *
	 * @return true
	 */
	public function contact_email_confirmation($user_contact)
	{

		$admin = Admin::where('id','1')->first();
		$admin_support = Admin::where('support_contact','1')->first();
		$data['admin_email'] = $admin->email;
		$data['admin_name'] =  'Admin';
		$data['admin_support_email'] = $admin_support->email;
		$data['admin_support_name'] = $admin_support->username;

		$data['contact_name'] = $user_contact->name;
		$data['contact_email'] = $user_contact->email;
		$data['contact_type'] = $user_contact->contact_type;
		$data['ip_address'] = $user_contact->ip_address;
		$data['contact_feedback'] = $user_contact->feedback;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['subject'] = trans('messages.email.contact_us_email');
		$data['view_file'] = 'emails.email_contact';

		//If contact_type is support, cc the designated support contact
		if($user_contact->contact_type == 'support'){
			Mail::to($data['admin_email'], $data['admin_name'])->queue(new MailQueue($data));
			Mail::to($data['admin_support_email'], $data['admin_support_name'])->queue(new MailQueue($data));
		} else {
			// Send Contact email to admin mail
			Mail::to($data['admin_email'], $data['admin_name'])->queue(new MailQueue($data));
		}

		return true;
	}

	/**
	 * Send Forgot Password Mail with Confirmation Link
	 *
	 * @param array $user User Details
	 *
	 * @return true
	 * @throws \RuntimeException
	 */
	public function forgot_password($user)
	{

		$data['first_name'] = $user->first_name;

		$data['token'] = str_random(100); // Generate random string values - limit 100
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$password_resets = new PasswordResets;

		$password_resets->email      = $user->email;
		$password_resets->token      = $data['token'];
		$password_resets->created_at = date('Y-m-d H:i:s');

		$password_resets->save(); // Insert a generated token and email in password_resets table

		// Send Forgot password email to give user email
		$data['subject'] = trans('messages.email.reset_your_pass',[], null,  $data['locale']);
		/*Mail::queue('emails.forgot_password', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.forgot_password';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Email Change Mail with Confirmation Link
	 *
	 * @param array $user User Details
	 *
	 * @return true
	 * @throws \RuntimeException
	 */
	public function change_email_confirmation($user)
	{
		$data['first_name'] = $user->first_name;
		$data['token'] = str_random(100); // Generate random string values - limit 100
		$data['type'] = 'change';
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$password_resets = new PasswordResets;

		$password_resets->email      = $user->email;
		$password_resets->token      = $data['token'];
		$password_resets->created_at = date('Y-m-d H:i:s');

		$password_resets->save(); // Insert a generated token and email in password_resets table

		// Send Forgot password email to give user email
		$data['subject']=trans('messages.email.confirm_email_address');
		/*Mail::queue('emails.email_confirm', $data, function($message) use($user,$data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.email_confirm';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send New Email Change Mail with Confirmation Link
	 *
	 * @param array $user User Details
	 *
	 * @return true
	 * @throws \RuntimeException
	 */
	public function new_email_confirmation($user)
	{
		$data['first_name'] = $user->first_name;
		$data['token'] = str_random(100); // Generate random string values - limit 100
		$data['type'] = 'confirm';
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$password_resets = new PasswordResets;

		$password_resets->email      = $user->email;
		$password_resets->token      = $data['token'];
		$password_resets->created_at = date('Y-m-d H:i:s');

		$password_resets->save(); // Insert a generated token and email in password_resets table

		// Send Forgot password email to give user email
		$data['subject']=trans('messages.email.confirm_email_address');
		/*Mail::queue('emails.email_confirm', $data, function($message) use($user,$data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.email_confirm';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Inquiry Mail to Host
	 *
	 * @param array $reservation_id Contact Request Details
	 * @param       $question
	 *
	 * @return true
	 */
	public function inquiry($reservation_id , $question )
	{
		$data['result'] = Reservation::find($reservation_id);
		$data['question'] = $question;
		$user = $data['result']->host_users;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();

		$data['subject'] = trans('messages.email.inquiry_at').' '.$data['result']['rooms']['name'].' '.trans('messages.email.for').' '.$data['result']['dates_subject'];

		/*Mail::queue('emails.inquiry', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.inquiry';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Booking Mail to Host
	 *
	 * @param array $reservation_id Request Details
	 * @return true
	 */
	public function booking($reservation_id)
	{
		$data['result'] = Reservation::find($reservation_id);
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'messages']);

		$data['result'] = $data['result']->first()->toArray();

		$data['subject'] = trans('messages.email.booking_inquiry_for').' '.$data['result']['rooms']['name'].' '.trans('messages.email.for').' '.$data['result']['dates_subject'];
		/*Mail::queue('emails.booking', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.booking';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send itinerary Mail to Host
	 *
	 * @param        $code
	 * @param string $email Friend Email
	 *
	 * @return true
	 */
	public function itinerary($code , $email )
	{
		$data['result'] = Reservation::where('code', $code)->first();
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['email'] = $email;
		$data['url'] = url('/').'/';
		$data['map_key'] = MAP_KEY;
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		$data['subject'] = trans('messages.email.reservation_itinerary_from').' '.$data['result']['users']['full_name'];

		/*Mail::queue('emails.itinerary', $data, function($message) use($user, $data) {
			$message->to($data['email'], '')->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.itinerary';
		Mail::to($data['email'], $data['subject'])->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send preapproval Mail to Host
	 *
	 * @param array  $reservation_id      Reservation Id
	 * @param string $preapproval_message Message from Host when pre-approving
	 * @param string $type
	 *
	 * @return true
	 */
	public function preapproval($reservation_id, $preapproval_message, $type = 'pre-approval')
	{
		$data['result']              = Reservation::find($reservation_id);
		$user                        = $data['result']->users;
		$data['first_name']          = $user->first_name;
		$data['preapproval_message'] = $preapproval_message;
		$data['type']                = $type;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'special_offer' => function($query) {
			$query->orderby('special_offer.id','desc')->limit(1)->with('rooms');
		}]);

		$data['result'] = $data['result']->first()->toArray();

		if($type == 'pre-approval') {
			$subject = $data['result']['host_users']['first_name'].' '.trans('messages.email.reservation_itinerary_from').' '.$data['result']['special_offer']['rooms']['name']." for ".$data['result']['special_offer']['dates_subject'];
		}
		else if($type == 'special_offer') {
			$subject = $data['result']['host_users']['first_name'].' '.trans('messages.email.sent_Special_Offer_for').' '.$data['result']['special_offer']['rooms']['name']." for ".$data['result']['special_offer']['dates_subject'];
		}

		$data['subject'] = $subject;
		/*Mail::queue('emails.preapproval', $data, function($message) use($user, $data, $subject) {
			$message->to($user->email, $user->first_name)->subject($subject);
		});*/
		$data['view_file'] = 'emails.preapproval';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Listed Mail to Host
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function listed($room_id)
	{
		$result               = Rooms::find($room_id);
		$user                 = $result->users;
		$data['first_name']   = $user->first_name;
		$data['room_name']    = $result->name;
		$data['address_url']  = $result->address_url;
		$data['created_time'] = $result->created_time;
		$data['room_id']      = $result->id;
		$data['url']          = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['subject'] = trans('messages.email.your_space_listed').' '.SITE_NAME;

		/*Mail::queue('emails.listed', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.listed';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Unlisted Mail to Host
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function unlisted($room_id)
	{
		$result = Rooms::find($room_id);
		$user = $result->users;
		$data['first_name'] = $user->first_name;
		$data['created_time'] = $result->created_time;
		$data['room_id'] = $result->id;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['subject'] = trans('messages.email.listing_deactivated').' '.SITE_NAME.' '.trans('messages.email.account');
		/*Mail::queue('emails.unlisted', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.unlisted';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Listed Mail to Admin
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function listing_approval($room_id)
	{
		$result               = Rooms::find($room_id);
		$user                 = $result->users;
		$data['first_name']   = $user->first_name;
		$data['room_name']    = $result->name;
		$data['address_url']  = $result->address_url;
		$data['created_time'] = $result->created_time;
		$data['room_id']      = $result->id;
		$data['url']          = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['admin'] = Admin::whereStatus('Active')->first();
		$data['subject'] = trans('messages.email.new_listing_approval',[], null,  $data['locale']).' '.$data['room_name'];

		$data['view_file'] = 'emails.listing_approval';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));
		return true;
	}

	/**
	 * Send Updated Payout Information Mail to Host
	 *
	 * @param array  $payout_preference_id Payout Preference Details
	 * @param string $type
	 * @return true
	 */
	public function payout_preferences($payout_preference_id, $type = 'update')
	{
		if($type != 'delete') {
			$result = PayoutPreferences::find($payout_preference_id);
			$user = $result->users;
			$data['first_name'] = $user->first_name;
			$data['updated_time'] = $result->updated_time;
			$data['updated_date'] = $result->updated_date;
		}
		else
		{
			//get current url
			/*$route=@Route::getCurrentRoute();

			if($route)
			{
			 $api_url = @$route->getPath();
			}
			else
			{
			 $api_url = '';
			 }

			 $url_array=explode('/',$api_url);
			 //check request from mobile or web
		   if(@$url_array['0']=='api')*/
			if(request()->segment(1) == 'api')
			{  //set api user authentication
				$user=JWTAuth::parseToken()->authenticate();
				$data['first_name'] = $user->first_name;
				$new_str = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone(Config::get('app.timezone')));
				$new_str->setTimeZone(new DateTimeZone($user->timezone));
			}
			else
			{  //set web user authentication
				$user = Auth::user();
				$data['first_name'] = $user->first_name;
				$new_str = new DateTime(date('Y-m-d H:i:s'), new DateTimeZone(Config::get('app.timezone')));
				$new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));

			}
			$data['deleted_time'] = $new_str->format('d M').' at '.$new_str->format('H:i');
		}
		$data['type'] = $type;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		if($type == 'update')
			$subject = trans('messages.email.your').' '.SITE_NAME." ".trans('messages.email.payout_information_updated');
		else if($type == 'delete')
			$subject = trans('messages.email.your').' '.SITE_NAME." ".trans('messages.email.payout_information_deleted');
		else if($type == 'default_update')
			$subject = trans('messages.email.payout_information_changed');

		$data['subject'] = $subject;
		/*Mail::queue('emails.payout_preferences', $data, function($message) use($user, $data, $subject) {
			$message->to($user->email, $user->first_name)->subject($subject);
		});*/
		$data['view_file'] = 'emails.payout_preferences';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Need Payout Information Mail to Host/Guest
	 *
	 * @param array $reservation_id Reservation Details
	 * @param       $type
	 * @return true
	 */
	public function need_payout_info($reservation_id, $type)
	{
		$result       = Reservation::find($reservation_id);
		$data['type'] = $type;

		if($type == 'guest') {
			$user = $result->users;
			$data['payout_amount'] = $result->admin_guest_payout;
		}
		else {
			$user = $result->host_users;
			$data['payout_amount'] = $result->admin_host_payout;
		}

		$data['currency_symbol'] = $result->currency->symbol;
		$data['first_name']      = $user->first_name;
		$data['user_id']         = $user->id;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['subject'] = trans('messages.email.information_needed');

		/*Mail::queue('emails.need_payout_info', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.need_payout_info';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Room Details Updated to Admin
	 *
	 * @param array $room_id , $content
	 * @param       $field
	 * @return true
	 */
	public function room_details_updated($room_id, $field){

		$data['room_id'] = $room_id;
		$data['result'] = Rooms::find($room_id)->toArray();
		$data['field'] = $field;
		$data['user'] = User::find($data['result']['user_id']);

		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['admin'] = Admin::whereStatus('Active')->first();
		$data['first_name'] = $data['admin']->username;
		$data['subject'] = trans('messages.email.rooms_details_updated',[], null,  $data['locale']).' '.$data['result']['name'];
		if($data['result']['status'] == 'Listed'){
			/*Mail::queue('emails.room_details_updated', $data, function($message) use($data) {
				$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
			});*/
			$data['view_file'] = 'emails.room_details_updated';
			Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));
		}
		return true;
	}

	/**
	 * Send Need Payout Sent Mail to Host/Guest
	 *
	 * @param array $reservation_id Reservation Details
	 * @param       $type
	 * @return true
	 */
	public function payout_sent($reservation_id, $type)
	{
		$data['result'] = Reservation::find($reservation_id);
		$data['type'] = $type;

		if($type == 'guest') {
			$user = $data['result']->users;
			$data['full_name'] = $data['result']->host_users->full_name;
			$data['payout_amount'] = $data['result']->admin_guest_payout;
			$payout_amount=html_entity_decode($data['result']['refund_currency']['symbol'], ENT_NOQUOTES, 'UTF-8').$data['payout_amount'];
		}
		else{
			$user = $data['result']->host_users;
			$data['full_name'] = $data['result']->users->full_name;
			$data['payout_amount'] = $data['result']->admin_host_payout;
			$payout_amount=html_entity_decode($data['result']['currency']['symbol'], ENT_NOQUOTES, 'UTF-8').$data['payout_amount'];
		}

		$data['result'] = Reservation::where('reservation.id',$reservation_id)->with(['rooms', 'currency'])->first()->toArray();
		$data['first_name'] = $user->first_name;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['subject'] = trans('messages.email.payout_of').' '.$payout_amount." ".trans('messages.email.sent');
		/*Mail::queue('emails.payout_sent', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.payout_sent';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Referral Email Share
	 *
	 * @param array $emails Friend Emails
	 * @return true
	 */
	public function referral_email_share($emails)
	{
		$user_id = Auth::user()->id;

		$data['result'] = $user = User::with(['profile_picture'])->whereId($user_id)->first()->toArray();

		$data['travel_credit'] = ReferralSettings::value(4);
		$data['symbol'] = Currency::first()->symbol;

		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$emails = explode(',', $emails);

		$data['subject'] = $user['full_name']." ".trans('messages.email.invited_you_to').' '.SITE_NAME;
		foreach($emails as $email) {
			$email = trim($email);
			/*Mail::queue('emails.referral_email_share', $data, function($message) use($user, $data, $email) {
				$message->to($email)->subject($data['subject']);
			});*/
			$data['view_file'] = 'emails.referral_email_share';
			Mail::to($email)->queue(new MailQueue($data));
		}
		return true;
	}

	/**
	 * Review Remainder
	 *
	 * @param array $reservation
	 * @param string $type
	 * @return true
	 */
	public function review_remainder($reservation, $type='guest')
	{
		$data['url'] = SiteSettings::where('name', 'site_url')->first()->value.'/';
		$data['locale']       = App::getLocale();

		if($type == 'guest') {
			$email = $reservation->host_users->email;
			$user = $reservation->users;
		}
		else {
			$email = $reservation->users->email;
			$user = $reservation->host_users;
		}

		$data['users'] = $user;
		$data['result'] = $reservation->toArray();

		$data['profile_picture'] = $user->profile_picture->email_src;
		$data['review_name'] = $user->first_name;

		$data['subject'] = trans('messages.email.write_review_about')." ".$user->first_name;
		/*Mail::queue('emails.review_remainder', $data, function($message) use($user, $data, $email) {
			$message->to($email)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.review_remainder';
		Mail::to($email)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Review Wrote
	 *
	 * @param int    $review_id
	 * @param string $type
	 * @return void
	 */
	public function wrote_review($review_id, $type ='guest')
	{
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$reviews = Reviews::find($review_id);

		$email = $reviews->users->email;

		$user = $reviews->users_from;

		$data['users'] = $user;
		$data['result'] = $reviews->toArray();

		$data['review_end_date'] = Reservation::find($reviews->reservation_id)->review_end_date;

		$data['profile_picture'] = $user->profile_picture->src;
		$data['review_name'] = $user->first_name;

		$data['view_url']= Reservation::find($reviews->reservation_id)->review_link;
		$data['subject'] = $user->first_name.' '.trans('messages.email.wrote_you_review');
		/*Mail::queue('emails.wrote_review', $data, function($message) use($user, $data, $email) {
			$message->to($email)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.wrote_review';
		Mail::to($email)->queue(new MailQueue($data));
	}

	/**
	 * Review Read
	 *
	 * @param int    $review_id
	 * @param string $type
	 * @return void
	 */
	public function read_review($review_id, $type ='guest')
	{
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$reviews = Reviews::find($review_id);

		$email = $reviews->users->email;

		$user = $reviews->users_from;

		$data['users'] = $user;
		$data['result'] = $reviews->toArray();

		$data['review_end_date'] = Reservation::find($reviews->reservation_id)->review_end_date;

		$data['profile_picture'] = $user->profile_picture->src;
		$data['review_name'] = $user->first_name;
		$data['view_url']= Reservation::find($reviews->reservation_id)->review_link;
		$data['subject'] = trans('messages.email.read').' '.$user->first_name."'s ".trans('messages.email.review');
		/*Mail::queue('emails.read_review', $data, function($message) use($user, $data, $email) {
			$message->to($email)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.read_review';
		Mail::to($email)->queue(new MailQueue($data));
	}

	/**
	 * Send accepted Mail to Host
	 *
	 * @param $code
	 * @return true
	 */
	public function accepted($code)
	{
		$data['result']         = Reservation::where('id', $code)->first();
		$user                   = $data['result']->host_users;
		$data['hide_header']    = true;

		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['locale']         = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		$data['subject'] = trans('messages.email.reservation_confirmed').' '.$data['result']['host_users']['full_name'];

		/*Mail::queue('emails.accepted', $data, function($message) use($user, $data) {
			$message->to($data['result']['users']['email'], '')->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.accepted';
		Mail::to($data['result']['users']['email'], '')->queue(new MailQueue($data));
		return true;
	}

	/**
	 * Send accepted Mail to Host
	 *
	 * @param $code
	 * @return true
	 */
	public function pre_accepted($code )
	{
		$data['result']         = Reservation::where('id', $code)->first();
		$user                   = $data['result']->host_users;
		$data['hide_header']    = true;

		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['locale']         = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		// return view('emails.pre_accepted', $data);
		$data['subject'] = trans('messages.inbox.reservations').' '.trans('messages.inbox.pre_accepted').' '.$data['result']['host_users']['full_name'];

		/*Mail::queue('emails.pre_accepted', $data, function($message) use($user, $data) {
			$message->to($data['result']['users']['email'], '')->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.pre_accepted';
		Mail::to($data['result']['users']['email'],'')->queue(new MailQueue($data));

		return true;
	}







	/**
	 * Booking Confirmed Email to Host
	 *
	 * @param array $reservation_id
	 * @return true
	 */
	public function booking_confirm_host($reservation_id){
		$data['result'] = Reservation::find($reservation_id);
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'messages']);

		$data['result'] = $data['result']->first()->toArray();
		$data['subject'] = trans('messages.email.booking_confirmed')." ".$data['result']['rooms']['name']." ".trans('messages.email.for')." ".$data['result']['dates_subject'];
		// return view('emails.booking_confirm_host', $data);
		/*Mail::queue('emails.booking_confirm_host', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.booking_confirm_host';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	public function booking_confirm_admin($reservation_id){
		$data['result'] = Reservation::find($reservation_id);
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'messages']);

		$data['result'] = $data['result']->first()->toArray();

		$data['admin'] = Admin::whereStatus('Active')->first();
		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];
		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{

			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{
			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}

		$data['subject'] = trans('messages.email.booking_confirmed',[], null,  $data['locale']).' '.$data['result']['rooms']['name'].' '.trans('messages.email.for',[], null,  $data['locale']).' '.$data['result']['dates_subject'];
		// return view('emails.booking_confirm_admin', $data);
		/*Mail::queue('emails.booking_confirm_admin', $data, function($message) use($user, $data) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.booking_confirm_admin';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));

		return true;
	}


	/**
	 * @param $code
	 *
	 * @return bool
	 */
	/**
	 * @param $code
	 *
	 * @return bool
	 */
	public function cancel_guest($code)
	{


		$data['result']         = Reservation::where('id', $code)->first();

		$user                   = $data['result']->host_users;
		$data['hide_header']    = true;

		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['locale']         = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		$data['admin'] = Admin::whereStatus('Active')->first();


		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];
		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{

			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{
			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}

		$data['subject']= trans('messages.email.reservation_cancelled_by').' '.$data['result']['users']['full_name'];
		// return view('emails.guest_cancel_confirm_admin', $data);
		// return view('emails.guest_cancel_confirm_host', $data);
		/*Mail::queue('emails.guest_cancel_confirm_admin', $data, function($message) use($user, $data) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.guest_cancel_confirm_admin';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));

		/*Mail::queue('emails.guest_cancel_confirm_host', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.guest_cancel_confirm_host';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * @param $code
	 *
	 * @return bool
	 */
	/**
	 * @param $code
	 *
	 * @return bool
	 */
	public function cancel_host($code)
	{


		$data['result']         = Reservation::where('id', $code)->first();

		$user                   = $data['result']->users;
		$data['hide_header']    = true;

		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['locale']         = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms' => function($query) {
			$query->with('rooms_address');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		$data['admin'] = Admin::whereStatus('Active')->first();


		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];
		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{

			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{
			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}



		if($data['result']['status']=='Declined')
			$subjects=trans('messages.email.request_cancelled_by');
		else
			$subjects=trans('messages.email.reservation_cancelled_by');

		$data['subject'] = $subjects.' '.$data['result']['host_users']['full_name'];
		// return view('emails.host_cancel_confirm_admin', $data);
		// return view('emails.host_cancel_confirm_guest', $data);

		/*Mail::queue('emails.host_cancel_confirm_admin', $data, function($message) use($user, $data ,$subjects) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($subjects.' '.$data['result']['host_users']['full_name']);
		});*/
		$data['view_file'] = 'emails.host_cancel_confirm_admin';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));

		/*Mail::queue('emails.host_cancel_confirm_guest', $data, function($message) use($user, $data ,$subjects) {
			$message->to($user->email, $user->first_name)->subject($subjects.' '.$data['result']['host_users']['full_name']);
		});*/
		$data['view_file'] = 'emails.host_cancel_confirm_guest';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;

	}

	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	public function reservation_expired_admin($reservation_id)
	{

		$data['results'] = Reservation::find($reservation_id);
		$user = $data['results']->host_users;
		$data['hide_header'] = true;
		$data['url'] = SiteSettings::where('name', 'site_url')->first()->value;
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification');
		}, 'currency'])->first()->toArray();

		$data['admin'] = Admin::whereStatus('Active')->first();


		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];

		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{
			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{
			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}
		$data['subject'] = trans('messages.email.reservation_expired',[], null,  $data['locale']).' '.$data['results']['rooms']['name']." for ".$data['result']['dates_subject'];
		// return view('emails.cancel_confirm_admin', $data);
		/*Mail::queue('emails.cancel_confirm_admin', $data, function($message) use($user, $data) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.cancel_confirm_admin';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	/**
	 * @param $reservation_id
	 *
	 * @return bool
	 */
	public function reservation_expired_guest($reservation_id)
	{

		$data['results'] = Reservation::find($reservation_id);
		$user = $data['results']->host_users;
		$data['hide_header'] = true;
		$data['url'] = SiteSettings::where('name', 'site_url')->first()->value;
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification');
		}, 'currency'])->first()->toArray();

		$data['admin'] = Admin::whereStatus('Active')->first();


		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];

		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{
			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{
			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}
		$data['subject'] = trans('messages.email.reservation_expired',[], null,  $data['locale']).' '.$data['results']['rooms']['name']." for ".$data['result']['dates_subject'];
		// return view('emails.reservation_expire_guest', $data);
		/*Mail::queue('emails.reservation_expire_guest', $data, function($message) use($user, $data) {
			$message->to($data['results']['users']['email'], $data['results']['users']['first_name'])->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.reservation_expire_guest';
		Mail::to($data['results']['users']['email'], $data['results']['users']['first_name'])->queue(new MailQueue($data));

		return true;
	}


	/**
	 * @param $reservation_id
	 * @param $hours
	 *
	 * @return bool
	 */
	/**
	 * @param $reservation_id
	 * @param $hours
	 *
	 * @return bool
	 */
	public function booking_response_remainder($reservation_id, $hours){

		$data['result'] = Reservation::find($reservation_id);

		// $user = $data['result']->users;
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['hours'] = $hours;
		$data['url'] = SiteSettings::where('name', 'site_url')->first()->value.'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'rooms', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();

		$check_in_time =  $data['result']['rooms']['check_in_time'];
		$check_out_time =  $data['result']['rooms']['check_out_time'];

		if($check_in_time == 'Flexible')
		{
			$data['check_in_time'] = 'Flexible';
		}
		else
		{
			$in_time =  $data['result']['rooms']['check_in_time'];
			$data['check_in_time'] = date("h:i A", strtotime("00-00-00 $in_time:00:00"));
		}
		if($check_out_time == 'Flexible')
		{
			$data['check_out_time'] = 'Flexible';
		}
		else
		{

			$out_time =  $data['result']['rooms']['check_out_time'];
			$data['check_out_time'] = date("h:i A", strtotime("00-00-00 $out_time:00:00"));
		}

		$data['subject'] = trans('messages.email.booking_inquiry_expire',[], null,  $data['locale']).' '.$data['result']['rooms']['name'].' '.trans('messages.email.for',[], null,  $data['locale']).' '.$data['result']['dates_subject'];

		/*Mail::queue('emails.booking_response_remainder', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.booking_response_remainder';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;

	}

	/*Host Experience Email Functions*/

	/**
	 * Send Review Submit Mail to Host
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function review_submited($room_id)
	{
		$result               = HostExperiences::with('user','city_details')->where('id',$room_id)->get()->first();
		$user                 = $result->users;
		$data['first_name']   = $user->first_name;
		$data['room_name']    = $result->name;
		$data['created_time'] = $result->created_time;
		$data['room_id']      = $result->id;
		$data['url']          = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['city']      = $result->city_details->name;
		$data['enc_phone_number']=$user->primary_phone_number_protected;
		$data['subject'] = trans('messages.email.submit_subject');

		/*Mail::queue('emails.host_experiences.review_submited', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.review_submited';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Review Approved Mail to Host
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function review_approved($room_id)
	{
		$result               = HostExperiences::with('user','city_details')->where('id',$room_id)->get()->first();
		$user                 = $result->users;
		$data['first_name']   = $user->first_name;
		$data['room_name']    = $result->name;
		$data['room_id']      = $result->id;
		$data['view_url']      = $result->link;
		$data['url']          = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['subject'] = trans('messages.email.review_approve_subject');

		/*Mail::queue('emails.host_experiences.review_approved', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.review_approved';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Review Rejected Mail to Host
	 *
	 * @param array $room_id Room Details
	 * @return true
	 */
	public function review_rejected($room_id)
	{
		$result               = HostExperiences::with('user','city_details')->where('id',$room_id)->get()->first();
		$user                 = $result->users;
		$data['first_name']   = $user->first_name;
		$data['room_name']    = $result->name;
		$data['room_id']      = $result->id;
		$data['view_url']      = $result->link;
		$data['url']          = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['subject'] = trans('messages.email.review_reject_subject');

		/*Mail::queue('emails.host_experiences.review_rejected', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.review_rejected';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send booking confirmed Mail to guest
	 *
	 * @param $code
	 * @return true
	 */
	public function experience_accepted($code)
	{
		$data['result']         = Reservation::where('id', $code)->first();
		$user                   = $data['result']->host_users;
		$data['hide_header']    = true;

		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['locale']         = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $data['result']->id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'host_experiences' => function($query) {
			$query->with('host_experience_location');
		}, 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);

		$data['result'] = $data['result']->first()->toArray();
		$data['link']   =$data['result']['host_experiences']['link'];
		$data['subject'] = trans('messages.email.booking_confirmed').' '.$data['result']['host_experiences']['title'];
		// return view('emails.host_experiences.experience_accepted', $data);
		/*Mail::queue('emails.host_experiences.experience_accepted', $data, function($message) use($user, $data) {
			$message->to($data['result']['users']['email'], '')->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.experience_accepted';
		Mail::to($data['result']['users']['email'], '')->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Experience Booking Confirmed Email to Host
	 *
	 * @param array $reservation_id
	 * @return true
	 */
	public function experience_booking_confirm_host($reservation_id){
		$data['result'] = Reservation::find($reservation_id);
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['url'] = url('/').'/';
		$data['locale']       =  App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'host_experiences', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'messages']);

		$data['result'] = $data['result']->first()->toArray();
		$data['subject'] = trans('messages.email.booking_confirmed')." ".$data['result']['host_experiences']['title']." ".trans('messages.email.for')." ".$data['result']['dates_subject'];
		// return view('emails.host_experiences.experience_book_host', $data);
		/*Mail::queue('emails.host_experiences.experience_book_host', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.experience_book_host';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Experience Booking Confirmed Email to Admin
	 *
	 * @param array $reservation_id
	 * @return true
	 */
	public function experience_booking_confirm_admin($reservation_id){
		$data['result'] = Reservation::find($reservation_id);
		$user = $data['result']->host_users;
		$data['hide_header'] = true;
		$data['url'] = url('/').'/';
		$data['locale']       = 'en';

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'host_experiences', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency', 'messages']);

		$data['result'] = $data['result']->first()->toArray();

		$data['admin'] = Admin::whereStatus('Active')->first();


		$data['subject'] = trans('messages.email.booking_confirmed',[], null,  $data['locale']).' '.$data['result']['host_experiences']['title'].' '.trans('messages.email.for',[], null,  $data['locale']).' '.$data['result']['dates_subject'];
		// return view('emails.host_experiences.experience_book_admin', $data);
		/*Mail::queue('emails.host_experiences.experience_book_admin', $data, function($message) use($user, $data) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.experience_book_admin';
		Mail::to($data['admin']->email, $data['admin']->username)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Experience Booking Cancelled Email to Host, Guest and Admin
	 *
	 * @param array $reservation_id
	 * @return true
	 */
	public function experience_booking_cancelled($reservation_id)
	{
		$reservation = Reservation::where('id', $reservation_id)->with([
			'users' => function($query) {
				$query->with('profile_picture')->with('users_verification')->with('reviews');
			},
			'host_experiences' => function($query) {
				$query->with('host_experience_location');
				$query->with('city_details');
			},
			'host_users' => function($query) {
				$query->with('profile_picture')->with('users_verification')->with('reviews');
			},
			'currency'
		])->first();

		if(!$reservation)
		{
			return '';
		}

		$result                 = $reservation->toArray();
		$result['duration_text']= $reservation->duration_text;
		$result['duration']     = $reservation->duration;

		$subject                = trans('experiences.emails.reservation_for_experience_cancelled', ['name' => $reservation->host_experiences->title]);
		$data                   = compact('result', 'subject');
		$data['url']            = url('/').'/';
		$data['map_key']        = MAP_KEY;
		$data['hide_header']    = true;
		$data['locale']         = App::getLocale();
		$data['admin']          = Admin::whereStatus('Active')->first();

		$data['to_user']        = $reservation->users;
		// return view('emails.host_experiences.booking_cancelled_guest', $data).view('emails.host_experiences.booking_cancelled_host', $data).view('emails.host_experiences.booking_cancelled_admin', $data);
		/*Mail::queue('emails.host_experiences.booking_cancelled_guest', $data, function($message) use($data) {
			$message->to($data['to_user']->email, $data['to_user']->first_name)->subject($data['subject']);
		});

		$data['to_user']        = $reservation->host_users;
		Mail::queue('emails.host_experiences.booking_cancelled_host', $data, function($message) use($data) {
			$message->to($data['to_user']->email, $data['to_user']->first_name)->subject($data['subject']);
		});

		Mail::queue('emails.host_experiences.booking_cancelled_admin', $data, function($message) use($data) {
			$message->to($data['admin']->email, $data['admin']->username)->subject($data['subject']);
		});*/
		return true;
	}

	/**
	 * Send Payout Sent Mail to Host/Guest
	 *
	 * @param array $reservation_id Reservation Details
	 * @param       $type
	 * @return true
	 */
	public function experience_payout_sent($reservation_id, $type)
	{
		$data['result'] = Reservation::find($reservation_id);
		$data['type'] = $type;

		if($type == 'guest') {
			$user = $data['result']->users;
			$data['full_name'] = $data['result']->host_users->full_name;
			$data['payout_amount'] = $data['result']->admin_guest_payout;
			$payout_amount=html_entity_decode($data['result']['refund_currency']['symbol'], ENT_NOQUOTES, 'UTF-8').$data['payout_amount'];
		}
		else{
			$user = $data['result']->host_users;
			$data['full_name'] = $data['result']->users->full_name;
			$data['payout_amount'] = $data['result']->admin_host_payout;
			$payout_amount=html_entity_decode($data['result']['currency']['symbol'], ENT_NOQUOTES, 'UTF-8').$data['payout_amount'];
		}

		$data['result'] = Reservation::where('reservation.id',$reservation_id)->with(['host_experiences', 'currency'])->first()->toArray();
		$data['first_name'] = $user->first_name;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['subject'] = trans('messages.email.payout_of').' '.$payout_amount." ".trans('messages.email.sent');
		/*Mail::queue('emails.host_experiences.payout_sent', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.payout_sent';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Inquiry Mail to Host
	 *
	 * @param array $reservation_id Reservation Details
	 * @param       $question
	 * @return true
	 */
	public function experience_inquiry_mail($reservation_id, $question)
	{
		$data['result'] = Reservation::find($reservation_id);
		$data['question'] = $question;
		$user = $data['result']->host_users;
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();

		$data['result'] = Reservation::where('reservation.id', $reservation_id)->with(['users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'host_experiences', 'host_users' => function($query) {
			$query->with('profile_picture')->with('users_verification')->with('reviews');
		}, 'currency']);
		$data['result'] = $data['result']->first()->toArray();
		$data['subject'] = trans('experiences.emails.message_from_user', ['first_name' => $data['result']['users']['first_name'] ]);

		/*Mail::queue('emails.host_experiences.inquiry', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.host_experiences.inquiry';
		Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Signup Mail to Property Manager
	 *
	 * @param $property_id
	 * @return true
	 */
	public function signup_property_manager($property_id)
	{
		// $property_id = 2;
		$data['result'] = $user = PropertyManager::find($property_id);
		$data['result'] = $data['result']->toArray();
		$data['url'] = url('/').'/';
		$data['locale']       = App::getLocale();
		$data['site_name']       = SITE_NAME;

		$data['subject'] = trans('messages.contactus.invitation_from', ['site_name' => SITE_NAME ]);
		// return view('emails.signup_property_manager',$data);
		/*Mail::queue('emails.host_experiences.inquiry', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.signup_property_manager';
		Mail::to($user->email, '')->queue(new MailQueue($data));

		return true;
	}

	/**
	 * Send Signup Mail to Property Manager
	 *
	 * @param $property_id
	 * @return true
	 */
	public function confirm_property_manager($property_id)
	{
		// $property_id = 2;
		$data['result'] = $user = PropertyManager::find($property_id);
		$data['result'] = $data['result']->toArray();
		$data['url'] = route('user.edit');
		$data['locale']       = App::getLocale();
		$data['site_name']       = SITE_NAME;

		$data['subject'] = trans('messages.contactus.invitation_from', ['site_name' => SITE_NAME ]);
		// return view('emails.signup_property_manager',$data);
		/*Mail::queue('emails.host_experiences.inquiry', $data, function($message) use($user, $data) {
			$message->to($user->email, $user->first_name)->subject($data['subject']);
		});*/
		$data['view_file'] = 'emails.confirm_property_manager';
		Mail::to($user->email, '')->queue(new MailQueue($data));

		return true;
	}

    /**
     * Created Subscription created by user
     *
     * @param Room $room object
     *
     * @return bool
     */

	public function subscription_created($room){
        $user = \Auth::user();
        /**** send email to users *****/
        $data['room'] = $room;
        $data['locale']       = App::getLocale();
        $data['subject'] = trans('messages.subscription.send_email_subscription_created_subject',[], null,  $data['locale']);
        $data['view_file'] = "emails.subscriptions.create";
        $data['email_type'] = "user";
        Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

        /**** send email to admin *****/

        $data['subject'] = trans('messages.subscription.send_email_subscription_created_subject_admin',[], null,  $data['locale']);
        $data['email_type'] = "admin";
        $data['user']   = $user;
        $admin = Admin::where('id','1')->first();
        if(count($admin)>0){
            $data['admin_email'] = $admin->email;
            $data['admin_name'] =  'Admin';
            Mail::to($data['admin_email'], $data['admin_name'])->queue(new MailQueue($data));
        }
//        $admin_support = Admin::where('support_contact','1')->first();
//        if(count($admin_support)>0){
//            $data['admin_support_email'] = $admin_support->email;
//            $data['admin_support_name'] = $admin_support->username;
//            Mail::to($data['admin_support_email'], $data['admin_support_name'])->queue(new MailQueue($data));
//        }
        return true;
    }

    /**
     * Delete delay subscriptions
     *
     * @param Room $room object
     *
     * @return bool
     */
    public function deleteDelaySubscriptions($room) {
        $user = $room->users;
        $data['room'] = $room;
        $data['locale']       = App::getLocale();
        $data['subject'] = trans('messages.subscription.delay_subscription_delete_subject',[], null,  $data['locale']);
        $data['view_file'] = "emails.subscriptions.delete";
        $data['email_type'] = "user";

        Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));

        $data['subject'] = trans('messages.subscription.send_email_subscription_created_subject_admin',[], null,  $data['locale']);
        $data['email_type'] = "admin";
        $data['user']   = $user;
        $admin = Admin::where('id','1')->first();
        if(count($admin)>0){
            $data['admin_email'] = $admin->email;
            $data['admin_name'] =  'Admin';
            Mail::to($data['admin_email'], $data['admin_name'])->queue(new MailQueue($data));
        }
        return true;
    }

	/**
	 * @param Room $room object
     *
     * @return bool
     */
    public function adminApprovedSubscription($room){

        $user = $room->users;
        $data['room'] = $room;
        $data['locale']       = App::getLocale();
        $data['subject'] = trans('messages.subscription.admin_approved_your_listing_subject',[], null,  $data['locale']);
        $data['view_file'] = "emails.subscriptions.approve";

        Mail::to($user->email, $user->first_name)->queue(new MailQueue($data));
        return true;
    }
}
