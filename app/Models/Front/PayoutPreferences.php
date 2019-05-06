<?php

/**
 * PayoutPreferences Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    PayoutPreferences
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use DateTime;
use DateTimeZone;
use Config;
use Auth;
use JWTAuth;

/**
 * 'App\Models\Front\PayoutPreferences
 *
 * @property int $id
 * @property int $user_id
 * @property string $address1
 * @property string $address2
 * @property string $city
 * @property string $state
 * @property string $postal_code
 * @property string $country
 * @property string $payout_method
 * @property string $paypal_email
 * @property string $currency_code
 * @property string $default
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $updated_date
 * @property-read mixed $updated_time
 * @property-read \App\Models\Front\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereDefault($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences wherePayoutMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences wherePaypalEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\'App\Models\Front\PayoutPreferences whereUserId($value)
 * @mixin \Eloquent
 */
class PayoutPreferences extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payout_preferences';

    public $appends = ['updated_time', 'updated_date'];

    // Get Updated time for Payout Information

	/**
	 * @return string
	 */
	public function getUpdatedTimeAttribute()
    {    //Get currenct url 
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

           //check the url is web or mobile
        if(@$url_array['0']=='api')*/
          if(request()->segment(1) == 'api')
        { 

          $new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));

          $new_str->setTimeZone(new DateTimeZone(JWTAuth::parseToken()->authenticate()->timezone));

          $datemonth = date(PHP_DATE_FORMAT, strtotime($this->attributes['updated_at']));
          return $datemonth.' at '.$new_str->format('H:i');
        }
        else
        { 

          $new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));

          $new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));
          $datemonth = date(PHP_DATE_FORMAT, strtotime($this->attributes['updated_at']));
          return $datemonth.' at '.$new_str->format('H:i');

        }


       
    }

    // Get Updated date for Payout Information

	/**
	 * @return false|string
	 */
	public function getUpdatedDateAttribute()
    {
         //Get currenct url 
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

           //check the url is web or mobile
        if(@$url_array['0']=='api')*/
          if(request()->segment(1) == 'api')
        { 
           $new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));

           $new_str->setTimeZone(new DateTimeZone(JWTAuth::parseToken()->authenticate()->timezone));

           $datemonth = date(PHP_DATE_FORMAT, strtotime($this->attributes['updated_at']));
           return $datemonth;
        }
        else
        {  
            $new_str = new DateTime($this->attributes['updated_at'], new DateTimeZone(Config::get('app.timezone')));

           $new_str->setTimeZone(new DateTimeZone(Auth::user()->timezone));

           $datemonth = date(PHP_DATE_FORMAT, strtotime($this->attributes['updated_at']));
           return $datemonth;

        }
        
    }

    // Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
    {
      return $this->belongsTo('App\Models\Front\User','user_id','id');
    }
}
