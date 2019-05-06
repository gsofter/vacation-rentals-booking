<?php

/**
 * ReferralSettings Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    ReferralSettings
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Models\ReferralSettings
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReferralSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReferralSettings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ReferralSettings whereValue($value)
 * @mixin \Eloquent
 */
class ReferralSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'referral_settings';

    public $timestamps = false;

	/**
	 * @param        $id
	 * @param string $currency
	 *
	 * @return float|mixed|string
	 */
	public static function value($id, $currency = 'symbol')
    {
    	$result = ReferralSettings::find($id);

        if($result->name != 'currency_code') {
            $amount           = $result->value;

            $currency_code    = ReferralSettings::whereName('currency_code')->first()->value;

            $rate             = Currency::whereCode($currency_code)->first()->rate;

            $usd_amount       = $amount / $rate;

            $default_currency = Currency::where('default_currency',1)->first()->code;

            $session_rate     = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;

            return round($usd_amount * $session_rate);
        }
        else {
            $default_currency = Currency::where('default_currency',1)->first()->code;

            $currency_code    = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->$currency;
            
            return $currency_code;
        }
    }
}
