<?php

/**
 * Currency Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Currency
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;

/**
 * App\Models\Front\Currency
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $symbol
 * @property float $rate
 * @property string $status
 * @property string $default_currency
 * @property string $paypal_currency
 * @property-read mixed $original_symbol
 * @property-read mixed $session_code
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereDefaultCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency wherePaypalCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Currency whereSymbol($value)
 * @mixin \Eloquent
 */
class Currency extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'currency';

    public $timestamps = false;

    protected $appends = ['original_symbol'];

    // Get default currency symbol if session is not set

	/**
	 * @return mixed
	 */
	public function getSymbolAttribute()
    {
        if(Session::get('symbol'))
           return Session::get('symbol');
        else
           return DB::table('currency')->where('default_currency', 1)->first()->symbol;
    }

    // Get default currency symbol if session is not set

	/**
	 * @return mixed
	 */
	public function getSessionCodeAttribute()
    {
        if(Session::get('currency'))
           return Session::get('currency');
        else
           return DB::table('currency')->where('default_currency', 1)->first()->code;
    }

    // Get symbol by where given code

	/**
	 * @param $code
	 *
	 * @return mixed
	 */
	public static function original_symbol($code)
    {
    	$symbol = DB::table('currency')->where('code', $code)->first()->symbol;
    	return $symbol;
    }

    // Get currenct record symbol

	/**
	 * @return mixed
	 */
	public function getOriginalSymbolAttribute()
    {
        $symbol = $this->attributes['symbol'];
        return $symbol;
    }
}
