<?php

/**
 * Search Controller
 *
 * @package     Makent
 * @subpackage  Controller
 * @category    Search
 * @author      Trioangle Product Team
 * @version     1.5.4.1.1
 * @link        http://trioangle.com
 */

namespace App\Http\Controllers\Front;
 
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Front\PropertyType;
use App\Models\Front\RoomType;
use App\Models\Front\Rooms;
use App\Models\Front\RoomsPhotos;
use App\Models\Front\HostExperiencePhotos;
use App\Models\Front\HostExperiences;
use App\Models\Front\RoomsAddress;
use App\Models\Front\Amenities;
use App\Models\Front\AmenitiesType;
use App\Models\Front\Calendar;
use App\Models\Front\HostExperienceCalendar;
use App\Models\Front\HostExperienceCategories;
use App\Models\Front\HomeCities;
use App\Models\Front\Page;
use Session;
use App\Models\Front\Currency;
use App\Http\Controllers\Controller;
use App\Http\Helper\PaymentHelper;
use App\Http\Start\Helpers;
use DB;
use Auth;
use Log;

/**
 * Class SearchController
 *
 * @package App\Http\Controllers
 */
class SearchController extends Controller
{
    protected $payment_helper; // Global variable for Helpers instance
    protected $helper;  // Global variable for instance of Helpers
    public $map_tolerence;   // set the tolerance of latitude and longitude from the google map api

