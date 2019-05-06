<?php

/**
 * Payouts Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Payouts
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

/**
 * App\Models\Front\Payouts
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $room_id
 * @property string $list_type
 * @property string $spots
 * @property string $correlation_id
 * @property int $user_id
 * @property string $user_type
 * @property string $account
 * @property int $amount
 * @property string $currency_code
 * @property string $status
 * @property string $penalty_id
 * @property string $penalty_amount
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $currency_symbol
 * @property-read mixed $date
 * @property-read mixed $spots_array
 * @property-read mixed $total_penalty_amount
 * @property-read \App\Models\Front\Reservation $reservation
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereCorrelationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereListType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts wherePenaltyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts wherePenaltyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereSpots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Payouts whereUserType($value)
 * @mixin \Eloquent
 */
class Payouts extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payouts';

    public $appends = ['currency_symbol', 'date'];

    protected $fillable = ['user_id', 'reservation_id'];

    // Get Payout Amount

	/**
	 * @return float
	 */
	public function getAmountAttribute()
    {
        return $this->currency_calc('amount');
    }

    // Get Date with new format

	/**
	 * @return false|string
	 */
	public function getDateAttribute()
    {
        //return date('d-m-Y', strtotime($this->attributes['updated_at']));
        return date(PHP_DATE_FORMAT, strtotime($this->attributes['updated_at']));
    }

    // Get Date with new format

	/**
	 * @return float|int
	 */
	public function getTotalPenaltyAmountAttribute()
    {
        $penalty_ids = explode(',', $this->attributes['penalty_id']) ?: array();
        $penalty_amts = explode(',', $this->attributes['penalty_amount']) ?: array();
        $penalty_currencies  = HostPenalty::select('currency_code')->whereIn('id', $penalty_ids)->get()->pluck('currency_code');

        $penalty_amount_converted = array();
        foreach($penalty_ids as $k => $id)
        {
            $penalty_amount_converted[] = $this->currency_convert(@$penalty_currencies[$k], '', @$penalty_amts[$k]);
        }
        return array_sum($penalty_amount_converted);
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

    // Calculation for current currency conversion of given amount

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

    // Get default currency code if session is not set

	/**
	 * @return mixed
	 */
	public function getCurrencyCodeAttribute()
    {
        if(Session::get('currency'))
           return Session::get('currency');
        else
           return DB::table('currency')->where('default_currency', 1)->first()->code;
    }

    // Get Currency Symbol

	/**
	 * @return mixed
	 */
	public function getCurrencySymbolAttribute()
    {
        $default_currency = Currency::where('default_currency',1)->first()->code;

        return DB::table('currency')->where('code', (Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->symbol;
    }

	/**
	 * @return array
	 */
	public function getSpotsArrayAttribute()
    {
        $spots_array = explode(',', @$this->attributes['spots']);
        $spots_array = array_map('intval', $spots_array);
        return $spots_array;
    }

   // Join to Reservation table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function reservation()
    {
        return $this->belongsTo('App\Models\Front\Reservation','reservation_id','id');
    }
}
