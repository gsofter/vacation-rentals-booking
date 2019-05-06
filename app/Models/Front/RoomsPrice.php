<?php

/**
 * Rooms Price Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms Price
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use DB;
use Illuminate\Support\Facades\Route;
use JWTAuth;
use Log;

/**
 * App\Models\RoomsPrice
 *
 * @property int $room_id
 * @property int $night
 * @property int $week
 * @property int $month
 * @property int $cleaning
 * @property int $additional_guest Per Extra Guest Price
 * @property string|null $additional_charge
 * @property int|null $total_additional_charge
 * @property string $cleaning_fee_type
 * @property float|null $tax
 * @property int $guests Allowed Guest
 * @property int $security
 * @property int $weekend
 * @property int|null $minimum_stay
 * @property int|null $maximum_stay
 * @property string $currency_code
 * @property-read \App\Models\Front\Currency $currency
 * @property-read mixed $code
 * @property-read mixed $original_additional_guest
 * @property-read mixed $original_cleaning
 * @property-read mixed $original_month
 * @property-read mixed $original_night
 * @property-read mixed $original_security
 * @property-read mixed $original_week
 * @property-read mixed $original_weekend
 * @property-read mixed $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereAdditionalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereAdditionalGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereCleaning($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereCleaningFeeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereMaximumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereMinimumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereNight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereSecurity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereTotalAdditionalCharge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPrice whereWeekend($value)
 * @mixin \Eloquent
 */