	/**
	 * Constructor to Set PaymentHelper instance in Global variable
	 *
	 * @param \App\Http\Helper\PaymentHelper $payment Instance of PaymentHelper
	 */
    public function __construct(PaymentHelper $payment)
    {
        $this->payment_helper = $payment;
        $this->helper = new Helpers;
        $this->map_tolerence = 0.2;
        DB::enableQueryLog();        
    }

 
	/**
	 * Search index
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \BladeView|bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request){
       
        $current_refinement="Homes"; //either homes or experiences default Homes
        if(!empty($request->input('current_refinement')))
        {
            $current_refinement=@$request->input('current_refinement');
        }
        

        $previous_currency = Session::get('search_currency');
        $currency = Session::get('currency');
       
        $checkin_date_format        = $request->input('checkin_date_format');
        $checkout_date_format      = $request->input('checkout_date_format');
        $php_date_format      = $request->input('php_date_format');
        if(!empty($request->input('checkin_date_format'))){
            $data['st_date'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($checkin_date_format, $php_date_format));            
        } elseif(!empty($request->input('checkin')) && $this->helper->custom_strtotime($request->input('checkin'), $php_date_format)) {
            $data['st_date'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkin'), $php_date_format));
            //$data['checkin'] = $request->input('checkin'); Previously used method for reference
            $data['checkin'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkin'), $php_date_format));
        } else {
            $data['checkin'] = date('Y-m-d');
            $data['st_date'] = date('Y-m-d');
        } 


        if(!empty($request->input('checkout_date_format'))){
            $data['end_date'] = date(env('PHP_DATE_FORMAT'), $this->helper->custom_strtotime($checkout_date_format, $php_date_format));
        } elseif(!empty($request->input('checkout')) && $this->helper->custom_strtotime($request->input('checkout'), $php_date_format)) {
            $data['end_date'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkout'), $php_date_format));
            //$data['checkout'] = $request->input('checkout'); Previously used method for reference
            $data['checkout'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkout'), $php_date_format));
        } else {
            $data['end_date'] = date('Y-m-d');
            $data['checkout'] = date('Y-m-d');
        }    
        
        $data['location']           = $request->input('location');
        
        
        $data['guest']              = $request->input('guests')=='' ? 1 : $request->input('guests');
        $data['bedrooms']           = $request->input('bedrooms');
        $data['bathrooms']          = $request->input('bathrooms');
        $data['beds']               = $request->input('beds');
        $data['property_type']      = $request->input('property_type');
        $data['room_type']          = $request->input('room_type');
        $data['amenities']          = $request->input('amenities');
        $data['min_price']          = $request->input('min_price');
        $data['max_price']          = $request->input('max_price');
        $data['instant_book']       = $request->input('instant_book') ? $request->input('instant_book') : 0;
        $data['property_id']       = $request->input('property_id') ? $request->input('property_id') : '';
        
        $data['room_type']          = RoomType::dropdown();
        $data['room_types']         = RoomType::where('status','Active')->get();
        $data['property_type_dropdown']      = PropertyType::active_all();
        $data['amenities']          = Amenities::activeType()->active()->get();
        $data['amenities_type']     = AmenitiesType::active_all();
        
        $data['property_type_selected'] =$request->input('property_type');
        $data['room_type_selected'] = $request->input('room_type');
        $data['amenities_selected'] = $request->input('amenities');
        $data['currency_symbol']    = Currency::find(1)->symbol;
        $data['cat_type_selected'] = $request->input('host_experience_category');
        $data['default_min_price'] = $this->payment_helper->currency_convert('USD', $currency, 10);
        $data['default_max_price'] = $this->payment_helper->currency_convert('USD', $currency, 5000);

        if(!$data['min_price'])
        {
            $data['min_price'] = $data['default_min_price'];
            $data['max_price'] = $data['default_max_price'];
        }elseif($previous_currency){
            $data['min_price'] = $this->payment_helper->currency_convert($previous_currency, $currency, $data['min_price']); 
            $data['max_price'] = $this->payment_helper->currency_convert($previous_currency, $currency, $data['max_price']); 
        } else {
            $data['min_price'] = $this->payment_helper->currency_convert('', $currency, $data['min_price']);
            $data['max_price'] = $this->payment_helper->currency_convert('', $currency, $data['max_price']);
        }
        $data['max_price_check'] = $this->payment_helper->currency_convert('', 'USD', $data['max_price']);
        $data['current_refinement']=$current_refinement;

        Session::forget('search_currency');
        $current_location0 = preg_replace('/\s+/', '', $request->location);
       
        $current_location1 = str_replace("-", ", ", "$current_location0");
        $current_location5 = str_replace("-", ",", "$current_location0");
        $current_location = str_replace("-", " ", "$current_location1");
        $current_location = str_replace("%2C+", " ", "$current_location");
        $data['meta_title'] = $current_location;

        $data['location'] = @$request->location;
        if(is_numeric($request->location)){
            $room = Rooms::with('rooms_address')->find($request->location);

            $cLat  = $room->rooms_address->latitude;
            $cLong = $room->rooms_address->longitude;
            // return $room;
            $data['cLat'] =$cLat;
            $data['cLong']= $cLong;
        }
        else if($request->location){
            $address      = str_replace([" ","%2C"], ["+",","], "$request->location");
            $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&address='.$address.'&sensor=false&libraries=places');
            $json         = json_decode($geocode);
        }
        else{
            $user_ip = $_SERVER['REMOTE_ADDR'];
            if($user_ip == '127.0.0.1'){
                $externalContent = file_get_contents('http://checkip.dyndns.com/');
                preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                $user_ip = $m[1];
            }
            $url = json_decode(file_get_contents("http://ipinfo.io/$user_ip/?key=".env('IP_INFO_KEY')));
            $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&latlng='.$url->loc.'&sensor=false&libraries=places');
            $json         = json_decode($geocode);
        }

        if(@$json->{'results'})
        {
            $cLat  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
            $cLong = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
            $data['cLat'] =$cLat;
            $data['cLong']= $cLong;
        }
       
        return $data;
	}
    function searchexperienceResult(Request $request)
    {
    
        
        $previous_currency = Session::get('previous_currency');
        $currency = Session::get('currency');
        $full_address  = $request->input('location');

      
        $checkin       = $request->input('checkin');
      
        $checkout      = $request->input('checkout');
        $guest         = $request->input('guest');
        $host_experience_category = $request->input('host_experience_category');
        $min_price     = $request->input('min_price');
        $max_price     = $request->input('max_price');
        $map_details   = $request->input('map_details');
        
        $data['viewport'] = '';

        if(!$min_price)
        {
            $min_price = $this->payment_helper->currency_convert('USD', '', 0);
            $max_price = $this->payment_helper->currency_convert('USD', '', 5000);
        }
        
        if(!is_array($host_experience_category))
        {
            if($host_experience_category != '')
             $host_experience_category = explode(',', $host_experience_category);
            else
             $host_experience_category = [];
        }
        
       

        $property_type_val   = [];
        $category_val   = [];
        $rooms_whereIn       = [];
        $room_type_val       = [];
        $rooms_address_where = [];
        
        $address      = str_replace([" ","%2C"], ["+",","], "$full_address");
        $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&address='.$address.'&sensor=false&libraries=places');
        $json         = json_decode($geocode);
        
        if(@$json->results);
        {
        foreach($json->results as $result)
        {
            foreach($result->address_components as $addressPart)
            {
                if((in_array('locality', $addressPart->types)) && (in_array('political', $addressPart->types)))
                {
                    $city1 = $addressPart->long_name;
                    $rooms_address_where['host_experience_location.city'] = $city1;
                }
                if((in_array('administrative_area_level_1', $addressPart->types)) && (in_array('political', $addressPart->types)))
                {
                    $state = $addressPart->long_name;
                    $rooms_address_where['host_experience_location.state'] = $state;
                }
                if((in_array('country', $addressPart->types)) && (in_array('political', $addressPart->types)))
                {
                    $country = $addressPart->short_name;
                    $rooms_address_where['host_experience_location.country'] = $country;
                }
            }
        }
        }

        if($map_details != '')
        {
            $map_detail =   explode('~', $map_details);
            $zoom       =   $map_detail[0];
            $bounds     =   $map_detail[1];
            $minLat     =   $map_detail[2];
            $minLong    =   $map_detail[3];
            $maxLat     =   $map_detail[4];
            $maxLong    =   $map_detail[5];
            $cLat       =   $map_detail[6]; 
            $cLong      =   $map_detail[7];

            if($minLong>$maxLong){
                if($maxLong > 0){
                    $maxLong = $minLong;
                    $minLong = "-180"; 
                }else{
                    $maxLong = "180";
                }
            }
            // dump($zoom,$bounds,$minLat,$maxLat,$minLong,$maxLong,$cLat,$cLong);
        }
        else
        {
            if(@$json->{'results'})
            {
                // $data['lat'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                // $data['long'] = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                $data['viewport'] = $json->{'results'}[0]->{'geometry'}->{'viewport'};

                $minLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lat'};
                $maxLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lat'};
                $minLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lng'};
                $maxLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lng'};
            }
            else
            {
                $data['lat'] = 0;
                $data['long'] = 0;

                $minLat = 0;
                $maxLat = 0;
                $minLong = 0;
                $maxLong = 0;
            }
        }
        $users_where['users.status']    = 'Active';

        $checkin  = date('Y-m-d', $this->helper->custom_strtotime($checkin));
        $checkout = date('Y-m-d', $this->helper->custom_strtotime($checkout));
        
        $days     = $this->get_days($checkin, $checkout);

        // unset($days[count($days)-1]);

        $calendar_where['date'] = $days;

        $not_available_room_ids = HostExperienceCalendar::whereIn('date', $days)->whereStatus('Not available')->distinct()->pluck('host_experience_id');

        $rooms_where['host_experiences.number_of_guests'] = $guest ? $guest : 1;
        
        $rooms_where['host_experiences.status']       = 'Listed';
        $rooms_where['host_experiences.admin_status']       = 'Approved';
            
        
        if(count($host_experience_category))
        {                    
            foreach($host_experience_category as $category_value)
                array_push($category_val, $category_value);
        }
        

        $currency_rate = Currency::where('code', Currency::find(1)->session_code)->first()->rate;

        $max_price_check = $this->payment_helper->currency_convert('', 'USD', $max_price);

        $rooms = HostExperiences::with(['host_experience_location' => function($query) use($minLat, $maxLat, $minLong, $maxLong) { },
                            'currency' => function($query){},
                            'category_details' => function($query){},
                            'user' => function($query) use($users_where) {
                                $query->with('profile_picture')
                                      ->where($users_where);
                            },
                            'saved_wishlists' => function($query) {
                                $query->where('user_id', @Auth::user()->id);
                            }])
                            ->whereHas('host_experience_location', function($query) use($minLat, $maxLat, $minLong, $maxLong) {
                                 $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
                            })
                            /*->whereHas('currency',function($query) use($min_price, $max_price, $currency_rate, $max_price_check) {
                                if($max_price_check >= 750)
                                {
                                    $query->whereRaw('((price_per_guest / currency.rate) * '.$currency_rate.') >= '.$min_price);
                                }
                                else
                                {
                                    $query->whereRaw('((price_per_guest / currency.rate) * '.$currency_rate.') >= '.$min_price.' and ((price_per_guest / currency.rate) * '.$currency_rate.') <= '.$max_price);
                                }
                            }) */                          
                            ->whereHas('user', function($query) use($users_where) {
                                $query->where($users_where);
                            })
                            // ->whereNotIn('id', $not_available_room_ids)
                            ->daysAvailable($days, $guest);
        if($rooms_where)
        {
            foreach($rooms_where as $row=>$value)
            {
                if($row == 'host_experiences.number_of_guests')
                    $operator = '>=';
                else
                    $operator = '=';

                if($value == '')
                    $value = 0;

                $rooms = $rooms->where($row, $operator, $value);
            }
        }
        if(count($host_experience_category))
        {                    
            $rooms = $rooms->where(function($query) use($category_val) {
                $query->whereIn('category',$category_val);
                $query->orwhereIn('secondary_category',$category_val);
            });
        }
        $rooms = $rooms->orderByRaw('RAND(1234)')->paginate(18)->toJson();
        echo $rooms;
    }


	/**
	 * Ajax Search Result
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return void Search results
	 */

    public function searchResultOnMap(Request $request){
        
        $full_address  = $request->input('location');
        
        $map_details   = $request->input('map_details');
        $checkin       = $request->input('checkin');
        $checkout      = $request->input('checkout');
        $guest         = $request->input('guest');
        $bathrooms     = $request->input('bathrooms');
        $bedrooms      = $request->input('bedrooms');
        $beds          = $request->input('beds');
        $property_type = $request->input('property_type');
        $room_type     = $request->input('room_type');
        $amenities     = $request->input('amenities');
        $min_price     = $request->input('min_price');
        $max_price     = $request->input('max_price');
        $instant_book  = $request->input('instant_book');
        $property_id   = $request->input('property_id');
        $limit_distance     = $request->input('limit_distance');
        
        if(!is_array($room_type))
        {
            if($room_type != '')
             $room_type = explode(',', $room_type);
            else
             $room_type = [];
        }
        //
        if(!is_array($property_type))
        {
            if($property_type != '')
             $property_type = explode(',', $property_type);
            else
             $property_type = [];
        }

        if(!is_array($amenities))
        {
            if($amenities != '')
             $amenities = explode(',', $amenities);
            else
             $amenities = [];
        }

        $property_type_val   = [];
        $room_type_val       = [];
        $rooms_whereIn       = [];
        $cLat = $full_address['center']['lat'];
        $cLong =$full_address['center']['lng'];

        $minLat = $full_address['southWest']['lat'];
        $maxLat = $full_address['northEast']['lat'];
        $minLong = $full_address['southWest']['lng'];
        $maxLong = $full_address['northEast']['lng'];
        // dd($cLat, $cLong);
        // dd($full_address);
        $checkin  = date('Y-m-d', $this->helper->custom_strtotime($checkin));
        $checkout = date('Y-m-d', $this->helper->custom_strtotime($checkout));
        $dates_available = ($request->input('checkin') !='');
        $days     = $this->get_days($checkin, $checkout);
        unset($days[count($days)-1]);
        $total_nights = count($days);

        $total_weekends = 0;
        foreach($days as $day) {
            $weekday = date('N', strtotime($day));
            if( in_array($weekday, [5,6]) ) {
                $total_weekends++;
            }
        }
        $total_guests                       = $guest-0;

        $max_price_check = $this->payment_helper->currency_convert('', 'USD', $max_price);

        $not_available_room_ids = [];
        $not_available_room_ids = Calendar::daysNotAvailable($days, $total_guests);//->distinct()->pluck('room_id')->toArray();
        $not_available_room_ids = array_unique($not_available_room_ids);
        // $rooms = Rooms::with(['rooms_address',
        // 'users' => function($query) {
        //     $query->with('profile_picture');
        // }, 'rooms_price']);
        $rooms =DB::table('rooms')->select('rooms.id',
        'rooms_address.latitude as lat',
         'rooms_address.longitude as lng'
        
        );
        $rooms = $rooms->whereNotIn('rooms.id', $not_available_room_ids);
        $cenLat = ($minLat + $maxLat) / 2;
        $cenLong = ($minLong + $maxLong) / 2;
        $rooms = $rooms->join('rooms_address', 'rooms.id', '=', 'rooms_address.room_id');
        $date = date('Y-m-d');
        // $rooms = $rooms->leftJoin('reviews', 'reviews.room_id', '=', 'rooms.id');

        $rooms = $rooms->join('subscriptions', 'rooms.user_id', '=', 'subscriptions.user_id');
        $rooms = $rooms->join('rooms_price', 'rooms.id', '=', 'rooms_price.room_id');
        $rooms = $rooms->join('membershiptypes', 'membershiptypes.Name', '=', 'subscriptions.name');
        
        
        $rooms->where( "subscriptions.ends_at" , ">=", DB::raw("'$date'"));
        $rooms->where( "rooms.subscription_end_date" , ">=", DB::raw("'$date'"));
        $rooms->where( "rooms.subscription_start_date" , "<=", DB::raw("'$date'"));
        $rooms->where( "rooms.subscription_start_date" , "!=", DB::raw("0000-00-00"));
        // dd($minLat, $maxLat, $minLong, $maxLong);
        $rooms->whereRaw(" rooms_address.latitude between '$minLat' and '$maxLat' and rooms_address.longitude between '$minLong' and '$maxLong' ");
        if(isset($searchCountry)){
            $rooms = $rooms->whereRaw("country = '$searchCountry'");
        }
        $property_type = array_values($property_type);
        if(count($property_type))
        {
            $rooms = $rooms->whereIn('rooms.property_type', $property_type);
        }
        if(count($amenities))
        {
            foreach($amenities as $amenities_value)
            {
                $rooms = $rooms->whereRaw('find_in_set('.$amenities_value.', rooms.amenities)');
            }
        }
        $rooms = $rooms->where('rooms.accommodates' , '>=', $guest);
        $rooms = $rooms->where('rooms_price.night' , '>=', $min_price);
        $rooms = $rooms->where('rooms_price.night' , '<=', $max_price);
        $rooms = $rooms->orderBy('membershiptypes.annual_fee', 'desc');
        $rooms->groupBy('rooms.id');
        
        return($rooms->get());
    }
    public function searchResult(Request $request){
        ob_start();
        $full_address  = $request->input('location');
        $map_details   = $request->input('map_details');
        $checkin       = $request->input('checkin');
        $checkout      = $request->input('checkout');
        $guest         = $request->input('guest');
        $bathrooms     = $request->input('bathrooms');
        $bedrooms      = $request->input('bedrooms');
        $beds          = $request->input('beds');
        $property_type = $request->input('property_type');
        $room_type     = $request->input('room_type');
        $amenities     = $request->input('amenities');
        $min_price     = $request->input('min_price');
        $max_price     = $request->input('max_price');
        $instant_book  = $request->input('instant_book');
        $property_id   = $request->input('property_id');
        $limit_distance     = $request->input('limit_distance');
        if(is_numeric ($full_address)){
            $roomId = $full_address;
            $rooms = Rooms::with(['rooms_address','rooms_price'
            ]);
                $rooms = $rooms->select('rooms.*',
                'rooms_address.*',
                'rooms.subscription_end_date as ends_at',
                'membershiptypes.Name as membership_name',
                DB::raw('avg(rating) as avg_rating, count(reviews.room_id) as review_count')
            );
            
            $rooms = $rooms->join('rooms_address', 'rooms.id', '=', 'rooms_address.room_id');
            $date = date('Y-m-d');
            $rooms = $rooms->leftJoin('reviews', 'reviews.room_id', '=', 'rooms.id');
            $rooms = $rooms->join('rooms_price', 'rooms.id', '=', 'rooms_price.room_id');
            $rooms = $rooms->leftJoin('membershiptypes', 'membershiptypes.id', '=', 'rooms.plan_type');
            $rooms->where( "rooms.id" , "=", "$roomId");
                return($rooms->paginate(10));
        }
        if(!is_array($room_type))
        {
            if($room_type != '')
             $room_type = explode(',', $room_type);
            else
             $room_type = [];
        }
        if(!is_array($property_type))
        {
            if($property_type != '')
             $property_type = explode(',', $property_type);
            else
             $property_type = [];
        }

        if(!is_array($amenities))
        {
            if($amenities != '')
             $amenities = explode(',', $amenities);
            else
             $amenities = [];
        }

        $property_type_val   = [];
        $room_type_val       = [];
        $rooms_whereIn       = [];
        if($request->searchOption == 'address'){
            if($full_address){
                $address      = str_replace([" ","%2C"], ["+",","], "$full_address");
                $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&address='.$address.'&sensor=false&libraries=places');
                $json         = json_decode($geocode);
            }
            else{
                $user_ip = $_SERVER['REMOTE_ADDR'];
                if($user_ip == '127.0.0.1'){
                    $externalContent = file_get_contents('http://checkip.dyndns.com/');
                    preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                    $user_ip = $m[1];
                }
                $url = json_decode(file_get_contents("http://ipinfo.io/$user_ip/?key=".env('IP_INFO_KEY')));
                $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&latlng='.$url->loc.'&sensor=false&libraries=places');
                $json         = json_decode($geocode);
            }

            if(@$json->{'results'})
            {
               
                $cLat  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $cLong = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                

                $minLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lat'};
                $maxLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lat'};
                $minLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lng'};
                $maxLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lng'};
                // dd($json->{'results'}[0]->{'address_components'});
                foreach($json->{'results'}[0]->{'address_components'} as $component){
                    if($component->{'types'}[0] == 'country'){
                        $searchCountry = $component->{'short_name'};
                        
                    }
                }
                //apply map tolerence
                $minLat -= $this->map_tolerence;
                $maxLat += $this->map_tolerence;
                $minLong -= $this->map_tolerence;
                $maxLong += $this->map_tolerence;
            }
            else
            {
                $cLat = 0;
                $cLong = 0;

                $minLat = -1000;
                $maxLat = 1000;
                $minLong = -1000;
                $maxLong = 1000;
            }
        }
        else{
            $cLat = $full_address['center']['lat'];
            $cLong =$full_address['center']['lng'];
    
            $minLat = isset($full_address['southWest']['lat']) ? $full_address['southWest']['lat'] : -1000;
            $maxLat = isset($full_address['northEast']['lat']) ? $full_address['northEast']['lat'] : 1000;
            $minLong = isset($full_address['southWest']['lng']) ? $full_address['southWest']['lng'] : -1000;
            $maxLong = isset($full_address['northEast']['lng']) ? $full_address['northEast']['lng'] : 1000;

        }
        $checkin  = date('Y-m-d', $this->helper->custom_strtotime($checkin));
        $checkout = date('Y-m-d', $this->helper->custom_strtotime($checkout));
        $dates_available = ($request->input('checkin') !='');
        $days     = $this->get_days($checkin, $checkout);
        unset($days[count($days)-1]);
        $total_nights = count($days);

        $total_weekends = 0;
        foreach($days as $day) {
            $weekday = date('N', strtotime($day));
            if( in_array($weekday, [5,6]) ) {
                $total_weekends++;
            }
        }
        $total_guests                       = $guest-0;

        $max_price_check = $this->payment_helper->currency_convert('', 'USD', $max_price);

        $not_available_room_ids = [];
        $not_available_room_ids = Calendar::daysNotAvailable($days, $total_guests);//->distinct()->pluck('room_id')->toArray();
        $not_available_room_ids = array_unique($not_available_room_ids);
        $rooms = Rooms::with(['rooms_price'])->select('rooms.*',
         'rooms_address.*',
         'rooms.subscription_end_date as ends_at',
         'membershiptypes.Name as membership_name',
         DB::raw("'$cLong' as key_longitude, '$cLat' as key_latitude"),
         DB::raw('avg(rating) as avg_rating, count(reviews.room_id) as review_count')
        );
        $rooms = $rooms->whereNotIn('rooms.id', $not_available_room_ids);
        $cenLat = ($minLat + $maxLat) / 2;
        $cenLong = ($minLong + $maxLong) / 2;
        $rooms = $rooms->join('rooms_address', 'rooms.id', '=', 'rooms_address.room_id');
        $date = date('Y-m-d');
        $rooms = $rooms->leftJoin('reviews', 'reviews.room_id', '=', 'rooms.id');
        $rooms = $rooms->join('rooms_price', 'rooms.id', '=', 'rooms_price.room_id');
        $rooms = $rooms->leftJoin('membershiptypes', 'membershiptypes.id', '=', 'rooms.plan_type');
        $rooms->whereRaw( "
        rooms.subscription_end_date >='$date' and 
        rooms.subscription_start_date <= '$date' and 
        rooms.subscription_start_date != '0000-00-00' and 
        rooms_address.latitude between $minLat and $maxLat and 
        rooms_address.longitude between $minLong and $maxLong and
        rooms.accommodates >= '$guest' and
        rooms_price.night >= '$min_price' and
        rooms_price.night <= '$max_price' 
        ");
        if(isset($searchCountry)){
            $rooms = $rooms->whereRaw("country = '$searchCountry'");
        }
        $property_type = array_values($property_type);
        if(count($property_type))
        {
            $rooms = $rooms->whereIn('rooms.property_type', $property_type);
        }
        if(count($amenities))
        {
            foreach($amenities as $amenities_value)
            {
                $rooms = $rooms->whereRaw('find_in_set('.$amenities_value.', rooms.amenities)');
            }
        }
        $rooms = $rooms->orderBy('plan_type');
        if(isset($request->page) && $request->page != 1){
            if ($request->session()->has('randomOrder')) {
                $randomOrder = session('randomOrder');
            $rooms = $rooms->inRandomOrder($randomOrder);
            }
            else{
                $randomOrder = mt_rand() ;
                session('randomOrder', $randomOrder);
                $rooms = $rooms->orderBy(DB::raw("RAND($randomOrder)"));
            }
        }
        else{
            $randomOrder = mt_rand() ;
            Session::put('randomOrder', $randomOrder);
            $rooms = $rooms->orderBy(DB::raw("RAND($randomOrder)"));
        }
        $rooms->groupBy('rooms.id');
        echo json_encode($rooms->paginate(50));
        ob_flush();
        exit;
        // return($rooms->paginate(50));
    }
 


	/**
	 * Get distance between two points
	 * @param $lat1
	 * @param $lon1
	 * @param $lat2
	 * @param $lon2
	 * @return float $distance      Between two points
	 */
    public function calcDistances($lat1, $lon1, $lat2, $lon2) {
         // ACOS(SIN(lat1)*SIN(lat2)+COS(lat1)*COS(lat2)*COS(lon2-lon1))*6371
         // Convert lattitude/longitude (degrees) to radians for calculations
         $R = 3963.189; // meters
         
         // Find the deltas
         $delta_lon = $this->deg2rad($lon2) - $this->deg2rad($lon1);
         
         // Find the Great Circle distance
         $distance = acos(sin($this->deg2rad($lat1)) * sin($this->deg2rad($lat2)) + cos($this->deg2rad($lat1)) * cos($this->deg2rad($lat2)) *
         cos($delta_lon)) * 3963.189;         
         
         return $distance;
    }

	/**
	 * @param $val
	 *
	 * @return float|int
	 */
	/**
	 * @param $val
	 *
	 * @return float|int
	 */
	/**
	 * @param $val
	 *
	 * @return float|int
	 */
	public function deg2rad($val) {
        $pi = pi();
        $de_ra = (floatval($val)*($pi/180));
        return $de_ra;
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
	 * Get rooms photo details
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return json $rooms_photo    Rooms Photos Details
	 */
    public function rooms_photos(Request $request)
    {            
        $rooms_id  = $request->rooms_id;
        $roomsDetails =  RoomsPhotos::where('room_id', $request->rooms_id)->orderBy('order','desc')->get();

        return json_encode($roomsDetails);
    }

	/**
	 * Get host experience photo details
	 *
	 * @param \Illuminate\Http\Request $request Input values
	 * @return json $host experience    host experience Details
	 */
    public function host_experience_photos(Request $request)
    {            
        $rooms_id  = $request->rooms_id;
        $roomsDetails =  HostExperiencePhotos::where('host_experience_id', $request->rooms_id)->get();
        return json_encode($roomsDetails);
    }

}