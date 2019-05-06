<?php


namespace App\Models\admin;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use DB;
use Auth;
use DateTime;
use DateTimeZone;
use Config;
use Session;
use App\User;
use App\Models\admin\RoomType;
use App\Models\admin\Subscription;
use App\Models\admin\RoomsPhotos;
use App\Models\admin\RoomsAddress;
use App\Models\Front\Membershiptype;
use Request;


class Rooms extends Model {

	protected $table = 'rooms';

	protected $fillable = ['summary', 'name', 'braintree_id', 'paypal_email', 'card_brand', 'card_last_four', 'trial_ends_at','bedrooms','bathrooms'];

	protected $appends = [
		'photo_name',
		'address_url',
		'approved_status',
		'featured_image'
	];

	protected $dates = ['deleted_at'];

	protected $casts = [
		'approved_status' => 'boolean',
		'seo'             => 'array'
	];

	public function getFirstnameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->first_name;
		else return "";
	}
	
	public function getlastnameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->last_name;
		else return "";
	}
	
	public function getRoomAddressByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->address_line_1;
		else return "";
	}
	
	public function getRoomCityByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->city;
		else return "";
	}
	
	public function getRoomStateByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->state;
		else return "";
	}
	
	public function getRoomCountryByID(){
		$roomAddress = RoomsAddress::find($this->id);
		if($roomAddress) return $roomAddress->country;
		else return "";
	}
	public function getMembership(){
		$membership =  Membershiptype::find($this->plan_type);
		if($membership){
			return $membership->Name;
		}
		else{
			return 'Undefined';
		}

	}

	
	public function hasActiveSubscription() {
		$paymentSubscriptions = SubscribeList::where('room_id', $this->id)->get();
		$currentDate = date("Y-m-d");
		if(count($paymentSubscriptions) >0) {
			foreach ( $paymentSubscriptions as $paymentSubscription ) {
				if ( $paymentSubscription->stripe_id && $paymentSubscription->stripe_id != '' ) {
					$timestamp    = strtotime( $paymentSubscription->subscription_end_date );
					if ( $timestamp > strtotime( $currentDate ) ) {
								return true;
								exit;
					}
				} 
				elseif( $paymentSubscription->braintree_id && $paymentSubscription->braintree_id != '' ){
					$timestamp    = strtotime( $paymentSubscription->subscription_end_date );
					if ( $timestamp > strtotime( $currentDate ) ) {
								return true;
								exit;
					}
				}
			 
			}
		}
		return false;
	}

	public static function getLenghtOfStayOptions() {
		$nights = Request::segment(1) == 'admin' ? 'nights' : trans_choice('messages.rooms.night', 2);
		$weekly = Request::segment(1) == 'admin' ? 'Weekly' : trans('messages.lys.weekly');
		$monthly = Request::segment(1) == 'admin' ? 'Monthly' : trans('messages.lys.monthly');

		$length_of_stay_options = [
			[
				'nights' => 2,
				'text'   => '2 '.$nights
			],
			[
				'nights' => 3,
				'text'   => '3 '.$nights
			],
			[
				'nights' => 4,
				'text'   => '4 '.$nights
			],
			[
				'nights' => 5,
				'text'   => '5 '.$nights
			],
			[
				'nights' => 6,
				'text'   => '6 '.$nights
			],
			[
				'nights' => 7,
				'text'   => $weekly
			],
			[
				'nights' => 14,
				'text'   => '14 '.$nights
			],
			[
				'nights' => 28,
				'text'   => $monthly
			],
		];
		return $length_of_stay_options;
	}
	

	/**
	 * @return array|\Illuminate\Support\Collection
	 */
	public static function getAvailabilityRulesMonthsOptions() {
		$month = date('m');
		$year = date('Y');
		$this_time = $start_time = mktime(12, 0, 0, $month, 1, $year);
		$end_time = mktime(12, 0, 0, $month, 1, $year+1);

		$availability_rules_months_options = collect();
		$i = 1;
		while($this_time < $end_time) {
			$loop_time = mktime(12, 0, 0, $month + ($i *3), 0, $year);
			$start_month = date('M Y', $this_time);
			$end_month = date('M Y', $loop_time);
			$availability_rules_months_options[] = [
				'text' => $start_month.' - '.$end_month,
				'start_date' => date('Y-m-d', $this_time),
				'end_date' => date('Y-m-d', $loop_time),
			];
			$this_time = strtotime('+1 day', $loop_time);
			$i++;
		}
		return $availability_rules_months_options;
	}
}
