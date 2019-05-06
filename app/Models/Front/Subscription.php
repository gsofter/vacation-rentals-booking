<?php

/**
 * Subscription Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Subscription
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Guzzle\Tests\Service\Mock\Command\Sub\Sub;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Session;
use DB;
use DateTime;
use Illuminate\Support\Facades\Route;
use JWTAuth;

/**
 * App\Models\Subscription
 *
 * @property int $id
 * @property string $name
 * @property int $amount
 * @property string $currency_code
 * @property string|null $days
 * @property int $images
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $plan_code
 * @property string|null $payment_type
 * @property-read \App\Models\Currency $currency
 * @property-read mixed $original_amount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereImages($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $stripe_plan_code
 * @property string|null $braintree_plan_code
 * @property string|null $trial_days
 * @property string $plan_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereBraintreePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription wherePlanType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereStripePlanCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Subscription whereTrialDays($value)
 */
class Subscription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subscription';
    protected $fillable = ['name', 'plan_type', 'amount', 'currency_code', 'images', 'status', 'stripe_plan_code', 'braintree_plan_code','trial_days','days'];

//    protected $appends = ['original_amount'];



    // Get all Active status records
	/**
	 * @return \App\Models\Subscription[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
      return Subscription::whereStatus('Active')->get();
    }

	/**
	 * @return \App\Models\Subscription[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function getActivePlan()
    {
      return Subscription::whereStatus('Active')->where('id','!=','4')->get();
    }

    // Get stripe active plan

	/**
	 * @return \App\Models\Subscription|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|null|object
	 */
	public static function getCashierActivePlan()
    {
        return Subscription::where('status', 'Active')->whereNotNull('stripe_plan_code')->whereNotNull('braintree_plan_code')->first();
    }
    // Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
    {
        return $this->belongsTo('App\Models\Currency','currency_code','code');
    }

    // Get actual result of Amount price

	/**
	 * @return mixed
	 */
	public function getOriginalAmountAttribute()
    {
        return $this->attributes['amount'];
    }


    // Get result of night price for current currency

	/**
	 * @return float
	 */
	public function getAmountAttribute()
    {
        return $this->currency_calc('amount');
    }


    // Calculation for current currency conversion of given price field

	/**
	 * @param $field
	 *
	 * @return float
	 */
	public function currency_calc($field)
    {  //get currenct url
      $route=@Route::getCurrentRoute();
      
     
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
        $rate = Currency::whereCode(@$this->attributes['currency_code'])->first()->rate;

        $usd_amount = $this->attributes[$field] / @$rate;

        $default_currency = Currency::where('default_currency',1)->first()->code;
        
        $session_rate = Currency::whereCode($default_currency)->first()->rate;

        //todo-vr add option to allow admins and users to enable/disable currency conversion based on user's ip address
        // $session_rate = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;

        return round($usd_amount * $session_rate);
        }
    }

   }
