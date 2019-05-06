<?php

/**
 * Reservation Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Reservation
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Models\Front\Rooms;
use App\Models\Front\PayoutPreferences;
use App\Models\Front\Payouts;
use App\Models\Reviews;
use App\Models\Front\SiteSettings;
use Session;
use DB;
use DateTime;
use Illuminate\Support\Facades\Route;
use JWTAuth;
use Log;

/**
 * App\Models\Front\Reservation
 *
 * @property int $id
 * @property string $code
 * @property int $room_id
 * @property string $list_type
 * @property int $host_id
 * @property int $user_id
 * @property string $checkin
 * @property string $checkout
 * @property string $start_time
 * @property string $end_time
 * @property int $number_of_guests
 * @property int $nights
 * @property int $per_night
 * @property int $subtotal
 * @property int $cleaning
 * @property string|null $cleaning_fee_type
 * @property string|null $additional_charge
 * @property int|null $total_additional_charge
 * @property int $additional_guest
 * @property int $security
 * @property int $service
 * @property float|null $tax_rate
 * @property float|null $total_taxes_pay
 * @property int $host_fee
 * @property int $total
 * @property string $coupon_code
 * @property int $coupon_amount
 * @property int $base_per_night
 * @property string|null $length_of_stay_type
 * @property int $length_of_stay_discount
 * @property int $length_of_stay_discount_price
 * @property string|null $booked_period_type
 * @property int $booked_period_discount
 * @property int $booked_period_discount_price
 * @property string $currency_code
 * @property string|null $paypal_currency
 * @property string $transaction_id
 * @property string|null $paymode
 * @property string $cancellation
 * @property string $first_name
 * @property string $last_name
 * @property string $postal_code
 * @property string $country
 * @property string|null $status
 * @property string|null $type
 * @property string $friends_email
 * @property string|null $cancelled_by
 * @property string $cancelled_reason
 * @property string $decline_reason
 * @property int $host_remainder_email_sent
 * @property int $special_offer_id
 * @property string $accepted_at
 * @property string $expired_at
 * @property string $declined_at
 * @property string $cancelled_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string $date_check
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Calendar[] $calendar
 * @property-read \App\Models\Front\Currency $currency
 * @property-read \App\Models\Disputes $dispute
 * @property-read mixed $address_url
 * @property-read mixed $admin_guest_payout
 * @property-read mixed $admin_host_payout
 * @property-read mixed $avablity
 * @property-read mixed $booked_reservation
 * @property-read mixed $can_apply_for_dispute
 * @property-read mixed $check_guest_payout
 * @property-read mixed $check_host_payout
 * @property-read mixed $check_total
 * @property-read mixed $checkin_arrive
 * @property-read mixed $checkin_cross
 * @property-read mixed $checkin_datepicker
 * @property-read mixed $checkin_dmd
 * @property-read mixed $checkin_dmy
 * @property-read mixed $checkin_dmy_slash
 * @property-read mixed $checkin_formatted
 * @property-read mixed $checkin_md
 * @property-read mixed $checkin_mdy
 * @property-read mixed $checkin_env('site_date_format')
 * @property-read mixed $checkout_cross
 * @property-read mixed $checkout_datepicker
 * @property-read mixed $checkout_depart
 * @property-read mixed $checkout_dmd
 * @property-read mixed $checkout_dmy
 * @property-read mixed $checkout_dmy_slash
 * @property-read mixed $checkout_formatted
 * @property-read mixed $checkout_md
 * @property-read mixed $checkout_mdy
 * @property-read mixed $checkout_env('site_date_format')
 * @property-read mixed $created_at_date
 * @property-read mixed $created_at_timer
 * @property-read mixed $dates
 * @property-read mixed $dates_subject
 * @property-read mixed $discounts_list
 * @property-read mixed $duration
 * @property-read mixed $duration_text
 * @property-read mixed $duration_type_text
 * @property-read mixed $end_time_hi
 * @property-read mixed $grand_total
 * @property-read mixed $guest_payout
 * @property-read mixed $guest_payout_currency
 * @property-read mixed $guest_payout_email_id
 * @property-read mixed $guest_payout_id
 * @property-read mixed $guest_payout_preference_id
 * @property-read mixed $guests
 * @property-read mixed $guests_text
 * @property-read mixed $host_or_guest
 * @property-read mixed $host_payout
 * @property-read mixed $host_payout_currency
 * @property-read mixed $host_payout_email_id
 * @property-read mixed $host_payout_id
 * @property-read mixed $host_payout_preference_id
 * @property-read mixed $last_date_for_dispute
 * @property-read mixed $maximum_dispute_amount
 * @property-read mixed $maximum_guest_dispute_amount
 * @property-read mixed $maximum_host_dispute_amount
 * @property-read mixed $original_created_at
 * @property-read mixed $original_currency_code
 * @property-read mixed $payout
 * @property-read mixed $receipt_date
 * @property-read mixed $remaining_days_for_dispute
 * @property-read mixed $review_days
 * @property-read mixed $review_end_date
 * @property-read mixed $review_link
 * @property-read mixed $room_category
 * @property-read \App\Models\Front\Rooms $rooms
 * @property-read mixed $start_time_hi
 * @property-read mixed $status_color
 * @property-read mixed $status_language
 * @property-read mixed $subtotal_multiply_text
 * @property-read mixed $times
 * @property-read mixed $title_class
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ReservationGuestDetails[] $guest_details
 * @property-read \'App\Models\Front\PayoutPreferences $guest_payout_preferences
 * @property-read \App\Models\HostExperiences $host_experiences
 * @property-read \'App\Models\Front\PayoutPreferences $host_payout_preferences
 * @property-read \App\Models\HostPenalty $host_penalty
 * @property-read \App\Models\Front\User $host_users
 * @property-read \App\Models\Messages $messages
 * @property-read \App\Models\Front\Payouts $payouts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Reviews[] $reviews
 * @property-read \App\Models\SpecialOffer $special_offer
 * @property-read \App\Models\SpecialOffer $special_offer_details
 * @property-read \App\Models\Front\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation userRelated($user_id = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereAcceptedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereAdditionalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereAdditionalGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereBasePerNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereBookedPeriodDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereBookedPeriodDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereBookedPeriodType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCancellation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCancelledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCancelledBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCancelledReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCheckin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCheckout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCleaning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCleaningFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCouponAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCouponCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereDateCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereDeclineReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereDeclinedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereFriendsEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereHostFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereHostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereHostRemainderEmailSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereLengthOfStayDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereLengthOfStayDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereLengthOfStayType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereListType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereNights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereNumberOfGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation wherePaymode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation wherePaypalCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation wherePerNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereService($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereSpecialOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereTaxRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereTotalAdditionalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereTotalTaxesPay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Reservation whereUserId($value)
 * @mixin \Eloquent
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Reservation extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'reservation';

	protected $fillable = ['checkin','checkout','code', 'room_id', 'start_time', 'end_time', 'number_of_guests', 'nights', 'per_night', 'subtotal', 'cleaning', 'additional_guest', 'security', 'service', 'host_fee', 'total','coupon_code', 'coupon_amount', 'base_per_night'];
	protected $appends = ['created_at_timer','status_color','receipt_date', 'dates_subject', 'checkin_arrive', 'checkout_depart', 'guests', 'host_payout', 'guest_payout', 'admin_host_payout', 'admin_guest_payout', 'checkin_md', 'checkout_md', 'checkin_mdy', 'checkout_mdy','check_total', 'checkin_site_date_format', 'checkout_site_date_format', 'review_end_date','grand_total','room_category','avablity','checkinformatted','checkoutformatted','status_language','review_link','original_created_at', 'guests_text','address_url','total_additional_charge'];

	// Check reservation table user_id is equal to current logged in user id

	/**
	 * @param $id
	 *
	 * @return int
	 */
	public static function check_user($id)
	{
		$host_id = Rooms::find($id)->user_id;
		if($host_id == Auth::user()->id)
			return 1;
		else
			return 0;
	}

	// Join with rooms table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
	{
		if(@$this->attributes['list_type'] == 'Experiences')
		{
			return $this->host_experiences();
		}
		else
		{
			return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_experiences()
	{
		return $this->belongsTo('App\Models\HostExperiences','room_id','id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function guest_details()
	{
		return $this->hasMany('App\Models\ReservationGuestDetails', 'reservation_id', 'id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\BelongsTo|null|object
	 */
	public function getRoomsAttribute()
	{
		return $this->rooms()->first();
	}

	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
	{
		return $this->belongsTo('App\Models\Front\User','user_id','id');
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_users()
	{
		return $this->belongsTo('App\Models\Front\User','host_id','id');
	}

	// Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
	{
		return $this->belongsTo('App\Models\Front\Currency','original_currency_code','code');
	}
	// Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function refund_currency()
	{
		return $this->belongsTo('App\Models\Front\Currency','paypal_currency','code');
	}

	// Join with messages table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function messages()
	{
		return $this->belongsTo('App\Models\Messages','id','reservation_id');
	}

	// Join with special_offer table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|\Illuminate\Database\Query\Builder
	 */
	public function special_offer()
	{
		return $this->belongsTo('App\Models\SpecialOffer','id','reservation_id')->latest();
	}
	// Join with special_offer table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function special_offer_details()
	{
		return $this->belongsTo('App\Models\SpecialOffer','special_offer_id','id');
	}

	// Join with payouts table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function payouts()
	{
		return $this->belongsTo('App\Models\Front\Payouts','id','reservation_id');
	}

	// Join with host_penalty table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_penalty()
	{
		return $this->belongsTo('App\Models\HostPenalty','id','reservation_id');
	}

	// Join with reviews table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function reviews()
	{
		return $this->hasMany('App\Models\Reviews','reservation_id','id');
	}

	// Join with payout preferences table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_payout_preferences()
	{
		return $this->belongsTo('App\Models\Front\PayoutPreferences','host_id','user_id')->where('default','Yes');
	}

	// Join with payout preferences table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function guest_payout_preferences()
	{
		return $this->belongsTo('App\Models\Front\PayoutPreferences','user_id','user_id')->where('default','Yes');
	}
	// Get Review Details using Review ID

	/**
	 * @param $id
	 *
	 * @return \App\Models\Reviews|\App\Models\Reviews[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
	 */
	public function review_details($id)
	{
		return Reviews::find($id);
	}

	// Get Review User Details using User ID

	/**
	 * @param $id
	 *
	 * @return \App\Models\Front\User|\App\Models\Front\User[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
	 */
	public function review_user($id)
	{
		if($this->attributes['user_id'] == $id)
			$user_id = $this->attributes['host_id'];
		else
			$user_id = $this->attributes['user_id'];

		return @User::find($user_id);
	}

	// Get Review Remaining Days

	/**
	 * @return int|string
	 */
	public function getReviewDaysAttribute()
	{
		$start_date = $this->attributes['checkout'];
		$end_date = date('Y-m-d', strtotime($this->attributes['checkout'].' +14 days'));

		$datetime1 = new DateTime(date('Y-m-d'));
		$datetime2 = new DateTime($end_date);
		$interval = $datetime1->diff($datetime2);
		$days = $interval->format('%R%a');
		return $days+1;
	}
	// get address url

	/**
	 * @return string
	 */
	public function getAddressUrlAttribute()
	{
		$room = Rooms::find($this->attributes['room_id']);
		$address = str_slug(@$room->rooms_address->city,'-').'-'.str_slug(@$room->rooms_address->state,'-').'-'.str_slug(@$room->name,'-');
		return $address;
	}
	// Get Review Remaining Days

	/**
	 * @return false|string
	 */
	public function getReviewEndDateAttribute()
	{
		$start_date = $this->attributes['checkout'];
		$end_date = date('Y-m-d', strtotime($this->attributes['checkout'].' +14 days'));

		return $end_date;
	}

	// Get Host Payout Email ID

	/**
	 * @return mixed
	 */
	public function getHostPayoutEmailIdAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['host_id'])->where('default','yes')->get();
		return @$payout[0]->paypal_email;
	}

	/**
	 * @return mixed
	 */
	public function getRoomCategoryAttribute()
	{
		$rooms = Rooms::where('id',$this->attributes['room_id'])->get();
		$property_type = RoomType::where('id',@$rooms[0]->room_type)->get();
		return @$property_type[0]->name;
	}

	// Get Guest Payout Email ID

	/**
	 * @return mixed
	 */
	public function getGuestPayoutCurrencyAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['user_id'])->where('default','yes')->get();
		return @$payout[0]->currency_code;
	}

	// Get Guest Payout Email ID

	/**
	 * @return mixed
	 */
	public function getPaypalCurrencyAttribute()
	{
		if($this->attributes['paypal_currency']!=null)
		{
			return @$this->attributes['paypal_currency'];
		}
		else
		{
			$payout = PayoutPreferences::where('user_id',$this->attributes['user_id'])->where('default','yes')->get();
			return @$payout[0]->currency_code;
		}
	}

	// Get Host Payout Email ID

	/**
	 * @return mixed
	 */
	public function getHostPayoutCurrencyAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['host_id'])->where('default','yes')->get();
		return @$payout[0]->currency_code;
	}

	// Get Guest Payout Email ID


	/**
	 * @return mixed
	 */
	public function getGuestPayoutEmailIdAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['user_id'])->where('default','yes')->get();
		return @$payout[0]->paypal_email;
	}

	// Get Host Payout ID

	/**
	 * @return mixed
	 */
	public function getHostPayoutIdAttribute()
	{
		$payout = Payouts::where('user_id',$this->attributes['host_id'])->where('reservation_id', $this->attributes['id'])->get();
		return @$payout[0]->id;
	}

	// Get Guest Payout ID

	/**
	 * @return mixed
	 */
	public function getGuestPayoutIdAttribute()
	{
		$payout = Payouts::where('user_id',$this->attributes['user_id'])->where('reservation_id', $this->attributes['id'])->get();
		return @$payout[0]->id;
	}

	// Get Host Payout Preference ID


	/**
	 * @return mixed
	 */
	public function getHostPayoutPreferenceIdAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['host_id'])->where('default','yes')->get();
		return @$payout[0]->id;
	}

	// Get Guest Payout Preference ID

	/**
	 * @return mixed
	 */
	public function getGuestPayoutPreferenceIdAttribute()
	{
		$payout = PayoutPreferences::where('user_id',$this->attributes['user_id'])->where('default','yes')->get();
		return @$payout[0]->id;
	}

	// Check Host is eligible or not for amount transfer using Payouts table

	/**
	 * @return string
	 */
	public function getCheckHostPayoutAttribute()
	{
		$check = Payouts::where('reservation_id', $this->attributes['id'])->where('user_type','host')->where('status', 'Completed')->get();

		if($check->count())
			return 'yes';
		else
			return 'no';
	}

	// Check Guest is eligible or not for amount transfer using Payouts table

	/**
	 * @return string
	 */
	public function getCheckGuestPayoutAttribute()
	{
		$check = Payouts::where('reservation_id', $this->attributes['id'])->where('user_type','guest')->where('status', 'Completed')->get();

		if($check->count())
			return 'yes';
		else
			return 'no';
	}

	// Get Host Payout Amount

	/**
	 * @return float
	 */
	public function getHostPayoutAttribute()
	{
		$check = Payouts::where('user_id', $this->attributes['host_id'])->where('reservation_id', $this->attributes['id'])->get();

		if($check->count())

			return $check[0]->amount;
		else
			return $this->currency_calc('total') - $this->currency_calc('service') - $this->currency_calc('host_fee') + $this->currency_calc('coupon_amount');
	}

	// Get Host/Guest Total and check with the service and coupon amount

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getCheckTotalAttribute()
	{
		$host_id =  $this->attributes['host_id'];

		/*$route=@Route::getCurrentRoute();
		if($route){
		  $api_url = @$route->getPath();
		}else{
		  $api_url = '';
		}
		$url_array=explode('/',$api_url);
		if(@$url_array['0']=='api')*/
		if(request()->segment(1) == 'api')
		{
			$user = JWTAuth::parseToken()->authenticate();
			$user_id= $user->id;
		}
		else
		{
			$user_id= @Auth::user()->id;
		}

		if($host_id == $user_id)
			return $this->currency_calc('total') + $this->currency_calc('coupon_amount') - $this->currency_calc('service') - $this->currency_calc('host_fee');
		else
			return $this->currency_calc('total') ;

	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getGrandTotalAttribute()
	{
		$host_id =  $this->attributes['host_id'];

		return $this->currency_calc('subtotal') + $this->currency_calc('total_additional_charge') + $this->currency_calc('total_taxes_pay') + $this->currency_calc('coupon_amount');
	}
	// Admin host /Guest payout

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getAdminHostPayoutAttribute()
	{
		$check = Payouts::where('user_id', $this->attributes['host_id'])->where('reservation_id', $this->attributes['id'])->get();

		if($check->count())
			return $check[0]->amount;
		else
			return 0;

	}

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getAdminGuestPayoutAttribute()
	{
		$check = Payouts::where('user_id', $this->attributes['user_id'])->where('reservation_id', $this->attributes['id'])->get();

		if($check->count())
			return $check[0]->amount;
		else
			return 0;
	}



	// Get Guest Payout Amount

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getGuestPayoutAttribute()
	{
		$check = Payouts::where('user_id', $this->attributes['user_id'])->where('reservation_id', $this->attributes['id'])->get();

		if($check->count())
			return $check[0]->amount;
		else
			return $this->currency_calc('total');
		//$this->attributes['total'];
	}

	// Get Receipt Date from created_at field

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getReceiptDateAttribute()
	{
		return date('Y-m-d', strtotime($this->attributes['created_at']));
	}

	// Get Date for Email Subject

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getDatesSubjectAttribute()
	{
		if(@$this->attributes['list_type'] == 'Experiences')
			return date('Y-m-d', strtotime($this->attributes['checkin'])).', '.$this->times;
		else
			return date('Y-m-d', strtotime($this->attributes['checkin'])).' - '.date('Y-m-d', strtotime($this->attributes['checkout']));
	}

	// Get Checkin Date in dmy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinDmyAttribute()
	{
		$checkin =  date('Y-m-d', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Date in dmy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutDmyAttribute()
	{
		$checkout =  date('Y-m-d', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin Date in dmd format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinDmdAttribute()
	{
		$checkin =  date('Y-m-d', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Date in dmy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutDmdAttribute()
	{
		$checkout =  date('Y-m-d', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin Date in datepicker format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinDatepickerAttribute()
	{
		$checkin =  date('d-m-Y', strtotime($this->attributes['checkin']));
		return $checkin;
	}

	// Get Checkout Date in datepicker format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutDatepickerAttribute()
	{
		$checkout =  date('d-m-Y', strtotime($this->attributes['checkout']));
		return $checkout;
	}

	// Get Checkin Date in mdy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinMdyAttribute()
	{
		$checkin =  date('Y-m-d', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Date in mdy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutMdyAttribute()
	{
		$checkout =  date('Y-m-d', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin Date in dmy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinDmySlashAttribute()
	{
		$checkin =  date('d/m/y', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Date in dmy format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutDmySlashAttribute()
	{
		$checkout =  date('d/m/y', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin Date Site Date format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinSiteDateFormatAttribute()
	{
		$checkin =  date(env('SITE_DATE_FORMAT'), strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Date Site Date format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutSiteDateFormatAttribute()
	{
		$checkout =  date(env('SITE_DATE_FORMAT'), strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin Date in md format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinMdAttribute()
	{
		$checkin =  date('Y-m-d', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkin Arrive Date in md format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinArriveAttribute()
	{
		$checkin =  date('D, d F, Y', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	// Get Checkout Depart Date in md format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutDepartAttribute()
	{
		$checkout =  date('D, d F, Y', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkout Date in md format

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutMdAttribute()
	{
		$checkout =  date('Y-m-d', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	// Get Checkin and Checkout Dates

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getDatesAttribute()
	{
		if(@$this->attributes['list_type'] == 'Experiences')
			return date('Y-m-d', strtotime($this->attributes['checkin'])).', '.$this->times;
		else
			return date('Y-m-d', strtotime($this->attributes['checkin'])).' - '.date('Y-m-d', strtotime($this->attributes['checkout']));
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getStartTimeHiAttribute()
	{
		$start_time = date('H:i', strtotime($this->attributes['start_time']));
		return $start_time;
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getEndTimeHiAttribute()
	{
		$end_time = date('H:i', strtotime($this->attributes['end_time']));
		return $end_time;
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getTimesAttribute()
	{
		return $this->start_time_hi.' - '.$this->end_time_hi;
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getDurationAttribute()
	{
		$duration = $this->attributes['nights'];

		if(@$this->attributes['list_type'] == 'Experiences')
		{
			$start_time = @$this->attributes['start_time'];
			$end_time = @$this->attributes['end_time'];

			$diff_time = strtotime($end_time) - strtotime($start_time);
			$duration = round(($diff_time/3600), 1);
		}
		return $duration;
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getDurationTextAttribute()
	{
		$duration = $this->duration;
		$duration_text = $duration.' '.trans_choice('messages.rooms.night',$duration);
		if(@$this->attributes['list_type'] == 'Experiences')
		{
			$duration_text = $duration.' '.trans_choice('experiences.manage.hour_s', $duration);
		}
		return $duration_text;
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getDurationTypeTextAttribute()
	{
		$duration = 1;
		$duration_text = trans_choice('messages.rooms.night',$duration);
		if(@$this->attributes['list_type'] == 'Experiences')
		{
			$duration_text = trans_choice('experiences.manage.hour_s', $duration);
		}
		return $duration_text;
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getGuestsTextAttribute()
	{
		$guests = $this->attributes['number_of_guests'];
		$guests_text = $guests.' '.trans_choice('messages.home.guest', $guests);
		return $guests_text;
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getSubtotalMultiplyTextAttribute()
	{
		if(@$this->attributes['list_type']=='Experiences')
			return $this->guests_text;
		else
			return $this->duration_text;
	}

	// Get Created At Timer for Expired

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCreatedAtTimerAttribute()
	{
		$expired_at =  date('Y/m/d H:i:s', strtotime(str_replace('-','/',$this->attributes['created_at']).' +1 day'));
		return $expired_at;
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getPerNightAttribute()
	{
		return $this->currency_calc('per_night');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getSubtotalAttribute()
	{
		return $this->currency_calc('subtotal');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getCleaningAttribute()
	{
		return $this->currency_calc('cleaning');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getAdditionalGuestAttribute()
	{
		return $this->currency_calc('additional_guest');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getTotalAdditionalChargeAttribute(){
		return $this->currency_calc('total_additional_charge');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getSecurityAttribute()
	{
		return $this->currency_calc('security');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getServiceAttribute()
	{
		return $this->currency_calc('service');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getHostFeeAttribute()
	{
		return $this->currency_calc('host_fee');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getCouponAmountAttribute()
	{
		return $this->currency_calc('coupon_amount');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getTotalAttribute()
	{
		return $this->currency_calc('total');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getPayoutAttribute()
	{
		return $this->currency_calc('payout');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getBasePerNightAttribute()
	{
		return $this->currency_calc('base_per_night');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getLengthOfStayDiscountPriceAttribute()
	{
		return $this->currency_calc('length_of_stay_discount_price');
	}

	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getBookedPeriodDiscountPriceAttribute()
	{
		return $this->currency_calc('booked_period_discount_price');
	}
	// 

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalPerNightAttribute()
	{
		return $this->attributes['per_night'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalSubtotalAttribute()
	{
		return $this->attributes['subtotal'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalCleaningAttribute()
	{
		return $this->attributes['cleaning'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalAdditionalGuestAttribute()
	{
		return $this->attributes['additional_guest'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalTotalAdditionalChargeAttribute(){
		return $this->attributes['total_additional_charge'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalSecurityAttribute()
	{
		return $this->attributes['security'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalServiceAttribute()
	{
		return $this->attributes['service'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalHostFeeAttribute()
	{
		return $this->attributes['host_fee'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalCouponAmountAttribute()
	{
		return $this->attributes['coupon_amount'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalTotalAttribute()
	{
		return $this->attributes['total'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalPayoutAttribute()
	{
		return $this->attributes['payout'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalBasePerNightAttribute()
	{
		return $this->attributes['base_per_night'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalLengthOfStayDiscountPriceAttribute()
	{
		return $this->attributes['length_of_stay_discount_price'];
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalBookedPeriodDiscountPriceAttribute()
	{
		return $this->attributes['booked_period_discount_price'];
	}


	// Get value of Checkin crossed days

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getCheckinCrossAttribute()
	{
		$date1=date_create($this->attributes['checkin']);
		$date2=date_create(date('Y-m-d'));
		$diff=date_diff($date1,$date2);
		if($date2 < $date1 )
			return 1;
		else
			return 0;
		// return $diff->format("%a");
	}

	// Get value of Checkout crossed days

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getCheckoutCrossAttribute()
	{
		$date1=date_create($this->attributes['checkout']);
		$date2=date_create(date('Y-m-d'));

		if($date2 > $date1 )
			return 1;
		else
			return 0;
	}

	// Calculation for current currency conversion of given price field

	/**
	 * @param $field
	 *
	 * @return float
	 */
	/**
	 * @param $field
	 *
	 * @return float
	 */
	/**
	 * @param $field
	 *
	 * @return float
	 */
	public function currency_calc($field)
	{

		/*$route=@Route::getCurrentRoute();
		if($route){
		  $api_url = @$route->getPath();
		}else{
		  $api_url = '';
		}

		$url_array=explode('/',$api_url);
		  //Api currency conversion
		if(@$url_array['0']=='api')*/
		if(request()->segment(1) == 'api')
		{
			$user_details = JWTAuth::parseToken()->authenticate();

			$rate = Currency::whereCode($this->attributes['currency_code'])->first()->rate;

			$usd_amount = $this->attributes[$field] / $rate;

			$api_currency = $user_details->currency_code;

			$default_currency = Currency::where('default_currency',1)->first()->code;

			$session_rate = Currency::whereCode($user_details->currency_code!=null?$user_details->currency_code :$default_currency)->first()->rate;

			return round($usd_amount * $session_rate);

		}
		else
		{
			$rate = Currency::whereCode($this->attributes['currency_code'])->first()->rate;

			$usd_amount = @$this->attributes[$field] / @$rate;

			$default_currency = Currency::where('default_currency',1)->first()->code;

			$session_rate = Currency::whereCode($default_currency)->first()->rate;

			//todo-vr add option to allow admins and users to enable/disable currency conversion based on user's ip address
			// $session_rate = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;

			return round($usd_amount * $session_rate);
		}

	}

	// Get default currency code if session is not set

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getCurrencyCodeAttribute()
	{
		if(request()->segment(1)  == 'api')
		{
			$user_details = JWTAuth::parseToken()->authenticate();
			return $user_details->currency_code;
		}
		if(Session::get('currency'))
			return Session::get('currency');
		else
			return DB::table('currency')->where('default_currency', 1)->first()->code;
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalCurrencyCodeAttribute()
	{
		return $this->attributes['currency_code'];
	}

	// Set Reservation Status Color

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getStatusColorAttribute()
	{
		if(@$this->attributes['type'] == 'contact')
			return 'inquiry';
		else if($this->attributes['status'] == 'Accepted')
			return 'success';
		else if($this->attributes['status'] == 'Expired')
			return 'info';
		else if($this->attributes['status'] == 'Pending')
			return 'warning';
		else if($this->attributes['status'] == 'Declined')
			return 'info';
		else if($this->attributes['status'] == 'Cancelled')
			return 'info';
		else
			return '';
	}

	// Get Reservation Status

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getStatusAttribute()
	{
		if(@$this->attributes['status'] == null)
			return 'Inquiry';
		else
			return $this->attributes['status'];
	}

	// Get Guest Count with Plural

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getGuestsAttribute()
	{
		if($this->attributes['number_of_guests'] > 1)
		{
			$plural = ($this->attributes['number_of_guests']-1 > 1) ? 's':'';
			return '+'.($this->attributes['number_of_guests']-1).' Guest'.$plural;
		}
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function calendar() {
		return $this->hasMany('App\Models\Front\Calendar', 'room_id', 'room_id');
	}

	// Get This reservation date is avaablie

	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getAvablityAttribute()
	{
		if(isset($this->attributes['date_check'])) {
			if(@$this->attributes['date_check'] == 'No') {
				return 1;
			}
			else {
				$calendar_not_available = $this->calendar()->where('date','>=',$this->attributes['checkin'])->where('date', '<', $this->attributes['checkout'])->notAvailable($this->attributes['number_of_guests'])->get();
				if($calendar_not_available->count() > 0) {
					@$this->attributes['date_check'] = 'No';
					@$this->save();
					return 1;
				}
				else {
					return 0;
				}
			}
		}
	}

	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	public function getBookedReservationAttribute()
	{
		$booked_room = Reservation::where('id',$this->attributes['id'])->where('status','Accepted')->count();
		if($booked_room)
			return false;
		else
			return true;
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckinFormattedAttribute(){
		$checkin = date('Y-m-d', strtotime($this->attributes['checkin']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkin .= ' '.$this->start_time_hi;
		return $checkin;
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCheckoutFormattedAttribute(){
		$checkout = date('Y-m-d', strtotime($this->attributes['checkout']));
		if(@$this->attributes['list_type'] == 'Experiences')
			$checkout .= ' '.$this->end_time_hi;
		return $checkout;
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCreatedAtAttribute(){
		return date('Y-m-d'.' H:i:s',strtotime($this->attributes['created_at']));
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCancelledAtAttribute(){
		return date('Y-m-d'.' H:i:s',strtotime($this->attributes['cancelled_at']));
	}

	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	/**
	 * @return mixed
	 */
	public function getOriginalCreatedAtAttribute(){
		return $this->attributes['created_at'];
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getUpdatedAtAttribute(){
		return date('Y-m-d'.' H:i:s',strtotime($this->attributes['updated_at']));
	}

	// status_language

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getStatusLanguageAttribute()
	{
		if(@$this->attributes['status'] == null){
			return trans('messages.dashboard.Inquiry');
		} else {
			return trans('messages.dashboard.'.$this->attributes['status'].'');
		}
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getTitleClassAttribute()
	{
		if($this->list_type == "Experiences")
		{
			return 'text-rausch';
		}
		else
		{
			return '';
		}
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getReviewLinkAttribute()
	{
		$site_settings_url = @SiteSettings::where('name' , 'site_url')->first()->value;
		$url = \App::runningInConsole() ? $site_settings_url : url('/');

		if($this->list_type == "Experiences")
		{
			return $url.'/host_experience_reviews/edit/'.$this->id;
		}
		else
		{
			return $url.'/reviews/edit/'.$this->id;
		}
	}

	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	/**
	 * @return array
	 */
	public function getDiscountsListAttribute() {
		$discounts_list = [];
		$length_of_stay_type = $this->attributes['length_of_stay_type'] ?: '';
		$booked_period_type = $this->attributes['booked_period_type'] ?: '';

		$k =0;

		if($booked_period_type != '') {
			$discounts_list[$k] = array();
			if($booked_period_type == 'early_bird') {
				$type_text = trans('messages.rooms.early_bird_price_discount');
			}
			else if($booked_period_type == 'last_min') {
				$type_text = trans('messages.rooms.last_min_price_discount');
			}

			$text = @$this->attributes['booked_period_discount'].'% '.$type_text;
			$discounts_list[$k]['text'] = $text;
			$discounts_list[$k]['price'] = @$this->getBookedPeriodDiscountPriceAttribute();
			$k ++;
		}
		if($length_of_stay_type != '') {
			$discounts_list[$k] = array();
			if($length_of_stay_type == 'weekly') {
				$type_text = trans('messages.rooms.weekly_price_discount');
			}
			else if($length_of_stay_type == 'monthly') {
				$type_text = trans('messages.rooms.monthly_price_discount');
			}
			else if($length_of_stay_type == 'custom') {
				$type_text = trans('messages.rooms.long_term_price_discount');
			}

			$text = @$this->attributes['length_of_stay_discount'].'% '.$type_text;
			$discounts_list[$k]['text'] = $text;
			$discounts_list[$k]['price'] = @$this->getLengthOfStayDiscountPriceAttribute();
			$k ++;
		}
		return $discounts_list;
	}

	/*
	* Join Diputes Table
	*/
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function dispute()
	{
		return $this->belongsTo('App\Models\Disputes', 'id', 'reservation_id');
	}

	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	/**
	 * @param      $query
	 * @param null $user_id
	 *
	 * @return mixed
	 */
	public function scopeUserRelated($query, $user_id = null)
	{
		$user_id = $user_id ?: @Auth::user()->id;

		$query  = $query->where(function($query) use($user_id){
			$query->where('user_id',$user_id)->orWhere('host_id', $user_id);
		});

		return $query;
	}

	/*
	* To get the Current User relation to this reservation
	*/
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getHostOrGuestAttribute()
	{
		$host_or_guest = '';
		$current_user_id = @Auth::user()->id;
		if($this->attributes['user_id'] == $current_user_id)
		{
			$host_or_guest = 'Guest';
		}
		elseif($this->attributes['host_id'] == $current_user_id)
		{
			$host_or_guest = 'Host';
		}

		return $host_or_guest;
	}

	/*
	* To get the Maximum amount host can apply dispute
	*/
	/**
	 * @return array|mixed
	 */
	/**
	 * @return array|mixed
	 */
	/**
	 * @return array|mixed
	 */
	public function getMaximumHostDisputeAmountAttribute()
	{
		return $this->getOriginal('security');
	}

	/*
	* To get the Maximum amount guest can apply dispute
	*/
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	/**
	 * @return float
	 */
	public function getMaximumGuestDisputeAmountAttribute()
	{
		$guest_payout = Payouts::where('user_id', $this->attributes['user_id'])->where('reservation_id', $this->attributes['id'])->first();

		$guest_payout_amount = $this->attributes['total'] - $this->attributes['service'] - $this->attributes['coupon_amount'];
		if($guest_payout)
		{
			$original_guest_payout_amount = $guest_payout->getOriginal('amount');
			$guest_payout_amount -= $guest_payout->currency_convert($guest_payout->getOriginal('currency_code'), $this->attributes['currency_code'], $original_guest_payout_amount);
		}

		return $guest_payout_amount;
	}

	/*
	* To get the Maximum amount can current user can apply dispute
	*/
	/**
	 * @return array|float|int|mixed
	 */
	/**
	 * @return array|float|int|mixed
	 */
	/**
	 * @return array|float|int|mixed
	 */
	public function getMaximumDisputeAmountAttribute()
	{
		$host_or_guest = $this->getHostOrGuestAttribute();
		if($host_or_guest == 'Guest')
		{
			return $this->getMaximumGuestDisputeAmountAttribute();
		}
		else if($host_or_guest == 'Host')
		{
			return $this->getMaximumHostDisputeAmountAttribute();
		}
		else
		{
			return 0;
		}
	}

	/*
	* To get the last date to apply for the dispute
	*/
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getLastDateForDisputeAttribute()
	{
		$start_date = date('Y-m-d', strtotime(' -15 days'));

		if($this->attributes['status'] == 'Cancelled')
		{
			$start_date = date('Y-m-d', strtotime($this->attributes['cancelled_at']));
		}
		else if($this->attributes['status'] == 'Accepted')
		{
			if(date('Y-m-d') > $this->attributes['checkout'])
			{
				$start_date = $this->attributes['checkout'];
			}
		}

		$end_date = date('Y-m-d', strtotime($start_date.' +14 days'));
		return $end_date;
	}

	/*
	* To get the remaining days to apply for dispute
	*/
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	/**
	 * @return int
	 */
	public function getRemainingDaysForDisputeAttribute()
	{
		$remaining_days_for_dispute = 0;
		$last_date_for_dispute = $this->getLastDateForDisputeAttribute();

		$today_date = new DateTime(date('Y-m-d'));
		$last_date = new DateTime($last_date_for_dispute);
		$interval = $today_date->diff($last_date);

		// $remaining_days_for_dispute = $interval->format('%R%a');

		return $remaining_days_for_dispute;
	}

	/*
	* To check if the current user can apply for the dispute
	*/
	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	/**
	 * @return bool
	 */
	public function getCanApplyForDisputeAttribute()
	{
		$remaining_days_for_dispute = $this->getRemainingDaysForDisputeAttribute();
		$maximuim_dispute_amount = $this->getMaximumDisputeAmountAttribute();
		$already_applied_dispute = $this->dispute()->count();

		$can_apply_dipute = true;
		if( ($remaining_days_for_dispute <= 0) || ($maximuim_dispute_amount <= 0) || ($already_applied_dispute > 0) )
		{
			$can_apply_dipute = false;
		}

		return $can_apply_dipute;
	}

	/**
	 * To check if the payout button can show
	 *
	 * @return bool $can_payout_button_show
	 **/
	function can_payout_button_show()
	{
		$date1=date_create($this->attributes['checkout']);
		$date2=date_create(date('Y-m-d'));

		$checkout_cross = 0;

		if($date2 > $date1)
		{
			$checkout_cross = 1;
		}
		$open_dipsutes = Disputes::reservationBased($this->attributes['id'])->status('Open')->count();

		return (!$this->getCanApplyForDisputeAttribute() && !$open_dipsutes && ($checkout_cross || $this->attributes['status'] == 'Cancelled'));
	}

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getCreatedAtDateAttribute(){
		return date('Y-m-d',strtotime($this->attributes['created_at']));
	}


	// Calculation for current currency conversion of given amount

	/**
	 * @param string $from
	 * @param string $to
	 * @param        $price
	 *
	 * @return float
	 */
	/**
	 * @param string $from
	 * @param string $to
	 * @param        $price
	 *
	 * @return float
	 */
	/**
	 * @param string $from
	 * @param string $to
	 * @param        $price
	 *
	 * @return float
	 */
	public function currency_convert($from = '', $to = '', $price)
	{
		if($from == '')
		{
			if(Session::get('currency'))
				$from = Session::get('currency');
			else
				$from = Currency::where('default_currency', 1)->first()->code;
		}

		if($to == '')
		{
			if(Session::get('currency'))
				$to = Session::get('currency');
			else
				$to = Currency::where('default_currency', 1)->first()->code;
		}

		$rate = Currency::whereCode($from)->first()->rate;

		$usd_amount = $price / $rate;

		$session_rate = Currency::whereCode($to)->first()->rate;

		return round($usd_amount * $session_rate);
	}

	/**
	 * Generate Reservation Code
	 *
	 * @param date $length  Code Length
	 * @param date $seed    Reservation Id
	 * @return string Reservation Code
	 */
	public function getReservationCode($length, $seed)
	{
		$code = "";
		$codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$codeAlphabet.= "0123456789";

		mt_srand($seed);

		for($i=0;$i<$length;$i++) {
			$code .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
		}

		return $code;
	}

	 /**
     * Additional Charge Attribute
     * @return mixed
     */
    public function getAdditionalChargeAttribute() {

        //check if the additional charge is in the old format, if yes we do our magic on the old format
        $additional_charge = json_decode($this->attributes['additional_charge']);
        if(is_object($additional_charge) && $additional_charge != NULL) { 

            return $this->setAdditionalChargeOld();
        }


        //if not in old format, we just return the additional_charge attribute like normal        
        return $this->attributes['additional_charge'];
    }

    /**
     * Reformat & set the old additional charge json format
     *
     */
    public function setAdditionalChargeOld() {
        //reformat the old additional charge json object into new additional charge format       
        $new_additional_charge = [];
        
        foreach(json_decode($this->attributes['additional_charge']) as $key => $val) { 
            $charge = new \stdClass;
            $charge->label = $key;
            $charge->price = $val;
            $charge->price_type = 1;    // $, not %
            $charge->calc_type = 0; // single fee
            $charge->guest_opt = 1;     // no option
            $new_additional_charge[] = $charge;
        }
        return json_encode($new_additional_charge);
    }

}
