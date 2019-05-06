<?php

/**
 * Calendar Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Calendar
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Http\Controllers\CalendarController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use App\Models\Front\RoomsPrice;
use App\Models\Front\Currency;
use Session;
use JWTAuth;
use DateTime;

/**
 * App\Models\Front\Calendar
 *
 * @property int $id
 * @property int $room_id
 * @property string $date
 * @property string $seasonal_name
 * @property string $start_date
 * @property string $end_date
 * @property int $price
 * @property int $week
 * @property int $month
 * @property int $additional_guest
 * @property int $guests
 * @property int $weekend
 * @property int|null $minimum_stay
 * @property string|null $notes
 * @property int $spots_booked
 * @property string $source
 * @property string $is_shared
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read float $duration
 * @property-read mixed $original_additional_guest
 * @property-read mixed $seasonal_date_range
 * @property-read mixed $seasonal_end_date
 * @property-read false|string $seasonal_end_date_month
 * @property-read mixed $seasonal_start_date
 * @property-read mixed $seasonal_start_date_month
 * @property-read mixed $session_currency_price
 * @property-read mixed $session_month
 * @property-read mixed $session_week
 * @property-read mixed $session_weekend
 * @property-read mixed $spots_left
 * @property-read \App\Models\Front\Rooms $rooms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar daysNotAvailable($days = array(), $total_guests = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar notAvailable($total_guests = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereAdditionalGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereIsShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereMinimumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereSeasonalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereSpotsBooked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Calendar whereWeekend($value)
 * @mixin \Eloquent
 */
