<?php

/**
 * Applied Travel Credit Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Applied Travel Credit
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Models\AppliedTravelCredit
 *
 * @property int $id
 * @property int $reservation_id
 * @property int $referral_id
 * @property int $amount
 * @property string $type
 * @property string $currency_code
 * @property-read mixed $original_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereReferralId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereReservationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AppliedTravelCredit whereType($value)
 * @mixin \Eloquent
 */
class AppliedTravelCredit extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'applied_travel_credit';

    public $timestamps = false;

    // Get Amount

	/**
	 * @return float
	 */
	public function getAmountAttribute()
    {
        return $this->currency_calc('amount');
    }

    // Get Original Amount

	/**
	 * @return mixed
	 */
	public function getOriginalAmountAttribute()
    {
        return $this->attributes['amount'];
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
