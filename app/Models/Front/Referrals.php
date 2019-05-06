<?php

/**
 * Referrals Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Referrals
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;
use DateTime;
use DateTimeZone;
use Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Session;
use Log;

/**
 * Class Referrals
 *
 * @package App\Models
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property int $credited_amount
 * @property int $friend_credited_amount
 * @property int $if_friend_guest_amount
 * @property int $if_friend_host_amount
 * @property int $creditable_amount
 * @property string $currency_code
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\Currency $currency
 * @property-read \App\Models\Front\User $friend_users
 * @property-read mixed $booking_count
 * @property-read mixed $if_friend_guest_amount_original
 * @property-read mixed $if_friend_host_amount_original
 * @property-read mixed $listing_count
 * @property-read mixed $referee_name
 * @property-read mixed $referrer_name
 * @property-read mixed $signup_count
 * @property-read \App\Models\Front\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereCreditableAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereCreditedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereFriendCreditedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereIfFriendGuestAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereIfFriendHostAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals whereUserId($value)
 * @mixin \Eloquent
 * @property-read string $created_time
 * @property-read mixed $referral_count
 * @property-read string $referral_full_name
 * @property-read string $referrer_full_name
 * @property-read mixed $status_color
 * @property-read int $total_booking_count
 * @property-read int $total_listing_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals friendUsers()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Referrals users()
 */
class Referrals extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'referrals';
	protected $fillable = ['user_id', 'friend_id', 'credited_amount', 'status', 'currency_code'];
	protected $appends = ['referrer_name','referrer_full_name','referral_full_name', 'referee_name','referral_count', 'signup_count', 'total_booking_count', 'total_listing_count'];

	/**
	 * @return float
	 */
	public function getCreditedAmountAttribute()
	{
		return $this->currency_calc('credited_amount');
	}

	/**
	 * @return float
	 */
	public function getFriendCreditedAmountAttribute()
	{
		return $this->currency_calc('friend_credited_amount');
	}

	/**
	 * @return float
	 */
	public function getIfFriendGuestAmountAttribute()
	{
		return $this->currency_calc('if_friend_guest_amount');
	}

	/**
	 * @return mixed
	 */
	public function getIfFriendGuestAmountOriginalAttribute()
	{
		return $this->attributes['if_friend_guest_amount'];
	}

	/**
	 * @return mixed
	 */
	public function getIfFriendHostAmountOriginalAttribute()
	{
		return $this->attributes['if_friend_host_amount'];
	}

	/**
	 * @return float
	 */
	public function getIfFriendHostAmountAttribute()
	{
		return $this->currency_calc('if_friend_host_amount');
	}

	/**
	 * @return float
	 */
	public function getCreditableAmountAttribute()
	{
		return $this->currency_calc('creditable_amount');
	}

	// Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
	{
		return $this->belongsTo('App\Models\Front\Currency','currency_code','code');
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
	 * @param $query
	 */
	public function scopeUsers($query)
	{
		$query = $query->with(['users' => function($query){
			$query->with(['profile_picture']);
		}]);
	}

	// Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function friend_users()
	{
		return $this->belongsTo('App\Models\Front\User','friend_id','id');
	}

	/**
	 * @param $query
	 */
	public function scopeFriendUsers($query)
	{
		$query = $query->with(['friend_users' => function($query){
			$query->with(['profile_picture']);
		}]);
	}

	/**
	 * @return mixed
	 */
	public function getReferrerNameAttribute()
	{
		return User::find($this->attributes['user_id'])->first_name;
	}

	/**
	 * @return string
	 */
	public function getReferrerFullNameAttribute()
	{
		$first_name = User::find($this->attributes['user_id'])->first_name;
		$last_name = User::find($this->attributes['user_id'])->last_name;
		$full_name = $first_name . ' ' . $last_name;
		return  $full_name;
	}

	/**
	 * @return mixed
	 */
	public function getRefereeNameAttribute()
	{
		return User::find($this->attributes['friend_id'])->first_name;
	}

	/**
	 * @return string
	 */
	public function getReferralFullNameAttribute()
	{
		$first_name = User::find($this->attributes['friend_id'])->first_name;
		$last_name = User::find($this->attributes['friend_id'])->last_name;
		$full_name = $first_name . ' ' . $last_name;
		return $full_name;
	}

	/**
	 * @return mixed
	 */
	public function getReferralCountAttribute()
	{
		return Referrals::whereUserId($this->attributes['user_id'])->count();
	}

	/**
	 * @return mixed
	 */
	public function getSignupCountAttribute()
	{
		return Referrals::whereUserId($this->attributes['user_id'])->get()->count();
	}

	/**
	 * @return int
	 */
	public function getTotalBookingCountAttribute()
	{
		$count = 0;
		$result = Referrals::whereUserId($this->attributes['user_id'])->get();
		foreach($result as $row) {
			$reservation_count = Reservation::whereUserId($row->friend_id)->get()->count();
			$count += $reservation_count;
		}
		return $count;
	}

	/**
	 * @return int
	 */
	public function getTotalListingCountAttribute()
	{
		$count = 0;
		$result = Referrals::whereUserId($this->attributes['user_id'])->get();
		foreach($result as $row) {
			$listing_count = Rooms::where('rooms.user_id', $row->friend_id)
							->join('rooms_approved_status', function($join) {
                                $join->on('rooms.id', '=', 'rooms_approved_status.room_id')
                                     ->where('rooms_approved_status.approved_status', '1');
                            })->get()->count();
			$count += $listing_count;
		}
		return $count;
	}

	/**
	 * @param $id
	 *
	 * @return string
	 */
	public function booking_status($id)
	{
		$count = Reservation::whereUserId($id)->get()->count();

		return ($count) ? 'Yes' : 'No';
	}

	/**
	 * @param $id
	 *
	 * @return string
	 */
	public function listing_status($id)
	{
		$count = Rooms::whereUserId($id)->get()->count();

		return ($count) ? 'Yes' : 'No';
	}

	// Calculation for current currency conversion of given price field

	/**
	 * @param $field
	 *
	 * @return float
	 */
	public function currency_calc($field)
	{
		$rate = Currency::whereCode($this->attributes['currency_code'])->first()->rate;

		$usd_amount = $this->attributes[$field] / $rate;

		$default_currency = Currency::where('default_currency',1)->first()->code;

		$session_rate = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;

		return round($usd_amount * $session_rate);
	}

	/**
	 * @return false|string
	 */
	public function getCreatedAtAttribute(){
		return date(PHP_DATE_FORMAT,strtotime($this->attributes['created_at']));
	}

	// Get Created at Time for Referral Listed

	/**
	 * @return string
	 */
	public function getCreatedTimeAttribute()
	{
		$new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));
		$new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));

		return date(PHP_DATE_FORMAT,strtotime($this->attributes['updated_at'])).' at '.$new_str->format('h:i A');
	}

	// Set Reservation Status Color

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getStatusColorAttribute()
	{
		if($this->attributes['status'] == 'Completed')
			return 'success';
		else if($this->attributes['status'] == 'Pending')
			return 'warning';
		else
			return '';
	}
}