class Calendar extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'calendar';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['room_id', 'price', 'status', 'date','start_date', 'end_date', 'notes', 'source', 'spots_booked', 'is_shared','week','month','additional_guest','guests','weekend','minimum_stay','seasonal_name'];

	protected $appends = ['session_currency_price','session_week','seasonal_start_date','seasonal_end_date','session_month','session_weekend','original_additional_guest', 'duration'];

	const PHP_DATE_FORMAT = 'Y-m-d H:i:s';
	// Get result of night price for current currency

	/**
	 * @return mixed
	 */
	public function getPriceAttribute()
	{
		//return $this->currency_calc('price');
		return $this->attributes['price'];
	}

	/**
	 * @return float
	 */
	public function getSessionCurrencyPriceAttribute(){
		return $this->currency_calc('price');
	}

	// Get result of week price for current currency

	/**
	 * @return mixed
	 */
	public function getWeekAttribute()
	{

		return @$this->attributes['week'];
	}

	/**
	 * @return float
	 */
	public function getSessionWeekAttribute(){
		return $this->currency_calc('week');
	}

	// Get result of month price for current currency

	/**
	 * @return mixed
	 */
	public function getMonthAttribute()
	{

		return @$this->attributes['month'];
	}

	/**
	 * @return float
	 */
	public function getSessionMonthAttribute(){
		return $this->currency_calc('month');
	}

	// Get result of week price for current currency

	/**
	 * @return mixed
	 */
	public function getWeekendAttribute()
	{

		return @$this->attributes['weekend'];
	}

	/**
	 * @return float
	 */
	public function getSessionWeekendAttribute(){
		return $this->currency_calc('weekend');
	}

	// Get actual result of additional_guest price

	/**
	 * @return mixed
	 */
	public function getOriginalAdditionalGuestAttribute()
	{
		return $this->attributes['additional_guest'];
	}

	// Get result of additional_guest price for current currency

	/**
	 * @return float
	 */
	public function getAdditionalGuestAttribute()
	{
		return $this->currency_calc('additional_guest');
	}


	/**
	 * @param $value
	 */
	public function setSpotsBookedAttribute($value){
		if((@$this->attributes['spots_booked'] > 0 && @$this->attributes['is_shared'] == '') || @$this->attributes['spots_booked'] <= 0)
			@$this->attributes['is_shared'] = $this->rooms->is_shared;

		$this->attributes['spots_booked'] = $value;
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
	{
		return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
	}

	/**
	 * @return int|null
	 */
	public function getSpotsLeftAttribute()
	{
		$total_spots = $this->rooms->accommodates;
		$spots_left = $total_spots - $this->attributes['spots_booked'];
		return $spots_left;
	}

	/**
	 * @param     $query
	 * @param int $total_guests
	 */
	/**
	 * @param     $query
	 * @param int $total_guests
	 */
	/**
	 * @param     $query
	 * @param int $total_guests
	 */
	public function scopeNotAvailable($query, $total_guests=1)
	{
		// dd('ssss', $query);
	 
		$query->whereStatus('Not available')->with(['rooms'])->whereHas('rooms', function($query) use($total_guests){
			$query->where(function($query) use($total_guests){
				$query->whereRaw('calendar.spots_booked +'.$total_guests.' > rooms.accommodates');
				$query->orWhere('calendar.is_shared', 'No');
				$query->orWhere('rooms.is_shared', 'No');
				$query->orWhere('calendar.source', 'Calendar');
			});
		})->toSql();
	}

	/**
	 * @param       $query
	 * @param array $days
	 * @param int   $total_guests
	 *
	 * @return mixed
	 */
	/**
	 * @param       $query
	 * @param array $days
	 * @param int   $total_guests
	 *
	 * @return mixed
	 */
	/**
	 * @param       $query
	 * @param array $days
	 * @param int   $total_guests
	 *
	 * @return mixed
	 */
	public function scopeDaysNotAvailable($query, $days = array(), $total_guests=1)
	{//	dd($query);
		// return "Testing";
		// dd($query->toSql());
		// dd($query->whereIn('date', $days)->notAvailable($total_guests)->distinct()->pluck('room_id')->toArray());
		return($query->leftJoin('rooms', function($join){
			$join->on( 'rooms.id', '=', 'calendar.room_id');
			$join->on( 'calendar.spots_booked', '>=', 'rooms.accommodates');
		})->whereIn('calendar.date', $days)->where('calendar.status', 'Not available')
		->whereOr('calendar.is_shared' ,'=' ,'No')
		->whereOr('rooms.is_shared' ,'=' ,'No')
		->whereOr('calendar.source' ,'=' ,'Calendar')//->groupBy('room_id')
		->pluck('room_id') ->toArray());
		return $query->whereIn('date', $days)->notAvailable($total_guests);
	}

	/**
	 * @param $total_guests
	 *
	 * @return bool
	 */
	/**
	 * @param $total_guests
	 *
	 * @return bool
	 */
	/**
	 * @param $total_guests
	 *
	 * @return bool
	 */
	public function isNotAvailable($total_guests)
	{
		$rooms = $this->rooms;
		$is_not_available = (
			$this->attributes['status'] == "Not available" &&
			(
				($this->attributes['spots_booked']+$total_guests > $rooms->accommodates) ||
				($this->attributes['is_shared'] == 'No') ||
				($this->rooms->is_shared == 'No') ||
				($this->attributes['source'] == 'Calendar')
			)
		);
		return $is_not_available;
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

			$url_array=explode('/',$api_url);*/

		$currency_code = RoomsPrice::where('room_id', $this->attributes['room_id'])->first()->currency_code;

		$rate = Currency::whereCode($currency_code)->first()->rate;

		$usd_amount = $this->attributes[$field] / $rate;

		$default_currency = Currency::where('default_currency',1)->first()->code;

		//Api currency conversion
		/*if(@$url_array['0']=='api')*/
		if(request()->segment(1) == 'api')
		{
			$session_rate = Currency::whereCode(JWTAuth::parseToken()->authenticate()->currency_code)->first()->rate;
		}
		else
		{ //web currency conversion

			//todo-vr add option to allow admins and users to enable/disable currency conversion based on user's ip address
			// $session_rate = Currency::whereCode((Session::get('currency')) ? Session::get('currency') : $default_currency)->first()->rate;
			$session_rate = Currency::whereCode($default_currency)->first()->rate;
		}

		return round($usd_amount * $session_rate);
	}

	// Get Seasonal Start Date

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getSeasonalStartDateAttribute()
	{
		$start_date = @$this->attributes['start_date'];
		$start = date(Self::PHP_DATE_FORMAT, strtotime($this->attributes['start_date']));

		return $start;
	}

	// Get Seasonal End Date

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getSeasonalEndDateAttribute()
	{
		$end_date = @$this->attributes['end_date'];
		$end = date(Self::PHP_DATE_FORMAT, strtotime($this->attributes['end_date']));

		return $end;
	}

	//Get Seasonal Start Date as Text Month

	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	/**
	 * @return false|string
	 */
	public function getSeasonalStartDateMonthAttribute()
	{
		$start_date = $this->attributes['start_date'];

		return date('F', strtotime($this->attributes['start_date']));
	}

	/**
	 *  Get Seasonal End Date as Text Month
	 * @return false|string
	 */
	public function getSeasonalEndDateMonthAttribute()
	{
		$end_date = $this->attributes['end_date'];

		return date('F', strtotime($this->attributes['end_date']));
	}

	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	/**
	 * @return string
	 */
	public function getSeasonalDateRangeAttribute() {
		$start_date = $this->attributes['start_date'];
		$end_date = $this->attributes['end_date'];
		return date('m/d/Y', strtotime($this->attributes['start_date'])) . ' - ' . date('m/d/Y', strtotime($this->attributes['end_date']) );
	}

	/**
	 * Get duration in nights between start_time & end_time
	 * @return float
	 *
	 */
	public function getDurationAttribute()
	{
		$start_date = new DateTime($this->getSeasonalStartDateAttribute());
		$end_date = new DateTime($this->getSeasonalEndDateAttribute());
		$duration = $start_date->diff($end_date)->format("%a");;
		return $duration;
	}

	/**
	 * @return bool|int|mixed
	 */
	/**
	 * @return bool|int|mixed
	 */
	/**
	 * @return bool|int|mixed
	 */
	public function reservation_id()
    {
        $where = ['room_id' => $this->attributes['room_id'], 'checkin' => $this->attributes['start_date']];        
        
        // $result = Reservation::where($where)->whereRaw("INSTR('".$this->attributes['seasonal_name']."', code) != 0 and code !='' ");
        $result = Reservation::where($where);        

        if($result->count())
            return $result->first()->id;
        else
            return false;
    }

}