class RoomsPrice extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_price';

    public $timestamps = false;

    protected $primaryKey = 'room_id';

    protected $appends = ['steps_count', 'original_night', 'original_cleaning', 'original_additional_guest', 'original_security', 'original_weekend', 'code','original_week','original_month'];

    // Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
    {
        return $this->belongsTo('App\Models\Front\Currency','currency_code','code');
    }

    // Get actual result of night price

	/**
	 * @return mixed
	 */
	public function getOriginalNightAttribute()
    {
        return $this->attributes['night'];
    }

    // Get actual result of night price

	/**
	 * @return mixed
	 */
	public function getOriginalWeekAttribute()
    {
        return $this->attributes['week'];
    }

    // Get actual result of night price

	/**
	 * @return mixed
	 */
	public function getOriginalMonthAttribute()
    {
        return $this->attributes['month'];
    }

    // Get actual result of cleaning price

	/**
	 * @return mixed
	 */
	public function getOriginalCleaningAttribute()
    {
        return $this->attributes['cleaning'];
    }

    // Get actual result of additional_guest price

	/**
	 * @return mixed
	 */
	public function getOriginalAdditionalGuestAttribute()
    {
        return $this->attributes['additional_guest'];
    }

    // Get actual result of security price

	/**
	 * @return mixed
	 */
	public function getOriginalSecurityAttribute()
    {
        return $this->attributes['security'];
    }

    // Get actual result of weekend price

	/**
	 * @return mixed
	 */
	public function getOriginalWeekendAttribute()
    {
        return $this->attributes['weekend'];
    }

    // Get result of night price for current currency

	/**
	 * @return float
	 */
	public function getNightAttribute()
    {
        return $this->currency_calc('night');
    }
    // Get result of night price for current currency

	/**
	 * @return float
	 */
	public function getWeekAttribute()
    {
        return $this->currency_calc('week');
    }

     // Get result of night price for current currency

	/**
	 * @return float
	 */
	public function getMonthAttribute()
    {
        return $this->currency_calc('month');
    }

    // Get result of cleaning price for current currency

	/**
	 * @return float
	 */
	public function getCleaningAttribute()
    {
        return $this->currency_calc('cleaning');
    }

    // Get result of additional_guest price for current currency

	/**
	 * @return float
	 */
	public function getAdditionalGuestAttribute()
    {
        return $this->currency_calc('additional_guest');
    }

    // Get result of security price for current currency

	/**
	 * @return float
	 */
	public function getSecurityAttribute()
    {
        return $this->currency_calc('security');
    }

    // Get result of weekend price for current currency

	/**
	 * @return float
	 */
	public function getWeekendAttribute()
    {
        return $this->currency_calc('weekend');
    }

    // Get steps_count using sum of rooms_steps_status

	/**
	 * @return int|mixed|string
	 */
	public function getStepsCountAttribute()
    {
        $result = RoomsStepsStatus::find($this->attributes['room_id']);
        if($result)
            return 8 - (@$result->basics + @$result->description + @$result->location + @$result->photos + @$result->pricing + @$result->calendar + @$result->plans + @$result->terms);
        else
            return 8;
    }

    // Get result of night price for given date

	/**
	 * @param $date
	 *
	 * @return int|mixed
	 */
	public function price($date)
    {
        $where = [['room_id', $this->attributes['room_id']], ['start_date', '<=', $date], ['end_date', '>=', $date]];

        $result = SeasonalPrice::where($where);

        if($result->count())
        {
            if((date('N',strtotime($date))==5 || date('N',strtotime($date))==6) && $result->first()->weekend !=0)
                return $result->first()->weekend;
            else
                return $result->first()->price;
        }
        else
        {
            if((date('N',strtotime($date))==5 || date('N',strtotime($date))==6) && $this->attributes['weekend'] !=0)
                return $this->attributes['weekend'];
            else
                return $this->attributes['night'];//return $this->currency_calc('night');
        }
    }

    // Get result of calendar event status for given date

	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	public function status($date)
    {
        
        $where = ['room_id' => $this->attributes['room_id'], 'date' => $date];
        
        $result = Calendar::where($where);
        
        if($result->count())
            return $result->first()->status;
        else
            return false;
    }

    // Get result of calendar event source for given date

	/**
	 * @param $date
	 *
	 * @return bool|mixed|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|string
	 */
	public function source($date)
    {
        $where = ['room_id' => $this->attributes['room_id'], 'date' => $date];
        
        $result = Calendar::where($where);

        if($result->count())
            return $result->first()->source;
        else
            return false;
    }
    
    // Get result of calendar notes for given date

	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed|null|string
	 */
	public function notes($date)
    {
        $where = ['room_id' => $this->attributes['room_id'], 'date' => $date];

        $result = Calendar::where($where);

        if($result->count())
            return $result->first()->notes;
        else
            return false;
    }

    // Get result of calendar notes for given date

	/**
	 * @param $date
	 *
	 * @return bool|mixed
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed
	 */
	/**
	 * @param $date
	 *
	 * @return bool|mixed
	 */
	public function spots_left($date)
    {
        $where = ['room_id' => $this->attributes['room_id'], 'date' => $date];

        $result = Calendar::where($where);

        if($result->count())
            return $result->first()->spots_booked > 0 && $result->first()->is_shared == 'Yes' ? $result->first()->spots_left : false;
        else
            return false;
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
    {  //get currenct url
      $route=@Route::getCurrentRoute();
      
      /*if($route)
      {
        $api_url = @$route->getPath();
      }
      else
      {
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

        $usd_amount = $this->attributes[$field] / $rate;

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
	public function getCodeAttribute()
    {
        //get currenct url
      /*$route=@Route::getCurrentRoute();
      
      if($route)
      {
        $api_url = @$route->getPath();
      }
      else
      {
        $api_url = '';
      }
          $url_array=explode('/',$api_url);
            //Check current user login is web or mobile
          if(@$url_array['0']=='api')*/
          if(request()->segment(1) == 'api')
          { 
    
            if(JWTAuth::parseToken()->authenticate()->currency_code) 
             //set user currency code 
             return JWTAuth::parseToken()->authenticate()->currency_code;
             
            else
                //set default currency  code . for user currency code not given.
             return DB::table('currency')->where('default_currency', 1)->first()->code;
          }
          else
          {
            if(Session::get('currency'))
           return Session::get('currency');
           else
           return DB::table('currency')->where('default_currency', 1)->first()->code;

          }
       
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
