<?php

/**
 * SpecialOffer Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    SpecialOffer
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Models\SpecialOffer
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $room_id
 * @property int $user_id
 * @property string $checkin
 * @property string $checkout
 * @property int $number_of_guests
 * @property int $price
 * @property string $currency_code
 * @property string $type
 * @property string $created_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Calendar[] $calendar
 * @property-read \App\Models\Front\Currency $currency
 * @property-read mixed $avablity
 * @property-read mixed $checkin_arrive
 * @property-read mixed $checkout_depart
 * @property-read mixed $dates
 * @property-read mixed $dates_subject
 * @property-read mixed $is_booked
 * @property-read \App\Models\Messages $messages
 * @property-read \App\Models\Front\Rooms $rooms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereCheckin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereCheckout($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereNumberOfGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SpecialOffer whereUserId($value)
 * @mixin \Eloquent
 */
class SpecialOffer extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'special_offer';

    public $timestamps = false;

    public $appends = ['dates_subject', 'checkin_arrive', 'checkout_depart', 'dates'];

	/**
	 * @param $value
	 */
	public function setCheckinAttribute($value)
    {
        $this->attributes['checkin'] = date('Y-m-d', strtotime($value));
    }

	/**
	 * @param $value
	 */
	public function setCheckoutAttribute($value)
    {
        $this->attributes['checkout'] = date('Y-m-d', strtotime($value));
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
    {
      return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
    }

    // Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
    {
      return $this->belongsTo('App\Models\Front\Currency','currency_code','code');
    }

    // Join with messages table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function messages()
    {
      return $this->belongsTo('App\Models\Messages','id','special_offer_id');
    }

	/**
	 * @return float
	 */
	public function getPriceAttribute()
    {
        return $this->currency_calc('price');
    }

	/**
	 * @return bool
	 */
	public function getIsBookedAttribute()
    {
         $booked_remove_offer = Reservation::where('special_offer_id',$this->attributes['id'])->count();
         if($booked_remove_offer)
         return false;
         else
         return true;
    }

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
	public function getAvablityAttribute()
    {
      $calendar_not_available = $this->calendar()->where('date','>=',$this->attributes['checkin'])->where('date', '<', $this->attributes['checkout'])->where('status', 'Not available')->get();
      if($calendar_not_available->count() > 0) {
        return 1;
      } 
      else {
        return 0;
      }
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

    // Get Checkin Arrive Date in md format

	/**
	 * @return false|string
	 */
	public function getCheckinArriveAttribute()
    {
      $checkin =  date(PHP_DATE_FORMAT, strtotime($this->attributes['checkin']));
      return $checkin;
    }

    // Get Checkout Depart Date in md format

	/**
	 * @return false|string
	 */
	public function getCheckoutDepartAttribute()
    {
      $checkout =  date(PHP_DATE_FORMAT, strtotime($this->attributes['checkout']));
      return $checkout;
    }

    // Get Date for Email Subject

	/**
	 * @return string
	 */
	public function getDatesSubjectAttribute()
    {
      return date(PHP_DATE_FORMAT, strtotime($this->attributes['checkin'])).' - '.date(PHP_DATE_FORMAT, strtotime($this->attributes['checkout']));
    }

    // Get Checkin and Checkout Dates

	/**
	 * @return string
	 */
	public function getDatesAttribute()
    {
      return date(PHP_DATE_FORMAT, strtotime($this->attributes['checkin'])).' - '.date(PHP_DATE_FORMAT, strtotime($this->attributes['checkout']));
    }
}
