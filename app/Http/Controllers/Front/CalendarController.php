<?php

/**
 * Calendar Controller
 *
 * @package     Makent
 * @subpackage  Controller
 * @category    Calendar
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */
namespace App\Http\Controllers\Front;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Front\IcalController;
use App\Models\Front\RoomsPrice;
use App\Models\Front\Rooms;
use App\Models\Front\Calendar;
use App\Models\Front\SeasonalPrice;
use App\Models\Front\ImportedIcal;
use App\Models\Front\Reservation;
use App\Models\Front\Currency;
use Validator;
use Form;
use App\Http\Helper\PaymentHelper;
use App\Http\Start\Helpers;
use Request as HttpRequest;
use Log;

/**
 * Class CalendarController
 *
 * @package App\Http\Controllers
 */
class CalendarController extends Controller
{
    protected $start_day = 'sun';   // Global Variable for Start Day of Calendar
    protected $payment_helper;

	/**
	 * Get a Calendar HTML
	 *
	 * @param \App\Http\Helper\PaymentHelper $payment
	 */
    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
        $this->helper = new Helpers;
    }

	/**
	 * Get a Calendar HTML
	 *
	 * @param int    $room_id Room Id for get the Calendar data
	 * @param string $year    Year of Calendar
	 * @param string $month   Month of Calendar
	 *
	 * @return html
	 * @throws \Throwable
	 */
    public function generate($room_id, $year = '', $month = '') {
        $data = $this->get_calendar_data($room_id, $year, $month);        
        return view('list_your_space.calendar_lg',$data)->render();
    }

	/**
	 * @param        $room_id
	 * @param string $year
	 * @param string $month
	 *
	 * @return string
	 * @throws \Throwable
	 */
	public function generate_month_calendar($room_id, $year = '', $month = '') {
        $data = $this->get_calendar_data($room_id, $year, $month);        
        return view('rooms.month_calendar',$data)->render();
    }
	public function generate_month_calendar_data($room_id, $year = '', $month = '') {
        return $data = $this->get_calendar_data($room_id, $year, $month);        
    }

	/**
	 * @param        $room_id
	 * @param string $year
	 * @param string $month
	 *
	 * @return mixed
	 */
	public function get_calendar_data($room_id, $year = '', $month = '')
    {
        $rooms = Rooms::find($room_id);
        $rooms_price = RoomsPrice::find($room_id);
        if ($year == '')
        {
            $year  = date('Y');
        }
        if ($month == '')
        {
            $month = date('m');
        }
        $calendar_data = array();

        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $days = array('sun' => 0, 'mon' => 1, 'tue' => 2, 'wed' => 3, 'thu' => 4, 'fri' => 5, 'sat' => 6);

        $start_day= (array_key_exists($this->start_day,$days)) ? $days[$this->start_day] : 0 ;

        $today_time = mktime(12, 0, 0, $month, 1, $year);
        $today_date = getdate($today_time);
        $day        = $start_day + 1 - $today_date["wday"];

        $prev_time  = mktime(12, 0, 0, $month-1, 1, $year);
        $next_time  = mktime(12, 0, 0, $month+1, 1, $year);

        $last_time  = mktime(12, 0, 0, $month, $total_days, $year);
        $last_date  = getdate($last_time);
        $total_dates= $total_days + ($last_date["wday"] != ($start_day-1) ? ( 6 + $start_day - $last_date["wday"] ) : 0);

        $current_date= date('Y-m-d');
        $current_time= time();

        if ($day > 1)
        {
            $day -= 7;
        }

        $k = 0;
        while($day <= $total_dates)
        {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $calendar_data[$k]['date'] = $this_date;
            $calendar_data[$k]['day'] = date('d', $this_time);
            $calendar_data[$k]['class'] = '';
            



            $calendar_data[$k]['price_display'] = ' style="display: none;"';
            if(date('Ymd', $this_time) < date('Ymd',$current_time)) {
                $calendar_data[$k]['class'] .= ' tile-previous';
            } else {

            
                if(date('Ymd', $this_time) == date('Ymd',$current_time)) {
                    $calendar_data[$k]['class'] .= ' today price-suggestion-undefined';
                }

                if(SeasonalPrice::where([['room_id', $room_id], ['start_date', '<=', $this_date], ['end_date', '>=', $this_date]])->count()) {
                    $calendar_data[$k]['class'] .= ' season_price';   // apply seasonal price
                } 
                
                // dd($rooms_price);?
                if($rooms_price && $rooms_price->status($this_date) == 'Available') {
                    $calendar_data[$k]['class'] .= ' season_highlight';   
                } elseif($rooms_price && $rooms_price->status($this_date) == 'Not available') {
                    if ($rooms_price->source($this_date) == 'Calendar') {
                        $calendar_data[$k]['class'] .= ' unavailable_highlight';   
                    } elseif ($rooms_price->source($this_date) == 'Import') {
                        $calendar_data[$k]['class'] .= ' imported_highlight';                         
                    }
                    
                } elseif( $rooms_price && $rooms_price->status($this_date) == 'Reserved') {
                    $calendar_data[$k]['class'] .= ' reserved_highlight';                       

                    if ( $rooms_price->source($this_date) == 'Calendar') {
                        // to do                        
                        
                    } elseif ($rooms_price->source($this_date) == 'Reservation') {
                        // to do
                    }
                }
                    
                
                $reservation_checkin = Reservation::whereRoomId($room_id)->where('type', 'reservation')->whereRaw('status="Accepted"')->where('checkin', $this_date)->first();
                
                if($reservation_checkin){
                    $calendar_data[$k]['class'] .= ' reserve-checkin';

                    $calendar_data[$k]['reservation_source'] = 'Reservation';
                    $calendar_data[$k]['reservation_details'] = Reservation::with('rooms','users')->where([['room_id', $room_id], ['checkin', '<=', $this_date], ['checkout', '>', $this_date]])->whereRaw('status="Accepted"')->first();
                }

                $reservation_checkout = Reservation::whereRoomId($room_id)->where('type', 'reservation')->whereRaw('status="Accepted"')->where('checkout', $this_date)->first();

                if($reservation_checkout) {
                    $calendar_data[$k]['class'] .= ' reserve-checkout';    
                }

                $manual_checkin = Calendar::whereRoomId($room_id)->where('start_date', $this_date)->where('status', 'Reserved')->whereRaw('source="Calendar"')->first();

                if($manual_checkin){
                    $calendar_data[$k]['class'] .= ' reserve-checkin';   

                    $calendar_data[$k]['reservation_source'] = 'Calendar';
                    $calendar_data[$k]['reservation_details'] = Calendar::where([['room_id', $room_id], ['start_date', '<=', $this_date], ['end_date', '>', $this_date]])->whereRaw('(source="Calendar") and (status="Reserved")')->first();                 
                }

                $manual_checkout = Calendar::whereRoomId($room_id)->where('end_date', $this_date)->where('status', 'Reserved')->whereRaw('source="Calendar"')->first();

                if($manual_checkout){
                    $calendar_data[$k]['class'] .= ' reserve-checkout';    
                }

                $ical_checkin = Calendar::whereRoomId($room_id)->where('start_date', $this_date)->where('status', 'Not available')->whereRaw('source="Import"')->first();
                if($ical_checkin) {
                    $calendar_data[$k]['class'] .= ' imported-checkin';

                    $calendar_data[$k]['reservation_details'] = Calendar::where([['room_id', $room_id], ['start_date', '<=', $this_date], ['end_date', '>', $this_date]])->whereRaw('(source="Import") and (status="Not available")')->first();  
                }

                $ical_checkout = Calendar::whereRoomId($room_id)->where('end_date', $this_date)->where('status', 'Not available')->whereRaw('source="Import"')->first();

                if($ical_checkout) {
                    $calendar_data[$k]['class'] .= ' imported-checkout';    
                }

                $is_unavailable = Calendar::whereRoomId($room_id)->whereRaw('source="Calendar"')->whereRaw('status ="Not available"')->whereRaw('(start_date <= "'.$this_date.'" and end_date >= "'.$this_date.'")')->first();
                
                if($is_unavailable){
                    if($this_date == $is_unavailable->start_date) {                    
                        // $is_reserve_end_date = Calendar::whereRoomId($room_id)->whereRaw('end_date = "'.$this_date.'"')->whereRaw('status ="Not available"')->first();
                        // if(!$is_reserve_end_date) {
                        //     $calendar_data[$k]['class'] .= ' unavailable-start';                                        
                        // } else {
                        //     $calendar_data[$k]['class'] .= ' ';        
                        // }
                        $calendar_data[$k]['class'] .= ' unavailable-start';                                        
                    } 
                    if($this_date == $is_unavailable->end_date) {
                        // $is_reserve_start_date = Calendar::whereRoomId($room_id)->whereRaw('start_date = "'.$this_date.'"')->whereRaw('status ="Not available"')->first();
                        // if(!$is_reserve_start_date) {                        
                        //     $calendar_data[$k]['class'] .= ' unavailable-end';    
                        // } else {                        
                        //     $calendar_data[$k]['class'] .= ' ';        
                        // }                    
                        $calendar_data[$k]['class'] .= ' unavailable-end';    
                    } 
                }
            }    
         
            $calendar_data[$k]['price'] = $rooms_price != null ? $rooms_price->price($this_date) : 0;
            $calendar_data[$k]['price_symbol'] = $rooms_price != null ? $rooms_price->currency->original_symbol :'$';
            $day++;
            $k++;
        }
        //Get all seasonal dates that aren't available;
        $not_available_dates = Calendar::where([['room_id',$room_id], ['status', 'Not available'], ['source', 'Calendar']])->groupBy('seasonal_name')->get();

        $data['calendar_data'] = $calendar_data;
        $data['today_time']    = $today_time;
        $data['local_date']    = mktime(12, 0, 0, $month, 1, $year);
        $data['prev_month']    = date('m', $prev_time);
        $data['prev_year']     = date('Y', $prev_time);
        $data['next_month']    = date('m', $next_time);
        $data['next_year']     = date('Y', $next_time);
        $data['room_id']       = $room_id;
        $data['year_month']    = $this->year_month();
        $data['rooms_price']   = $rooms_price;
        $data['rooms']         = $rooms;
        $data['startweek']=$this->start_day; // Write By Aditya
        $data['minimum_amount']= @$this->payment_helper->currency_convert('USD', $rooms_price->currency_code, 10);
        $data['seasonal_price_detail'] = SeasonalPrice::where([['room_id',$room_id]])->groupBy('seasonal_name')->get();
        $data['reservation_detail'] = Calendar::where('room_id',$room_id)->where(function($query) {
          $query->where('status','Reserved')->orWhere([['source','Import'], ['status', 'Not available']]);  
        })->groupBy('seasonal_name')->get();        
        $data['not_available_dates'] = $not_available_dates;
        $data['result'] = Rooms::check_user($room_id); // Check Room Id and User Id is correct or not
        return $data;        
    }

	/**
	 * @param        $room_id
	 * @param string $year
	 * @param string $month
	 *
	 * @return string
	 * @throws \Throwable
	 */
	/**
	 * @param        $room_id
	 * @param string $year
	 * @param string $month
	 *
	 * @return string
	 * @throws \Throwable
	 */
	/**
	 * @param        $room_id
	 * @param string $year
	 * @param string $month
	 *
	 * @return string
	 * @throws \Throwable
	 */
	public function admin_generate($room_id, $year = '', $month = '')
    {
        $rooms = Rooms::find($room_id);
        $rooms_price = RoomsPrice::find($room_id);

        //$this_start_day = 'monday';

        if ($year == '')
        {
            $year  = date('Y');
        }
        if ($month == '')
        {
            $month = date('m');
        }
        $calendar_data = array();

        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        //$start_days = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $days = array('sun' => 0, 'mon' => 1, 'tue' => 2, 'wed' => 3, 'thu' => 4, 'fri' => 5, 'sat' => 6);
        //$start_day  = ( ! isset($start_days[$this_start_day])) ? 0 : $start_days[$this_start_day];
        $start_day= (array_key_exists($this->start_day,$days)) ? $days[$this->start_day] : 0 ;
        $today_time = mktime(12, 0, 0, $month, 1, $year);
        $today_date = getdate($today_time);
        $day        = $start_day + 1 - $today_date["wday"];

        $prev_time  = mktime(12, 0, 0, $month-1, 1, $year);
        $next_time  = mktime(12, 0, 0, $month+1, 1, $year);

        $last_time  = mktime(12, 0, 0, $month, $total_days, $year);
        $last_date  = getdate($last_time);
        $total_dates= $total_days + ($last_date["wday"] != ($start_day-1) ? ( 6 + $start_day - $last_date["wday"] ) : 0);

        $current_date= date('Y-m-d');
        $current_time= time();

        if ($day > 1)
        {
            $day -= 7;
        }

        $k = 0;
        while($day <= $total_dates)
        {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $calendar_data[$k]['date'] = $this_date;
            $calendar_data[$k]['day'] = date('d', $this_time);
            $calendar_data[$k]['class'] = '';
            $calendar_data[$k]['price_display'] = ' style="display: none;"';
            if(date('Ymd', $this_time) < date('Ymd',$current_time))
            {
                $calendar_data[$k]['class'] .= ' tile-previous';
            }
            elseif(date('Ymd', $this_time) == date('Ymd',$current_time))
            {
                $calendar_data[$k]['class'] .= ' today price-suggestion-undefined';
            }
            $is_reservation = Reservation::whereRoomId($room_id)->where('type', 'reservation')->whereRaw('status!="Declined"')->whereRaw('status!="Expired"')->whereRaw('status!="Cancelled"')->whereRaw('status!="Pending"')->whereRaw('(checkin = "'.$this_date.'" or (checkin < "'.$this_date.'" and checkout > "'.$this_date.'")) ')->get()->count();
            if($is_reservation > 0){
                $calendar_data[$k]['class'] .= ' status-b tile-previous';
            }elseif($rooms_price->status($this_date) == 'Not available'){
                $calendar_data[$k]['class'] .= ' status-b';
            }

            if($calendar_data[$k]['class'] != ' status-b' && $calendar_data[$k]['class'] != ' status-b tile-previous')
                $calendar_data[$k]['price_display'] = ' style="display: inline-flex;"';

            $day++;
            $k++;
        }
        $data['calendar_data'] = $calendar_data;
        $data['today_time']    = $today_time;
        $data['local_date']    = mktime(12, 0, 0, $month, 1, $year);
        $data['prev_month']    = date('m', $prev_time);
        $data['prev_year']     = date('Y', $prev_time);
        $data['next_month']    = date('m', $next_time);
        $data['next_year']     = date('Y', $next_time);
        $data['room_id']       = $room_id;
        $data['year_month']    = $this->year_month();
        $data['rooms_price']   = $rooms_price;
        $data['rooms']         = $rooms;
        $data['minimum_amount']= $this->payment_helper->currency_convert('USD', $rooms_price->currency_code, 10);
        $data['seasonal_price_detail'] = SeasonalPrice::where([['room_id',$room_id]])->groupBy('seasonal_name')->get();
         $data['result']         = Rooms::check_user($room_id); // Check Room Id and User Id is correct or not

        return view('list_your_space.calendar_admin',$data)->render();
    }


	/**
	 * Get a Small Calendar HTML
	 *
	 * @param int    $room_id        Room Id for get the Calendar data
	 * @param string $year           Year of Calendar
	 * @param string $month          Month of Calendar
	 * @param string $reservation_id Reservation Id of Calendar
	 * @return html
	 * @throws \Throwable
	 */
    public function generate_small($room_id, $year = '', $month = '', $reservation_id = '')
    {
        $rooms = Rooms::find($room_id);
        $rooms_price = RoomsPrice::find($room_id);

        $reservation_details = Reservation::where('room_id', $room_id)->where('id',$reservation_id)->get();

        if(count($reservation_details))
            $dates = $this->get_days_reservation($reservation_details[0]->checkin, $reservation_details[0]->checkout);

        $this_start_day = 'monday';
        if ($year == '')
        {
            $year  = date('Y');
        }
        if ($month == '')
        {
            $month = date('m');
        }
        $calendar_data = array();

        $total_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $start_days = array('sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3, 'thursday' => 4, 'friday' => 5, 'saturday' => 6);
        $start_day  = ( ! isset($start_days[$this_start_day])) ? 0 : $start_days[$this_start_day];

        $today_time = mktime(12, 0, 0, $month, 1, $year);
        $today_date = getdate($today_time);
        $day        = $start_day + 1 - $today_date["wday"];

        $prev_time  = mktime(12, 0, 0, $month-1, 1, $year);
        $next_time  = mktime(12, 0, 0, $month+1, 1, $year);

        $last_time  = mktime(12, 0, 0, $month, $total_days, $year);
        $last_date  = getdate($last_time);
        $total_dates= $total_days + ($last_date["wday"] != ($start_day-1) ? ( 6 + $start_day - $last_date["wday"] ) : 0);

        $current_date= date('Y-m-d');
        $current_time= time();

        if ($day > 1)
        {
            $day -= 7;
        }

        $k = 0;
        while($day <= $total_dates)
        {
            $this_time = mktime(12, 0, 0, $month, $day, $year);
            $this_date = date('Y-m-d', $this_time);
            $calendar_data[$k]['date'] = $this_date;
            $calendar_data[$k]['day'] = date('d', $this_time);
            $class = '';
            $final_class = '';
            $calendar_data[$k]['class'] = '';

            if(date('Ymd', $this_time) < date('Ymd',$current_time))
            {
                $class .= ' tile-previous';
            }
            elseif(date('Ymd', $this_time) == date('Ymd',$current_time))
            {
                $class .= ' today';
            }

            if($class == '' || $class == ' today')
            {
                if($rooms_price->status($this_date) == 'Not available')
                    $class .= ' status-r';

                if(count($reservation_details))
                {
                    if($rooms_price->status($this_date) == 'Not available' && in_array($this_date, $dates))
                    $class .= " status-r tile-status active";
                }
            }

            $final_class = ' '.$class.' no-tile-status both';

            if(count($reservation_details))
            {
            if($rooms_price->status($this_date) == 'Not available' && in_array($this_date, $dates))
                $final_class = 'tile '.$class;
            }
            $calendar_data[$k]['class'] = $final_class;

            $day++;
            $k++;
        }
        $data['calendar_data'] = $calendar_data;
        $data['today_time']    = $today_time;
        $data['local_date']    = mktime(12, 0, 0, $month, 1, $year);
        $data['prev_month']    = date('m', $prev_time);
        $data['prev_year']     = date('Y', $prev_time);
        $data['next_month']    = date('m', $next_time);
        $data['next_year']     = date('Y', $next_time);
        $data['room_id']       = $room_id;
        $data['year_month']    = $this->year_month();
        $data['rooms_price']   = $rooms_price;
        $data['rooms']         = $rooms;
        $data['minimum_amount']= $this->payment_helper->currency_convert('USD', $rooms_price->currency_code, 10);

        return view('list_your_space.calendar_sm',$data)->render();
    }


	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function seasonal_calendar(Request $request)
    {

        $id  = $request->id;        

        $seasons = SeasonalPrice::where([
            ['room_id', $id],
            ['seasonal_name', '!=', $request->season_name]
        ])->get();

        $result['seasonal_days'] = array();

        foreach ($seasons as $season) {
            $days = $this->get_days(strtotime($season->start_date), strtotime($season->end_date));                         
            foreach($days as $day){
                array_push($result['seasonal_days'], $day);
            }
        }           

        // get the dates of selected self season
        $result['self_days'] = array();

        $self_season = SeasonalPrice::where([
            ['room_id', $id],
            ['seasonal_name', $request->season_name]
        ])->first();
        if(!$self_season) {
            return json_encode($result);
        }
        $days = $this->get_days(strtotime($self_season->start_date), strtotime($self_season->end_date));                         
        foreach($days as $day){
            array_push($result['self_days'], $day);
        }
        return json_encode($result);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function unavailable_calendar(Request $request)
    {
        $id  = $request->id;        

        $unavailable_dates = Calendar::where([
            ['room_id', $id],
            ['status', '<>', 'Available'],
            ['seasonal_name', '<>', $request->season_name],
        ])->get();

        $result['unavailable_dates'] = array();
        $result['day_types'] = array(); 
        $result['day_position'] = array();

        foreach ($unavailable_dates as $day) {            
            $date = $day->date;
            array_push($result['unavailable_dates'], $date);
            $source = $day->source;
            $status = $day->status;            
            $start_date = $day->start_date;
            $end_date = $day->end_date;
            if($source == 'Calendar' && $status == 'Not available') {
                array_push($result['day_types'], 'blocked');                
            } else {
                array_push($result['day_types'], 'reservation');
            }


            if($date == $start_date) {                
                $checkout = Calendar::where([
                    ['room_id', $id],
                    ['status', 'Reserved'],                    
                    ['seasonal_name', '!=', $request->season_name],
                    ['end_date', $date],
                ])->first();
                
                if($checkout) {                
                    array_push($result['day_position'], 'checkout checkin');
                } else {
                    array_push($result['day_position'], 'checkin');    
                }                
            } else if($date == $end_date) {

                $checkin = Calendar::where([
                    ['room_id', $id],
                    ['status', 'Reserved'],                    
                    ['seasonal_name', '!=',  $request->season_name],
                    ['end_date', $date],
                ])->first();
                if($checkin) {
                    array_push($result['day_position'], 'checkout checkin');
                } else {
                    array_push($result['day_position'], 'checkout');    
                }
                
            } else {
                array_push($result['day_position'], '');
            }

        }      

        // supplement the missed checkout dates as it is not represented in calendar table.
        $unavailable_dates = Calendar::where([
            ['room_id', $id],
            ['status', '<>', 'Available'],
            ['seasonal_name', '<>', $request->season_name],            
        ])->whereRaw('NOT (source="Calendar" AND status="Not available")')->groupBy('seasonal_name')->get();

        foreach ($unavailable_dates as $day) {  

            if(!in_array($day->end_date, $result['unavailable_dates'])) {

                array_push($result['unavailable_dates'], $day->end_date);
                array_push($result['day_types'], 'reservation');
                array_push($result['day_position'], 'checkout');
            } 
        }

        // get the dates of self self unavailable date range
        $result['self_days'] = array();

        $self_season = Calendar::where([
            ['room_id', $id],
            ['status', '<>', 'Available'],
            ['seasonal_name', $request->season_name],
        ])->first();
        if(!$self_season) {
            return json_encode($result);                    
        }
        $days = $this->get_days(strtotime($self_season->start_date), strtotime($self_season->end_date));                         
        foreach($days as $day){
            array_push($result['self_days'], $day);
        }
        return json_encode($result);        
    }

	/**
	 * Get a Calendar Month & Year Dropdown
	 *
	 * @return array with Year
	 */
    public function year_month()
    {
        $year_month = array();

        $this_time = mktime(0, 0, 0, date('m'), 1, date('Y'));
        for($i=-2;$i<35;$i++)
        {
          $time               = strtotime("+$i months", $this_time);
          $value              = date('Y-m', $time);
          $label              = trans('messages.lys.'.date('F', $time)).' '.date('Y', $time);
          $year_month[$value] = $label;
        }
        return $year_month;
    }

	/**
	 * iCal Export
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return void file
	 * @throws \UnexpectedValueException
	 */
    public function ical_export(Request $request)
    {
        $explode_id = explode('.', $request->id);

        // 1. Create new calendar
        $vCalendar  = new \Eluceo\iCal\Component\Calendar(url('/'));

        $result     = Calendar::where('room_id', $explode_id[0])->where('status','Not available')->get();

        foreach($result as $row)
        {
            // 2. Create an event
            $vEvent = new \Eluceo\iCal\Component\Event();

            $vEvent
                ->setDtStart(new \DateTime($row->date))
                ->setDtEnd(new \DateTime($row->date))
                ->setDescription($row->notes)
                ->setNoTime(true)
                ->setSummary($row->status);

            // 3. Add event to calendar
            $vCalendar->addComponent($vEvent);
        }

        // 4. Set headers
        header('Content-Type: text/calendar; charset=utf-8');
        header('Content-Disposition: attachment; filename="listing-'.$explode_id[0].'.ics"');

        // 5. Output
        echo $vCalendar->render();
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function add_not_available_days(Request $request){
        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));

        $days = $this->get_days(strtotime($checkin),strtotime($checkout));
        if($request->edit_season_name !== ""){          // when edit unavailable dates
            // recovery relevant season            
            $not_available_date = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->edit_season_name)->where('status', 'Not available')->where('source', 'Calendar')->first();
            
            // delete all records of the unavailable date range which is to be updated
            $calendar = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->edit_season_name)->where('status', 'Not available')->where('source', 'Calendar')->delete();
            // must recover season only after delete all records of the unavailable date range (because recovery function use updateOrCreate function)
            
            if($not_available_date)
            {
                $fromDate = $not_available_date->start_date;
                $toDate = $not_available_date->end_date;
                $room_id = $request->id;
                $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);    
            }
        }
        
        foreach($days as $day){
            $ical_date = Calendar::where('room_id',$request->id)->where('date', $day)->where('source', 'Import')->first();
            if($ical_date) continue; // if iCal date exists, skip

            $calendar = Calendar::where('room_id',$request->id)->where('date', $day)->first();
            if($calendar !== null){
                $calendar->status = 'Not available';
                $calendar->seasonal_name = $request->season_name;                
                $calendar->start_date = $checkin;
                $calendar->end_date = $checkout;
                $calendar->save();
            }else{
                $calendar = new Calendar;
                $calendar->room_id = $request->id;
                $calendar->seasonal_name = $request->season_name;
                $calendar->date = $day;
                $calendar->start_date = $checkin;
                $calendar->end_date = $checkout;                
                $calendar->status = 'Not available';
                $calendar->source = 'Calendar';
                $calendar->save();
            }
        }
         return json_encode(['success' =>'true']);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @throws \Exception
	 */
	public function delete_not_available_days(Request $request){
        // recovery relevant season            
        $ical_date_range = Calendar::where([
                    ['room_id',$request->id],
                    ['seasonal_name',$request->season_name],
                    ['source', 'Import'],                    
                    ])->first();


        $not_available_date = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->where('status', 'Not available')->where('source', 'Calendar')->first();

        $not_available_days = Calendar::where([
                ['room_id',$request->id],
                ['seasonal_name',$request->season_name],
                ['status', 'Not available'],                
                ])->delete();                

        // must recover season only after delete all records of the unavailable date range (because recovery function use updateOrCreate function)
        if($ical_date_range)
        {
            $fromDate = $ical_date_range->start_date;
            $toDate = $ical_date_range->end_date;
            $room_id = $request->id;
            $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);
        }

        
        if($not_available_date)
        {
            $fromDate = $not_available_date->start_date;
            $toDate = $not_available_date->end_date;
            $room_id = $request->id;
            $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);    
        }
        
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function fetch_reservation(Request $request){
        $fetch = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->first();

        return json_encode($fetch);
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function delete_reservation(Request $request){

        // recovery relevant season
        $reservation = Calendar::where([
                    ['room_id',$request->id],
                    ['seasonal_name',$request->season_name],                                        
                    ])->where(function($query) {
                        $query->where([['status', 'Reserved'], ['source', 'Calendar']])->orWhere([['status', 'Reserved'], ['source', 'Reservation']])->orWhere([['status', 'Not available'], ['source', 'Import']]);
                    })->first();

       // return $reservation;
        // check if allowed deleting request                    
        if($reservation && $reservation->source == 'Reservation') {
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => '', 'toast' => 'VR reservation can not be removed.']);    // if VR reservation, disable deleting 
        }        
        
        // delete reservation in the calendar table
        
        Calendar::where([
                    ['room_id',$request->id],
                    ['seasonal_name',$request->season_name],                                        
                ])->where(function($query) {
                    $query->where([['status', 'Reserved'], ['source', 'Calendar']])->orWhere([['status', 'Reserved'], ['source', 'Reservation']])->orWhere([['status', 'Not available'], ['source', 'Import']]);
            })->delete();                

        

        // must recover season only after delete all records of the unavailable date range (because recovery function use updateOrCreate function)
        if($reservation)
        {
            $fromDate = $reservation->start_date;
            $toDate = $reservation->end_date;
            $room_id = $request->id;
            $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);
        }

        return json_encode(['success' => 'true']);
    }

	/**
	 * @param $room_id
	 * @param $fromDate
	 * @param $toDate
	 */
	/**
	 * @param $room_id
	 * @param $fromDate
	 * @param $toDate
	 */
	/**
	 * @param $room_id
	 * @param $fromDate
	 * @param $toDate
	 */
	public function recoverSeasonalPrices($room_id, $fromDate, $toDate) {
        $relevant_seasons = SeasonalPrice::where([['room_id', $room_id], ['start_date', '<=', $fromDate], ['end_date', '>', $fromDate]])->orWhere([['room_id', $room_id], ['start_date', '<=', $toDate], ['end_date', '>', $toDate]])->get();
        

        if($relevant_seasons->count() > 0) 
        {

            foreach ($relevant_seasons as $season) {

                $days = $this->get_days(strtotime($season->start_date), strtotime($season->end_date));                            


                foreach($days as $day){
                    
                    $reserved_date = Calendar::where([
                        ['room_id',$room_id],                                    
                        ['date', $day],
                        ['status', "Not available"]
                    ])->first();

                    if($reserved_date) 
                    {
                        continue; 
                        
                    }
                    
                    $calendar_data = [
                                        'room_id' => $room_id,
                                        'seasonal_name' => $season->seasonal_name,
                                        'date' => $day,
                                        'start_date' => $season->start_date,
                                        'end_date' => $season->end_date,
                                        'price' => $season->price,
                                        'week' => @$season->week,
                                        'month' => @$season->month,
                                        'weekend' => @$season->weekend,
                                        'additional_guest' => @$season->additional_guest,
                                        'guests' => @$season->guests,
                                        'minimum_stay' => $season->minimum_stay,
                                        'status' => 'Available',
                                        'source' => 'Calendar'
                                    ];
                    Calendar::updateOrCreate(['room_id' => $room_id, 'date' => $day], $calendar_data);
                    

                }
                
            }
        }

    }


	/**
	 * Import iCal
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return redirect to Edit Calendar
	 * @throws \Exception
	 */
    public function ical_import(Request $request)
    {

        // Validation for iCal import fields
        $rules = array(
                'url'  => 'required|url',
                'name' => 'required'
                );

        $niceNames = array(
                    'url'  => 'URL',
                    'name' => 'Name'
                    );

        $validator = Validator::make($request->all(), $rules);
        $validator->setAttributeNames($niceNames);

        

        // return back()->with('is_confirm' , 'true');
        $saveAllowed = false;

        if($request->req_type == "check")
        {
            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            else
            {
            // check conflict with reservation
                if($this->checkConflictWithReservation($request->url, $request->id) == true)            // if no conflict
                {
                    
                    $saveAllowed = true;
                }
                else            // if conflict exists
                {
                    
                    return back()->with('is_confirm' , 'true')->withInput();
                }

            }
        }
        else if ($request->req_type == "cancel")
        {
            return back()->with('is_confirm' , 'false');
        }
        else if($request->req_type == "save")
        {

            if ($validator->fails())
            {
                return back()->withErrors($validator)->withInput(); // Form calling with Errors and Input values
            }
            else
            {
                $saveAllowed = true;
            }

        }

        if($saveAllowed = true)
        {            
            // recover relevant seasonal prices            
            $ical_date_ranges = Calendar::where([['room_id',$request->id], ['source', 'Import']])->groupBy('seasonal_name')->get();
            

            // remove old feed data if exists
            $cnt = Calendar::where('room_id', $request->id)->where('source','Import')->get()->count();
            if($cnt > 0) {
                Calendar::where('room_id', $request->id)->where('source','Import')->delete();
            }


            if($ical_date_ranges->count() > 0) {
                foreach ($ical_date_ranges as $date_range) {
                    
                    // $room_id, $fromDate, $toDate
                    $fromDate = $date_range->start_date;
                    $toDate = $date_range->end_date;
                    $room_id = $request->id;
                    $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);

                }
            }


            $ical_data = [
                    'room_id'   => $request->id,
                    'url'       => $request->url,
                    'name'      => $request->name,
                    'last_sync' => date('Y-m-d H:i:s')
                    ];

            
            // Update or Create a iCal imported data
            ImportedIcal::where('room_id', $request->id)->delete();
            
            ImportedIcal::updateOrCreate(['room_id' => $request->id, 'url' => $request->url], $ical_data);

            // Create a new instance of IcalController
            $ical = new IcalController($request->url);
            $events= $ical->events();
            


            // Get events from IcalController
            

            for($i=0; $i<$ical->event_count; $i++)
            {
                $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);

                $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);

                // check if date range of the event is within the past, if past, ignore it.
                if($this->checkIfOldEvent($start_date, $end_date) == true) {                    
                    continue;
                }

                $days       = $this->get_days($start_date, $end_date);
                $date_range = '('. date("m/d/Y", $start_date)  . ' - ' . date("m/d/Y", $end_date) . ')';
                // Update or Create a record
                if(count($days)==1)
                {                    

                     $calendar_data = [
                                    'room_id' => $request->id,
                                    'date'    => $days[0],
                                    'seasonal_name'    => $events[0]['SUMMARY'] . ' ' . $date_range[0],
                                    'start_date' => gmdate("Y-m-d", $start_date),
                                    'end_date' => gmdate("Y-m-d", $end_date),
                                    'notes'   => $events[0]['DESCRIPTION'] ?? $events[0]['SUMMARY'],
                                    'source' => 'Import',
                                    'status'  => 'Not available'
                                    ];
                     Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[0]], $calendar_data);
                }
                else
                {
                    for($j=0; $j<count($days)-1; $j++)
                    {
                        // check if the date of event is past. if past day, ignore it
                        $today = date("Y-m-d");
                        if($days[$j] < $today) {                            
                            continue;
                        }

                        // delete relevant unavailable date ranges
                        $conflict_unavailable = Calendar::where('room_id', $request->id)->where('status', 'Not available')->where('source', 'Calendar')->where('start_date', '<', $days[$j])->where('end_date', '>', $days[$j])->first();

                        if($conflict_unavailable)
                        {
                            $seasonal_name = $conflict_unavailable->seasonal_name;
                            Calendar::where('room_id', $request->id)->where('status', 'Not available')->delete();

                            //recovery relevant season
                            $fromDate = $conflict_unavailable->start_date;
                            $toDate = $conflict_unavailable->end_date;
                            $room_id = $request->id;
                            $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);

                        }

                        $calendar_data = [
                                    'room_id' => $request->id,
                                    'date'    => $days[$j],
                                    'seasonal_name'    => $events[$i]['SUMMARY'] . ' ' . $date_range,
                                    'start_date' => gmdate("Y-m-d", $start_date),
                                    'end_date' => gmdate("Y-m-d", $end_date),
                                    'notes'   => $events[$i]['DESCRIPTION'] ?? $events[$i]['SUMMARY'],
                                    'source' => 'Import',
                                    'status'  => 'Not available'
                                    ];

                        Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[$j]], $calendar_data);
                    }
                }
            }
        }

        return response()->json(
            array(
                'status' => 'success'
            )
        );
        return redirect('manage-listing/'.$request->id.'/calendar');

    }

	/**
	 * @param $room_id
	 * @param $checkin
	 * @param $checkout
	 * @param $edit_seasonal_name
	 *
	 * @return bool
	 */
	/**
	 * @param $room_id
	 * @param $checkin
	 * @param $checkout
	 * @param $edit_seasonal_name
	 *
	 * @return bool
	 */
	/**
	 * @param $room_id
	 * @param $checkin
	 * @param $checkout
	 * @param $edit_seasonal_name
	 *
	 * @return bool
	 */
	public function check_reservation_conflict($room_id, $checkin, $checkout, $edit_seasonal_name) {
//         
       
        $not_available_dates = Calendar::where('status', 'Not available')->orWhere('status', 'Reserved')->where('room_id', $room_id)->where('date', '>=', date('Y-m-d'))->count();   

        // var_dump($room_id,date('Y-m-d') );exit;
        // $not_available_dates = $not_available_dates;

        if($not_available_dates == 0) 
        {
            return true;

        }
      
        $days       = $this->get_days(strtotime($checkin), strtotime($checkout));        

        for($j=0; $j<count($days)-1; $j++)
        {

            $conflict = Calendar::where([['room_id', $room_id], ['status', 'Not available'], ['source', 'Calendar'], ['start_date', '<=', $days[$j]], ['end_date', '>=', $days[$j]], ['seasonal_name','!=', $edit_seasonal_name]])
                ->orWhere([['room_id', $room_id], ['status', 'Not available'], ['source', 'Import'], ['start_date', '<=', $days[$j]], ['end_date', '>', $days[$j]], ['seasonal_name','!=', $edit_seasonal_name]])
                ->orWhere([['room_id', $room_id], ['status', 'Reserved'], ['start_date', '<=', $days[$j]], ['end_date', '>', $days[$j]], ['seasonal_name','!=' , $edit_seasonal_name]])->get();
            if($conflict->count() > 0) {
                
                return false;       
            }

        }
    
        return true;
    }


	/**
	 * @param $season
	 *
	 * @return bool
	 */
	/**
	 * @param $season
	 *
	 * @return bool
	 */
	/**
	 * @param $season
	 *
	 * @return bool
	 */

    public function check_seasonal_conflict($season) {

        $season = json_decode(json_encode($season), FALSE);     // convert string to object

        $start_date =  date('Y-m-d',$this->helper->custom_strtotime($season->start_date));
        $end_date =  date('Y-m-d',$this->helper->custom_strtotime($season->end_date));
        
        $check_cal = SeasonalPrice::where([['room_id', $season->room_id], ['seasonal_name','!=',$season->edit_seasonal_name], ['start_date', '<=', $start_date], ['end_date', '>=', $start_date]])->orWhere([['room_id', $season->room_id], ['seasonal_name','!=',$season->edit_seasonal_name], ['start_date', '<=', $end_date], ['end_date', '>=', $end_date]])->first();

        if($check_cal){
            return false;
        } else {
            return true;
        }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function check_seasonal_conflict_req(Request $request) {
        $data = $request->data;
        if($this->check_seasonal_conflict($data) != true) {
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }
    }


	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function save_seasonal_price(Request $request) {
        $data = $request->data;

        // validation part
        $rules    = [
            'start_date'   => 'required|date',
            'end_date'   => 'required|date',            
            'seasonal_name'     => 'required',
            'price'     => 'required|numeric',
            'minimum_stay'     => 'required|integer|min:1',
            'additional_guest' => 'numeric',
            'week' => 'numeric',
            'month' => 'numeric',
            'weekend' => 'numeric',
        ];

        $attributes = [
            'start_date'   => 'Check in',
            'end_date'   => 'Check out',
            'seasonal_name'     => 'Name',
            'price'     => 'Price',
            'minimum_stay'     => 'Minimum Stay',
            'additional_guest' => 'Price per Guest',
            'week' => 'Weekly Price',
            'month' => 'Monthly Price',
            'weekend' => 'Weekend Price',
        ];
        
        $validator = Validator::make($request->data, $rules, [], $attributes);
        if($validator->fails()) {
            $errors = @$validator->errors()->getMessages();
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }

        if($this->check_seasonal_conflict($data) != true) {
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }

        // end validation

        $data = json_decode(json_encode($data), FALSE); // convert string to object

        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($data->start_date));
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($data->end_date));


        $days = $this->get_days(strtotime($checkin),strtotime($checkout));

        $rooms_price = RoomsPrice::where('room_id',$data->room_id)->first();

        $minimum_amount = $this->payment_helper->currency_convert('USD',$rooms_price->currency_code , 10);

        $currency_symbol = Currency::whereCode($rooms_price->currency_code)->first()->original_symbol;

        if($data->price)
        {
            $old_currency_format = RoomsPrice::find($data->room_id);
            $night_price = $data->price;
            if(is_numeric($night_price) && $night_price < $minimum_amount)
            {
                $msg = trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]);
                $errors = ['price' => [ 0 => $msg]];  
                return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);                
            }
            //$data->night=$night_price;
        }

        if($data->week)
        {
            $old_currency_format = RoomsPrice::find($data->room_id);
            $night_price = $data->week;
            if(is_numeric($night_price) && $night_price < $minimum_amount)
            {
                $msg = trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]);
                $errors = ['week' => [ 0 => $msg]];  
                return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);                
            }
            //$data->night=$night_price;
        }

        if($data->month)
        {
            $old_currency_format = RoomsPrice::find($data->room_id);
            $night_price = $data->month;
            if(is_numeric($night_price) && $night_price < $minimum_amount)
            {
                $msg = trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]);
                $errors = ['month' => [ 0 => $msg]];  
                return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);                
            }
            //$data->night=$night_price;
        }

        if($data->edit_seasonal_name != ""){          // when edit season

            $calendar = Calendar::where('room_id',$data->room_id)->where('seasonal_name',$data->edit_seasonal_name)->where('status', 'Available')->delete();
            SeasonalPrice::where('room_id',$data->room_id)->where('seasonal_name',$data->edit_seasonal_name)->delete();
        }
        
        foreach($days as $day){
            $not_available_date = Calendar::where([
                ['room_id',$data->room_id],
                ['date',$day],
                ['status', 'Not available']
            ])->first();
            if($not_available_date) continue; // if "Not Available" date exist, skip

            $reserved_date = Calendar::where([
                ['room_id',$data->room_id],
                ['date',$day],
                ['status', 'Reserved']
            ])->first();
            if($reserved_date) continue; // if "Not Available" date exist, skip

            $season = [
                        'room_id' => $data->room_id,
                        'date'    => $day,
                        'seasonal_name'    => $data->seasonal_name,
                        'start_date' => $checkin,
                        'end_date' => $checkout,
                        'price'   => $data->price,
                        'week' => @$data->week,
                        'month' => @$data->month,
                        'weekend'   => @$data->weekend,
                        'additional_guest' => @$data->additional_guest,
                        'guests' => @$data->additional_guest ? '1' : '0',
                        'minimum_stay'   => $data->minimum_stay,
                        'source' => 'Calendar',
                        'status'  => 'Available',
                    ];
             Calendar::updateOrCreate(['room_id' => $data->room_id, 'date' => $day], $season);
        }

        $seasonal_price = [
                        'room_id' => $data->room_id,                        
                        'seasonal_name'    => $data->seasonal_name,
                        'start_date' => $checkin,
                        'end_date' => $checkout,
                        'price'   => $data->price,
                        'week' => @$data->week,
                        'month' => @$data->month,
                        'weekend'   => @$data->weekend,
                        'additional_guest' => @$data->additional_guest,
                        'guests' => @$data->additional_guest ? '1' : '0',
                        'minimum_stay'   => $data->minimum_stay,
                        'source' => 'Calendar',
                        'status'  => 'Available',
                    ];
        SeasonalPrice::updateOrCreate(['room_id' => $data->room_id, 'seasonal_name' => $data->edit_seasonal_name], $seasonal_price);
        return json_encode(['success' =>'true']);
    }

	/**
	 * @param $season
	 *
	 * @return bool
	 */

    public function check_unavailable_conflict($season) {

        $season = json_decode(json_encode($season), FALSE);     // convert string to object

        $start_date =  date('Y-m-d',$this->helper->custom_strtotime($season->start_date));
        $end_date =  date('Y-m-d',$this->helper->custom_strtotime($season->end_date));

        $days       = $this->get_days(strtotime($start_date), strtotime($end_date));
        foreach ($days as $day ) {
            $check_cal = Calendar::where('date',$day)->where('room_id',$season->room_id)->where('seasonal_name','!=','')
                ->where('seasonal_name','!=',$season->edit_seasonal_name)
                ->where(function($query) {
                    $query->where('status', 'Not available')->orWhere('status', 'Reserved');
                })->first();

            if(($check_cal)) {

                return false;
            }
        }

        return true;
    }


	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function check_unavailable_conflict_req(Request $request) {
        $data = $request->data;
        if($this->check_unavailable_conflict($data) != true) {
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function save_unavailable_dates(Request $request) {

        $data = $request->data;

        // validation part
        $rules    = [
            'start_date'   => 'required|date',
            'end_date'   => 'required|date',            
            'seasonal_name'     => 'required'
        ];

        $attributes = [
            'start_date'   => 'Check in',
            'end_date'   => 'Check out',
            'seasonal_name'     => 'Season Name'
        ];
        
        $validator = Validator::make($request->data, $rules, [], $attributes);
       
        if($validator->fails()) {
            $errors = @$validator->errors()->getMessages();
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }

        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));

        if($this->check_unavailable_conflict($data) != true) {
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }

        // end validation

        $data = json_decode(json_encode($data), FALSE); // convert string to object

        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($data->start_date));
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($data->end_date));


        $days = $this->get_days(strtotime($checkin),strtotime($checkout));
        
        if($data->edit_seasonal_name !== ""){          // when edit unavailable dates
            // recovery relevant season            
            $not_available_date = Calendar::where('room_id',$data->room_id)->where('seasonal_name',$data->edit_seasonal_name)->where('status', 'Not available')->where('source', 'Calendar')->first();
            
            // delete all records of the unavailable date range which is to be updated
            Calendar::where('room_id',$data->room_id)->where('seasonal_name',$data->edit_seasonal_name)->where('status', 'Not available')->where('source', 'Calendar')->delete();
            // must recover season only after delete all records of the unavailable date range (because recovery function use updateOrCreate function)
            
            if($not_available_date)
            {
                $fromDate = $not_available_date->start_date;
                $toDate = $not_available_date->end_date;
                $room_id = $data->room_id;
                $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);    
            }
        }

        foreach($days as $day){
            $ical_date = Calendar::where('room_id',$request->id)->where('date', $day)->where('source', 'Import')->first();
            if($ical_date) continue; // if iCal date exists, skip

            $season = [
                            'room_id' => $data->room_id,
                            'date'    => $day,
                            'seasonal_name'    => $data->seasonal_name,
                            'start_date' => $checkin,
                            'end_date' => $checkout,                            
                            'source' => 'Calendar',
                            'status'  => 'Not available'
                            ];
             Calendar::updateOrCreate(['room_id' => $data->room_id, 'date' => $day], $season);
            
        }
         return json_encode(['success' =>'true']);
    }


	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function check_reservation_conflict_req(Request $request) {
        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));
        if($this->check_reservation_conflict($request->id, $checkin, $checkout, $request->edit_seasonal_name) != true) {            
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }   
    }

	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function save_reservation(Request $request) {
      
        // validation part
        $rules    = [
            'start_date'   => 'required|date',
            'end_date'   => 'required|date',            
            'seasonal_name'     => 'required',
            'price'     => 'required|numeric',
            'guests'     => 'required|numeric|min:1'
        ];

        


        $attributes = [
            'start_date'   => 'Check in',
            'end_date'   => 'Check out',
            'seasonal_name'     => 'Name',
            'price'     => 'Price',
            'guests'     => 'Number of Guests'
        ];
        
        $validator = Validator::make($request->all(), $rules, [], $attributes);
        
        if($validator->fails()) {
            $errors = @$validator->errors()->getMessages();            
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }   
        // dd($request->end_date);
        // $start_date = date("Y-m-d", strtotime($request->start_date));
      
        $checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
     
        $checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));
        // dd($request->id,$request->edit_seasonal_name, $checkin, $checkout);
      
         //dd($this->check_reservation_conflict($request->id, $checkin, $checkout, $request->edit_seasonal_name));
        if($this->check_reservation_conflict($request->id, $checkin, $checkout, $request->edit_seasonal_name) != true) {            
            $errors = ['start_date' => [ 0 => 'Sorry,there is a conflict'], 'end_date' => [ 0 => 'Sorry,there is a conflict']];  
            return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
        }
     
        // end validation
        
        $source = $request->reservation_source;        
       
        if(($source == "Calendar") || ($source == "Reservation")) {             
            $status = "Reserved";    

        } else if($source == "Import") {            
            $status = "Not available";    

        }

        $days = $this->get_days(strtotime($checkin),strtotime($checkout));        
        if($request->edit_seasonal_name !== ""){          // in case of edit             
            // recovery relevant season            
            $original_reservation = Calendar::where('room_id', $request->id)->where('seasonal_name',$request->edit_seasonal_name)->where('status', $status)->where('source', $source)->first();
            
            // delete all records of the unavailable date range which is to be updated
            $calendar = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->edit_seasonal_name)->where('status', $status)->where('source', $source)->delete();
            // must recover season only after delete all records of the unavailable date range (because recovery function use updateOrCreate function)
            
            if($original_reservation)
            {
                $fromDate = $original_reservation->start_date;
                $toDate = $original_reservation->end_date;
                $room_id = $request->id;
                $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);    
            }
        }

        if($request->edit_seasonal_name !== ""){          // when update reservation, delete original reservation
            $calendar = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->edit_seasonal_name)->where('status', $status)->where('source', $source)->delete();            
        }

        for($i=0; $i < count($days) - 1; $i++) {    //eliminate check out date

            $reservation = [
                            'room_id' => $request->id,
                            'date'    => $days[$i],
                            'seasonal_name'    => $request->seasonal_name,
                            'start_date' => $checkin,
                            'end_date' => $checkout,
                            'notes'   => $request->notes,
                            'price'   => $request->price,
                            'guests'   => $request->guests,
                            'source' => $source,
                            'status'  => $status
                            ];
             Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[$i]], $reservation);
            
        }

        if($source == "Reservation") {
            $reservation_id = $original_reservation->reservation_id();

            if($reservation_id) {
                $reservation = [                                                        
                            'checkin' => $checkin,
                            'checkout' => $checkout,
                            'nights'   => $request->price,
                            'number_of_guests'   => $request->guests,                                                     
                        ];
                Reservation::updateOrCreate(['id' => $reservation_id], $reservation);    
            }
        }

        return json_encode(['success' =>'true']);
    }

	/**
	 * Check Conflict With Reservation
	 *
	 * @param string $feed_url iCal feed url
	 * @param        $room_id
	 *
	 * @return bool check result
	 */
    public function checkConflictWithReservation($feed_url, $room_id)
    {
                
        // Create a new instance of IcalController
        $ical = new IcalController($feed_url);
        $events= $ical->events();

        $reservation_conflict_flag = "uncertain";
        $unavailable_conflict_flag = "uncertain";

        $reserve = Reservation::where('room_id', $room_id)->where('status', 'Accepted')->get();        
        if($reserve->count() == 0) 
        {
            $reservation_conflict_flag = "never";    // if no exists reservation, set flag
            
        }
//        
        $not_available_dates = Calendar::where('room_id', $room_id)->where('status', 'Not available')->where('source', '!=' ,'Import')->get();        
        if($not_available_dates->count() == 0) 
        {
            $unavailable_conflict_flag = "never";     // if no exists unavailable data range, set flag
            
        }

        if(($reservation_conflict_flag == "never") && ($unavailable_conflict_flag == "never")) 
        {
            
            return true;
        }
        session()->forget('reservation');
        session()->forget('not_available');

        for($i=0; $i<$ical->event_count; $i++)
        {
            $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);
            $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);            

            // check if date range of the event is within the past, if past, ignore it.
            if($this->checkIfOldEvent($start_date, $end_date) == true) {                
                continue;
            }

            $days       = $this->get_days($start_date, $end_date);

            for($j=0; $j<count($days)-1; $j++)
            {
                // check if the date of event is past. if past day, ignore it
                $today = date("Y-m-d");
                if($days[$j] < $today) {                    
                    continue;
                }

                if($reservation_conflict_flag == "uncertain")
                {
                    $conflict_resevation = Reservation::where('room_id', $room_id)->where('status', 'Accepted')->where('checkin', '<=', $days[$j])->where('checkout', '>', $days[$j])->get();
                      if($conflict_resevation->count() > 0) {
                           
                        session()->put('reservation', $days[$j]);                        
                        $reservation_conflict_flag = "exist";
                        if($unavailable_conflict_flag == "exist") return false;
                      }

                }

                if($unavailable_conflict_flag == "uncertain") {

                    $conflict_unavailable = Calendar::where('room_id', $room_id)->where('status', 'Not available')->where('source', '!=' ,'Import')->where('start_date', '<=', $days[$j])->where('end_date', '>=', $days[$j])->get();
                      if($conflict_unavailable->count() > 0) {
                       
                        session()->put('not_available', $days[$j]);
                        $unavailable_conflict_flag = "exist";
                        if($reservation_conflict_flag == "exist") return false;
                      }
                }
                
            }
        }

        if(($reservation_conflict_flag == "exist") || ($unavailable_conflict_flag == "exist")) return false;
        return true;
    }

	/**
	 * Check Conflict With Reservation
	 *
	 * @param date $start_date $end_date  Date range of iCal event
	 * @param      $end_date
	 * @return boolean check result
	 */
    public function checkIfOldEvent($start_date, $end_date)
    {        
        $start_date   = gmdate("Y-m-d", $start_date);
        $end_date     = gmdate("Y-m-d", $end_date);
        $today = date("Y-m-d");

        return ($end_date < $today) ? true : false;
    }


	/**
	 * iCal Synchronization
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return redirect to Edit Calendar
	 */
    public function ical_sync(Request $request)
    {
        // Get all imported iCal URLs for give Room ID
        $result = ImportedIcal::where('room_id', $request->id)->get();

        foreach($result as $row)
        {
            // Create a new instance of IcalController
            $ical   = new IcalController($row->url);
            $events = $ical->events();

            // Get events from IcalController
            for($i=0; $i<$ical->event_count; $i++)
            {
                $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);

                $end_date   = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);

                $days       = $this->get_days($start_date, $end_date);
                $date_range = '('. date("m/d/Y", $start_date)  . ' - ' . date("m/d/Y", $end_date) . ')';
                // Update or Create a events
                if(count($days)==1)
                {
                     $calendar_data = [
                                    'room_id' => $request->id,
                                    'date'    => $days[0],
                                    'seasonal_name'    => $events[0]['SUMMARY'] . ' ' . $date_range[0],
                                    'start_date' => gmdate("Y-m-d", $start_date),
                                    'end_date' => gmdate("Y-m-d", $end_date),
                                    'notes'   => $events[0]['DESCRIPTION'] ?? $events[0]['SUMMARY'],
                                    'source' => 'Import',
                                    'status'  => 'Not available'
                                    ];
                     Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[0]], $calendar_data);
                }
                else{
                    for($j=0; $j<count($days)-1; $j++)
                    {
                        $calendar_data = [
                                    'room_id' => $request->id,
                                    'date'    => $days[$j],
                                    'seasonal_name'    => $events[$i]['SUMMARY'] . ' ' . $date_range,
                                    'start_date' => gmdate("Y-m-d", $start_date),
                                    'end_date' => gmdate("Y-m-d", $end_date),
                                    'notes'   => $events[$i]['DESCRIPTION'] ?? $events[$i]['SUMMARY'],
                                    'source' => 'Import',
                                    'status'  => 'Not available'
                                    ];

                        Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $days[$j]], $calendar_data);
                    }
                }
            }

            // Update last synchronization DateTime
            $imported_ical = ImportedIcal::find($row->id);

            $imported_ical->last_sync = date('Y-m-d H:i:s');

            $imported_ical->save();
        }

        return redirect('manage-listing/'.$request->id.'/calendar');
    }

    /**
     * Get days between two dates
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
     */
    public function get_days($sStartDate, $sEndDate)
    {
        $sStartDate   = gmdate("Y-m-d", $sStartDate);
        $sEndDate     = gmdate("Y-m-d", $sEndDate);

        $aDays[]      = $sStartDate;

        $sCurrentDate = $sStartDate;

        while($sCurrentDate < $sEndDate)
        {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

            $aDays[]      = $sCurrentDate;
        }

        return $aDays;
    }

    /**
     * Get days between two dates for reservation
     *
     * @param date $sStartDate  Start Date
     * @param date $sEndDate    End Date
     * @return array $days      Between two dates
     */
    public function get_days_reservation($sStartDate, $sEndDate)
    {
        $aDays[]      = $sStartDate;

        $sCurrentDate = $sStartDate;

        while($sCurrentDate < $sEndDate)
        {
            $sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

            $aDays[]      = $sCurrentDate;
        }

        return $aDays;
    }

     /* Delete ical functionality */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function ical_delete(Request $request)
    {
        ImportedIcal::find($request->id)->delete();

        return redirect('manage-listing/'.$request->room_id.'/calendar');
    }

     /* Refresh ical functionality */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 * @throws \Exception
	 */
	public function ical_refresh(Request $request)
    {
        
        $ical_feed = ImportedIcal::find($request->id);

        $ical_date_ranges = Calendar::where([['room_id',$ical_feed->room_id], ['source', 'Import']])->groupBy('seasonal_name')->get();

        // remove old feed data if exists
        $cnt = Calendar::where('room_id', $ical_feed->room_id)->where('source','Import')->get()->count();
        if($cnt > 0) {
            Calendar::where('room_id', $ical_feed->room_id)->where('source','Import')->delete();
        }


        if($ical_date_ranges->count() > 0) {
            foreach ($ical_date_ranges as $date_range) {
                
                // $room_id, $fromDate, $toDate
                $fromDate = $date_range->start_date;
                $toDate = $date_range->end_date;
                $room_id = $ical_feed->room_id;
                $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);

            }
        }


        // Create a new instance of IcalController
        $ical = new IcalController($ical_feed->url);
        $events= $ical->events();

        // Get events from IcalController
        for($i=0; $i<$ical->event_count; $i++)
        {
            $start_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTSTART']);

            $end_date = $ical->iCalDateToUnixTimestamp($events[$i]['DTEND']);
            

            // check if date range of the event is within the past, if past, ignore it.
            if($this->checkIfOldEvent($start_date, $end_date) == true) {                    
                continue;
            }

            if($this->checkIcalEventConflict($start_date, $end_date, $ical_feed->room_id) == true) {
                continue;
            }

            $days = $this->get_days($start_date, $end_date);
            $date_range = '('. date("m/d/Y", $start_date)  . ' - ' . date("m/d/Y", $end_date) . ')';

            // Update or Create a events
            if(count($days)==1)
            {
                 $calendar_data = [
                                'room_id' => $ical_feed->room_id,
                                'date'    => $days[0],
                                'seasonal_name'    => $events[0]['SUMMARY'] . ' ' . $date_range[0],
                                'start_date' => gmdate("Y-m-d", $start_date),
                                'end_date' => gmdate("Y-m-d", $end_date),
                                'notes'   => $events[0]['DESCRIPTION'] ?? $events[0]['SUMMARY'],
                                'source' => 'Import',
                                'status'  => 'Not available'
                                ];
                 Calendar::updateOrCreate(['room_id' => $ical_feed->room_id, 'date' => $days[0]], $calendar_data);
            }
            else{
              for($j=0; $j<count($days)-1; $j++)
              {
                  // check if the date of event is past. if past day, ignore it
                  $today = date("Y-m-d");
                  if($days[$j] < $today) {                            
                      continue;
                  }

                  // delete relevant unavailable date ranges
                  $conflict_unavailable = Calendar::where('room_id', $ical_feed->room_id)->where('status', 'Not available')->where('source', 'Calendar')->where('start_date', '<', $days[$j])->where('end_date', '>', $days[$j])->first();

                  if($conflict_unavailable)
                  {
                      $seasonal_name = $conflict_unavailable->seasonal_name;
                      Calendar::where('room_id', $ical_feed->room_id)->where('status', 'Not available')->delete();

                      //recovery relevant season
                      $fromDate = $conflict_unavailable->start_date;
                      $toDate = $conflict_unavailable->end_date;
                      $room_id = $ical_feed->room_id;
                      $this->recoverSeasonalPrices($room_id, $fromDate, $toDate);

                  }

                  $calendar_data = [
                              'room_id' => $ical_feed->room_id,
                              'date'    => $days[$j],
                              'seasonal_name'    => $events[$i]['SUMMARY'] . ' ' . $date_range,
                              'start_date' => gmdate("Y-m-d", $start_date),
                              'end_date' => gmdate("Y-m-d", $end_date),
                              'notes'   => $events[$i]['DESCRIPTION'] ?? $events[$i]['SUMMARY'],
                              'source' => 'Import',
                              'status'  => 'Not available'
                              ];

                  Calendar::updateOrCreate(['room_id' => $ical_feed->room_id, 'date' => $days[$j]], $calendar_data);
              }
            }
        }

        // Update last synchronization DateTime
        $imported_ical = ImportedIcal::find($ical_feed->id);

        $imported_ical->last_sync = date('Y-m-d H:i:s');

        $imported_ical->save();

        return redirect('manage-listing/'.$request->room_id.'/calendar');
    }

	/**
	 * Check if iCal event conflicts With Reservation
	 *
	 * @param string $start_date , $end_date  iCal event date range
	 * @param        $end_date
	 * @param        $room_id
	 * @return bool check result
	 */
    public function checkIcalEventConflict($start_date, $end_date, $room_id)
    {

        $days       = $this->get_days($start_date, $end_date);

        for($j=0; $j<count($days)-1; $j++)
        {
            // check if the date of event is past. if past day, ignore it
            $today = date("Y-m-d");
            if($days[$j] < $today) {                    
                continue;
            }

            $conflict_resevation = Reservation::where('room_id', $room_id)->where('status', 'Accepted')->where('checkin', '<=', $days[$j])->where('checkout', '>', $days[$j])->get();
            if($conflict_resevation->count() > 0) {
                return true;                    
            }

            
        }
        return false;
    }


}
