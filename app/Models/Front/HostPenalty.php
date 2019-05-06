<?php

/**
 * Email Settings Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Email Settings
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://abv.com
 */


namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Models\HostPenalty
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_id
 * @property int $reservation_id
 * @property string $currency_code
 * @property int $amount
 * @property int $remain_amount
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $converted_amount
 * @property-read mixed $converted_remain_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereRemainAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostPenalty whereUserId($value)
 * @mixin \Eloquent
 */
class HostPenalty extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_penalty';

    // Get Penalty Amount

	/**
	 * @return float
	 */
	public function getConvertedAmountAttribute()
    {
        return $this->currency_calc('amount');
    }

    // Get Penalty Remaining Amount

	/**
	 * @return float
	 */
	public function getConvertedRemainAmountAttribute()
    {
        return $this->currency_calc('remain_amount');
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
}
