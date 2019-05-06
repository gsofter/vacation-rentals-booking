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
	 * Display a listing of the resource.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return Response
	 */
    public function old_index(Request $request)
    {
        if($request->locations == '')
            return redirect('/');
        
        $locations = HomeCities::clean($request->locations);
        $locations = str_replace('--','-',$locations).'?checkin='.$request->checkin.'&checkout='.$request->checkout.'&guests='.$request->guests.'&room_type='.$request->room_type;
        return redirect($locations);
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
            $data['checkin'] = '';
            $data['st_date'] = '';
        } 
        if(!empty($request->input('checkout_date_format'))){
            $data['end_date'] = date(env('PHP_DATE_FORMAT'), $this->helper->custom_strtotime($checkout_date_format, $php_date_format));
        } elseif(!empty($request->input('checkout')) && $this->helper->custom_strtotime($request->input('checkout'), $php_date_format)) {
            $data['end_date'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkout'), $php_date_format));
            //$data['checkout'] = $request->input('checkout'); Previously used method for reference
            $data['checkout'] = date(env('PHP_DATE_FORMAT'),$this->helper->custom_strtotime($request->input('checkout'), $php_date_format));
        } else {
            $data['end_date'] = '';
            $data['checkout'] = '';
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
    public function searchResult(Request $request){
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


        if($map_details == ''){
            if($full_address){
                $address      = str_replace([" ","%2C"], ["+",","], "$full_address");
                // dd(env('GOOGLE_MAP_API'));
                $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&address='.$address.'&sensor=false&libraries=places');
                $json         = json_decode($geocode);
            }
            else{
               // If user did not input Full Address, My code will check user's address and use it.
               //when this code work on server        
                $user_ip = $_SERVER['REMOTE_ADDR'];
                // when this code work on localhost
                $externalContent = file_get_contents('http://checkip.dyndns.com/');
                preg_match('/Current IP Address: \[?([:.0-9a-fA-F]+)\]?/', $externalContent, $m);
                $user_ip = $m[1];
                /// get My Location
                $url = json_decode(file_get_contents("http://ipinfo.io/$user_ip/?key=".env('IP_INFO_KEY')));
                list( $my_latitude, $my_longitude) = explode(",",$url->loc);
            }
        }



    }
    public function searchResult____1(Request $request) {
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
        
        // dd($full_address);
        $previous_currency = Session::get('previous_currency');

        $currency = 'USD';
        //todo-vr add option to allow admins and users to enable/disable currency conversion based on user's ip address
        // $currency = Session::get('currency');
        

        //todo-vr add option to allow admins and users to enable/disable currency conversion based on user's ip address
        // if(!$min_price)
        // {
        //     $min_price = $this->payment_helper->currency_convert('USD', '', 0);
        //     $max_price = $this->payment_helper->currency_convert('USD', '', 750);
        // }

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
        }
        else if (!is_numeric($full_address))
        {
            /**
             * Get geolocation from address.
             * This is used for ONLY map_details is blank.
             * It takes over 1s and it decrease site speed.
             * So, I moved this here.
             * @author leoruzin
             */
            $address      = str_replace([" ","%2C"], ["+",","], "$full_address");
            // dd(env('GOOGLE_MAP_API'));
            $geocode      = @file_get_contents('https://maps.google.com/maps/api/geocode/json?key='.env('GOOGLE_MAP_API').'&address='.$address.'&sensor=false&libraries=places');
            $json         = json_decode($geocode);
            /////////////////////////////
            // dd($json);
            if(@$json->{'results'})
            {
                $cLat  = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
                $cLong = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
                

                $minLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lat'};
                $maxLat = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lat'};
                $minLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'southwest'}->{'lng'};
                $maxLong = $json->{'results'}[0]->{'geometry'}->{'viewport'}->{'northeast'}->{'lng'};

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
        } else {
            $minLat = -1000;
            $maxLat = 1000;
            $minLong = -1000;
            $maxLong = 1000;
          
            //$full_address : number            
//            $rooms_addr = (new RoomsAddress())->where("room_id", "=", $full_address)
//                                ->get();
        }

        // dd($minLat, $maxLat, $minLong, $maxLong);


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
        $from                               = new \DateTime($checkin);
        $today                              = new \DateTime(date('Y-m-d'));
        $period                             = $from->diff($today)->format("%a")+1;
        $total_guests                       = $guest-0;
        $dates                              = implode(',', $days);
        $users_where['users.status']    = 'Active';
        $rooms_where['rooms.accommodates'] = $guest;
        $rooms_where['rooms.status']       = 'Listed';
        // dd($rooms_where);
        if($property_id)
           $rooms_where['rooms.id']  = $property_id;
        if($bathrooms)
            $rooms_where['rooms.bathrooms'] = $bathrooms;
        if($bedrooms)
            $rooms_where['rooms.bedrooms']  = $bedrooms;
        if($beds)
            $rooms_where['rooms.beds']      = $beds;
        if($instant_book == 1)
            $rooms_where['rooms.booking_type'] = 'instant_book';
        $property_type = array_values($property_type);
        if(count($property_type))
        {                    
            $rooms_whereIn['rooms.property_type'] = $property_type;
        }
        $room_type = array_values($room_type);
        if(count($room_type))
        {
            $rooms_whereIn['rooms.room_type'] = $room_type;
        }
        $currency_rate = 1;

        $max_price_check = $this->payment_helper->currency_convert('', 'USD', $max_price);

        $not_available_room_ids = [];


        // Availability Filters Start
        // dd(Calendar::daysNotAvailable($days, $total_guests));
        $not_available_room_ids = Calendar::daysNotAvailable($days, $total_guests);//->distinct()->pluck('room_id')->toArray();
        // dd($not_available_room_ids);
        $not_available_room_ids = array_unique($not_available_room_ids);
        // dd($not_available_room_ids);
        if($dates_available) 
        {
            // Create virtual Table for rooms availability rules with given dates
            $availability_rules_virtual_table   = DB::table('rooms_availability_rules')
                                                ->select('minimum_stay as rule_minimum_stay', 'maximum_stay as rule_maximum_stay', 'room_id', 'id as rule_id')
                                                ->whereRaw("start_date <= '".$checkin."'")
                                                ->whereRaw("end_date >= '".$checkin."'")
                                                ->orderBy('type','ASC')
                                                ->orderBy('rooms_availability_rules.id','DESC')
                                                ->limit(1)
                                                ->toSql();
            // Query to get the prioritized rule minimum stay
            $rule_minimum_stay_query            =  DB::table('rooms_availability_rules')
                                                ->select('minimum_stay')
                                                ->whereRaw("start_date <= '".$checkin."'")
                                                ->whereRaw("end_date >= '".$checkin."'")
                                                ->orderBy('type','ASC')
                                                ->orderBy('rooms_availability_rules.id','DESC')
                                                ->whereRaw('room_id = rooms.id')
                                                ->limit(1)
                                                ->toSql();
            // Query to get the prioritized rule maximum stay
            $rule_maximum_stay_query            =  DB::table('rooms_availability_rules')
                                                ->select('maximum_stay')
                                                ->whereRaw("start_date <= '".$checkin."'")
                                                ->whereRaw("end_date >= '".$checkin."'")
                                                ->orderBy('type','ASC')
                                                ->orderBy('rooms_availability_rules.id','DESC')
                                                ->whereRaw('room_id = rooms.id')
                                                ->limit(1)
                                                ->toSql();
            // Query to get the prioritized rule id
            $rule_id_query                      =  DB::table('rooms_availability_rules')
                                                ->select('id')
                                                ->whereRaw("start_date <= '".$checkin."'")
                                                ->whereRaw("end_date >= '".$checkin."'")
                                                ->orderBy('type','ASC')
                                                ->orderBy('rooms_availability_rules.id','DESC')
                                                ->whereRaw('room_id = rooms.id')
                                                ->limit(1)
                                                ->toSql();
            // select availability rules virttual table with rooms table and select minimum and maximum stay values
            $rooms_availability_rules           = DB::table('rooms')
                                                ->select('rooms.id', 'rooms_price.minimum_stay', 'rooms_price.maximum_stay')
                                                ->selectRaw("(".$rule_minimum_stay_query.") as rule_minimum_stay")
                                                ->selectRaw("(".$rule_maximum_stay_query.") as rule_maximum_stay")
                                                ->selectRaw("(".$rule_id_query.") as rule_id")
                                                ->selectRaw('( SELECT IF(rule_id >0,(IFNULL(rule_minimum_stay, null)),(IFNULL(minimum_stay, null))) ) as check_minimum_stay')
                                                ->selectRaw('( SELECT IF(rule_id >0,(IFNULL(rule_maximum_stay, null)),(IFNULL(maximum_stay, null))) ) as check_maximum_stay')
                                                // ->leftJoin(DB::raw("(".$availability_rules_virtual_table.") as availability_rule"), 
                                                //     function($join) {
                                                //         $join->on('rooms.id','=','availability_rule.room_id');
                                                //     })
                                                ->join('rooms_price', 'rooms_price.room_id' ,'=', 'rooms.id')
                                                ->whereNotIn('rooms.id', $not_available_room_ids);
            // Compare the minimum stay and maximum stay value with the total nights to get the unavailable room_ids
            $availability_rules_missed_rooms = [];
            $availability_rules_missed_rooms    = $rooms_availability_rules
                                                ->havingRaw('(check_minimum_stay IS NOT NULL and check_minimum_stay > '.$total_nights.')')
                                                ->orHavingRaw('(check_maximum_stay IS NOT NULL and check_maximum_stay < '.$total_nights.')')
                                                ->pluck('id');
            if(count($availability_rules_missed_rooms) <= 0)
                $availability_rules_missed_rooms = [];

            if(@$not_available_room_ids && @$availability_rules_missed_rooms){
               $not_available_room_ids = array_merge(@$not_available_room_ids, (array)@$availability_rules_missed_rooms);
            }elseif(@$not_available_room_ids && (!@$availability_rules_missed_rooms)){
                $not_available_room_ids = @$not_available_room_ids;
            }elseif(@$availability_rules_missed_rooms && (!@$not_available_room_ids)){
                $not_available_room_ids = @$availability_rules_missed_rooms;
            }

            
        }
        
        // Availability Filters End
        // Basic Filters Start
        // dd($not_available_room_ids);
        $rooms = Rooms::with(['rooms_address',
                    'users' => function($query) {
                        $query->with('profile_picture');
                    }]);
        
                    $rooms = $rooms->with('rooms_price');
        if(is_numeric($full_address))
        {
            $rooms = $rooms->where('id','=',$full_address);
        }
        else{            
            $rooms->whereHas('rooms_address', function($query) use($minLat, $maxLat, $minLong, $maxLong) {
                $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
            });
        }
        
        /**
         * Made one function for rooms query because this part is used two times.
         * @author leoruzin 20180614
         */
        $rooms = $this->getRoomQuery($rooms,
                            $full_address,
                            $minLat, $maxLat, $minLong, $maxLong,
                            $rooms_where,
                            $rooms_whereIn,
                            $amenities,
                            $not_available_room_ids,
                            $dates,
                            $period,
                            $total_nights,
                            $total_weekends,
                            $total_guests,
                            $currency_rate,
                            $max_price_check, 
                            $dates_available,
                            $min_price,
                            $max_price);
        $rooms = $rooms->orderBy('rooms.plan_type');
        // $users = DB::select($rooms->get());
      
        // dd(DB::selectRaw($rooms->toSql()));
       
        // $page = $request->get("page");
        $randSeed = 2;
        $divider = 307;
        // if ($map_details == '' && $page == 1) {
        //     $seed_array = array(2, 3, 5, 7, 11, 13, 17, 19, 23, 29);
        //     $rand = rand() % 10;
        //     $randSeed = $seed_array [$rand];
        //     session(['order_key' => $randSeed]);
        // } else
        //     $randSeed = Session::get('order_key');
        
        $rooms = $rooms->orderByRaw("(id * $randSeed) % $divider");
        // dd($rooms);
        // dd($rooms->paginate(10));
        $rooms = $rooms->paginate(10);
    //    $rooms->chunk();
        // foreach($rooms as $key => $room){
        //     $rooms[$key]['reviews'] = $room->reviews()->get();
            
        //     $rooms[$key]['overall_star_rating'] = $room->getOverallStarRatingAttribute();
        //     $rooms[$key]['accuracy_star_rating'] = $room->getAccuracyStarRatingAttribute();
        //     $rooms[$key]['location_star_rating'] = $room->getLocationStarRatingAttribute();
        //     $rooms[$key]['communication_star_rating'] = $room->getCommunicationStarRatingAttribute();
        //     $rooms[$key]['checkin_star_rating'] = $room->getCheckinStarRatingAttribute();
        //     $rooms[$key]['cleanliness_star_rating'] = $room->getCleanlinessStarRatingAttribute();
        //     $rooms[$key]['value_star_rating'] = $room->getValueStarRatingAttribute();
        // }
        
        // dd($rooms);
            
        if (count($rooms) == 0 && $map_details == "" && !is_numeric($full_address)) {
            /**
             * Get nearest room from center when map details is blank.
             * @author leoruzin 20180614
             */
            $rooms = Rooms::with(['rooms_address',
            'users' => function($query) {
                $query->with('profile_picture');
            }]);
            $rooms = $rooms->with('rooms_price');
            /*$rooms->whereHas('rooms_address', function($query) use($minLat, $maxLat, $minLong, $maxLong) {
                $query->whereRaw("latitude between $minLat and $maxLat and longitude between $minLong and $maxLong");
            });*/
            $rooms = $rooms->join('rooms_address', 'rooms.id', '=', 'rooms_address.room_id');
            
            
            $rooms = $this->getRoomQuery($rooms,
                                    $full_address,
                                    $minLat, $maxLat, $minLong, $maxLong,
                                    $rooms_where,
                                    $rooms_whereIn,
                                    $amenities,
                                    $not_available_room_ids,
                                    $dates,
                                    $period,
                                    $total_nights,
                                    $total_weekends,
                                    $total_guests,
                                    $currency_rate,
                                    $max_price_check, 
                                    $dates_available,
                                    $min_price,
                                    $max_price);

            $cenLat = ($minLat + $maxLat) / 2;
            $cenLong = ($minLong + $maxLong) / 2;
           
            /**
             * Distance is x^2 + y^2.
             * But here, I calculated nearest one as (abs(x) + abs(y)) because of speed.
             */
            $rooms = $rooms->orderByRaw("ABS(latitude - (".$cenLat.")) + ABS(longitude - (".$cenLong."))");

            $rooms = $rooms->orderBy('rooms.plan_type')->limit(3);
            // $rooms = $rooms->get();
            // foreach($rooms as $key => $room){
            //     $rooms[$key]['reviews'] = $room->reviews()->get();
                
            //     $rooms[$key]['overall_star_rating'] = $room->getOverallStarRatingAttribute();
            //     $rooms[$key]['accuracy_star_rating'] = $room->getAccuracyStarRatingAttribute();
            //     $rooms[$key]['location_star_rating'] = $room->getLocationStarRatingAttribute();
            //     $rooms[$key]['communication_star_rating'] = $room->getCommunicationStarRatingAttribute();
            //     $rooms[$key]['checkin_star_rating'] = $room->getCheckinStarRatingAttribute();
            //     $rooms[$key]['cleanliness_star_rating'] = $room->getCleanlinessStarRatingAttribute();
            //     $rooms[$key]['value_star_rating'] = $room->getValueStarRatingAttribute();
            // }
            // $rooms = $rooms->orderByRaw("(id * $randSeed) % $divider");
            // dd($rooms);
            // dd($rooms->paginate(10));
            $rooms = $rooms->paginate(10);
            $roomsArr = json_decode($rooms->toJson(), true);
            // $roomsArr ["nearestSearch"] = true;

            echo json_encode($roomsArr);
            return;
        }
        ////////////////////////////////////////////////////
        
        /*if(!is_numeric($full_address)) {
            if(count($rooms))
            {
                foreach($rooms as $key => $room)
                {                    
                    $curLat = $room->rooms_address->latitude;
                    $curLong = $room->rooms_address->longitude;
                    $dis = $this->calcDistances($curLat, $curLong, $cLat, $cLong);
                    if($dis > $limit_distance) 
                    {                      
                        $rooms = $rooms->forget($key);
                    }
                                          
                }                

            }        
        }*/

        if (is_numeric($full_address)) {
            $roomsArr = json_decode($rooms->toJson(), true);
            $roomsArr ["isNumericSearch"] = true;
            echo json_encode($roomsArr);
        } else
            echo $rooms->toJson();
    }

	/**
	 * Set search queries to room Model.
	 *
	 * @param $rooms
	 * @param $full_address
	 * @param $minLat
	 * @param $maxLat
	 * @param $minLong
	 * @param $maxLong
	 * @param $rooms_where
	 * @param $rooms_whereIn
	 * @param $amenities
	 * @param $not_available_room_ids
	 * @param $dates
	 * @param $period
	 * @param $total_nights
	 * @param $total_weekends
	 * @param $total_guests
	 * @param $currency_rate
	 * @param $max_price_check
	 * @param $dates_available
	 * @param $min_price
	 * @param $max_price
	 * @return model room
	 *
	 * @author leoruzin 20180614
	 */
    public function getRoomQuery(
            $rooms,
            $full_address,
            $minLat, $maxLat, $minLong, $maxLong,
            $rooms_where,
            $rooms_whereIn,
            $amenities,
            $not_available_room_ids,
            $dates,
            $period,
            $total_nights,
            $total_weekends,
            $total_guests,
            $currency_rate,
            $max_price_check, 
            $dates_available,
            $min_price,
            $max_price) {
                
               
        if($rooms_where)
        {            
            foreach($rooms_where as $row=>$value)
            {
                if($row == 'rooms.accommodates' || $row == 'rooms.bathrooms' || $row == 'rooms.bedrooms' || $row == 'rooms.beds')
                    $operator = '>=';
                else
                    $operator = '=';

                if($value == '')
                    $value = 0;
                
                $rooms = $rooms->where($row, $operator, $value);
            }
        }
       

        
        if($rooms_whereIn)
        {            
            foreach($rooms_whereIn as $row_rooms_whereIn => $value_rooms_whereIn)
            {
                $rooms = $rooms->whereIn($row_rooms_whereIn, array_values($value_rooms_whereIn));
            }
        }

        if(count($amenities))
        {
            foreach($amenities as $amenities_value)
            {
                $rooms = $rooms->whereRaw('find_in_set('.$amenities_value.', amenities)');
            }
        }
    
        $rooms->whereNotIn('id', $not_available_room_ids)->where('subscription_end_date','>=',date('Y-m-d'));
       return $rooms;        
// return $rooms;
        // Basic Filters End
        // Price Filter Start
        // Query to get sum of calendar price for rooms in a given dates
        $calendar_price_total_query         = DB::table("calendar")
                                            ->selectRaw('sum(price)')
                                            ->whereRaw('calendar.room_id = rooms.id')
                                            ->whereRaw('FIND_IN_SET(calendar.date, "'.$dates.'")')
                                            ->toSql();
        // Query to count the total calendar result for rooms as special nights
        $calendar_special_nights_query      = DB::table("calendar")
                                            ->selectRaw("count('*')")
                                            ->whereRaw('calendar.room_id = rooms.id')
                                            ->whereRaw('FIND_IN_SET(calendar.date, "'.$dates.'")')
                                            ->toSql();
        // Query to count the total weekend calendar result for rooms as special weekends
        $calendar_special_weekends_query    = DB::table("calendar")
                                            ->selectRaw("count('*')")
                                            ->whereRaw('calendar.room_id = rooms.id')
                                            ->whereRaw('FIND_IN_SET(calendar.date, "'.$dates.'")')
                                            ->whereRaw('( WEEKDAY(date) = 4 OR WEEKDAY(date) = 5 )')
                                            ->toSql();
        // Query to get rooms price rules minimum period for last min booking
        $min_price_rule_period_query        = DB::table('rooms_price_rules')
                                            ->selectRaw('min(period)')
                                            ->whereRaw('room_id = rooms.id')
                                            ->whereRaw('period>='.$period)
                                            ->whereRaw("type = 'last_min'")
                                            ->toSql();
        // Query to get rooms price rules maximum period for early bird booking
        $max_price_rule_period_query        = DB::table('rooms_price_rules')
                                            ->selectRaw('max(period)')
                                            ->whereRaw('room_id = rooms.id')
                                            ->whereRaw('period<='.$period)
                                            ->whereRaw("type = 'early_bird'")
                                            ->toSql();
        // Query to find the booking period discount based on the dates
        $booked_period_discount_query       = DB::table('rooms_price_rules')
                                            ->select('discount')
                                            ->whereRaw('room_id = rooms.id')
                                            ->where(function($query) use($period){
                                                $query->where(function($sub_query) use($period){
                                                    $sub_query->whereRaw('period >= '.$period)
                                                            ->whereRaw("type = 'last_min'")
                                                            ->whereRaw('period= min_price_rule_period');
                                                });
                                                $query->orWhere(function($sub_query) use($period){
                                                    $sub_query->whereRaw('period <= '.$period)
                                                            ->whereRaw("type = 'early_bird'")
                                                            ->whereRaw('period= max_price_rule_period');
                                                });
                                            })
                                            ->toSql();
                                                                      
        // Query to find the appropriate period for the length of stay based on total nights
        $length_of_stay_period_query        = DB::table('rooms_price_rules')
                                            ->selectRaw('max(period)')
                                            ->whereRaw('room_id = rooms.id')
                                            ->whereRaw('period<='.$total_nights)
                                            ->whereRaw("type = 'length_of_stay'")
                                            ->toSql();
        // Query to get the length of stay discount from price rules based on total nights
        $length_of_stay_discount_query      = DB::table('rooms_price_rules')
                                            ->select('discount')
                                            ->whereRaw('room_id = rooms.id')
                                            ->whereRaw('period<='.$total_nights)
                                            ->whereRaw("type = 'length_of_stay'")
                                            ->whereRaw("period = length_of_stay_period")
                                            ->toSql();
                                                                               
        // Create a rooms price details virtual table with all the possible prices applied
        $rooms_price_details_virtual_table  = DB::table('rooms')
                                            ->select('rooms.id as room_id')
                                            ->selectRaw("(".$calendar_price_total_query.") as calendar_total")
                                            ->selectRaw("(".$calendar_special_nights_query.") as special_nights")
                                            ->selectRaw("(".$calendar_special_weekends_query.") as special_weekends")

                                            ->selectRaw("(SELECT ".$total_weekends."-special_weekends) as normal_weekends")
                                            ->selectRaw("(SELECT ".$total_nights."-special_nights-normal_weekends) as normal_nights")
                                            ->selectRaw("(SELECT (rooms_price.night * normal_nights) + ( IF (rooms_price.weekend >0 , rooms_price.weekend , rooms_price.night) * normal_weekends)) as price_total")

                                            ->selectRaw("(SELECT IFNULL(price_total, 0)+ IFNULL(calendar_total, 0)) as base_total")
                                            
                                            ->selectRaw("(".$min_price_rule_period_query.") as min_price_rule_period")
                                            ->selectRaw("(".$max_price_rule_period_query.") as max_price_rule_period")
                                            ->selectRaw("(".$booked_period_discount_query.") as booked_period_discount")
                                            
                                            ->selectRaw("(".$length_of_stay_period_query.") as length_of_stay_period")
                                            ->selectRaw("(".$length_of_stay_discount_query.") as length_of_stay_discount")

                                            ->selectRaw("(SELECT Round(base_total*(booked_period_discount/100)) ) as booked_period_discount_price")
                                            ->selectRaw("(SELECT ROUND(base_total-IFNULL(booked_period_discount_price, 0))) as booked_period_base_total")

                                            ->selectRaw("(SELECT Round(booked_period_base_total*(length_of_stay_discount/100)) ) as length_of_stay_discount_price")
                                            ->selectRaw("(SELECT ROUND(booked_period_base_total - IFNULL(length_of_stay_discount_price, 0))) as discounted_base_total")
                                            
                                            ->selectRaw("(SELECT case when (".$total_guests."-rooms_price.guests) > 0 THEN (".$total_guests."-rooms_price.guests) else 0 end ) as extra_guests")

                                            ->selectRaw("(SELECT ROUND(IFNULL(discounted_base_total, 0) + rooms_price.cleaning + rooms_price.security + (extra_guests * rooms_price.additional_guest) ) ) as total")
                                            ->selectRaw("(SELECT ROUND(total/".$total_nights.")) as avg_price")
                                            ->selectRaw("(SELECT ROUND(total/".$total_nights.")) as night")
                                            ->selectRaw("( SELECT ROUND(((avg_price / currency.rate) * ".$currency_rate."))) as session_night")

                                            ->join('calendar','calendar.room_id','=','rooms.id', 'LEFT OUTER')
                                            ->join('rooms_price','rooms_price.room_id','=','rooms.id', 'LEFT')
                                            ->leftJoin('currency', 'currency.code','=', 'rooms_price.currency_code')
                                            ->groupBy('rooms.id')
                                            ->toSql();
                                            
        // Join the rooms price details virtual table with the rooms price
        $rooms          = $rooms->with([
                            'rooms_price' => function($query) use($rooms_price_details_virtual_table, $currency_rate, $min_price, $max_price, $max_price_check, $dates_available) {
                                $query->select('*');
                                if($dates_available) 
                                {
                                    $query->leftJoin(DB::raw("(".$rooms_price_details_virtual_table.") as rooms_price_details"), function($join) {
                                        $join->on('rooms_price.room_id','=','rooms_price_details.room_id');
                                    });
                                }

                                $query->with('currency');
                            } 
                        ]);
                        
        // $rooms          = $rooms->join('rooms_price', 'rooms_price.room_id', '=', 'rooms.id');


        if($dates_available) 
        {            
            $rooms      = $rooms->leftJoin(DB::raw("(".$rooms_price_details_virtual_table.") as rooms_price_details"), function($join) {
                $join->on('rooms.id','=','rooms_price_details.room_id');
            });
            // Compare the session night price with the given min price and max price
            // if($max_price_check >= 5000)
            // {
            //     $rooms->havingRaw('session_night >= '.$min_price);
            // }
            // else
            // {
            //     $rooms->havingRaw('session_night >= '.$min_price.' and session_night <= '.$max_price);
            // }
        }
        else 
        {            
            $rooms->whereHas('rooms_price', function($query)use( $currency_rate, $min_price, $max_price, $max_price_check){
                $query->join('currency', 'currency.code', '=', 'rooms_price.currency_code');
                if($max_price_check >= 5000)
                {   
                    $query->whereRaw('ROUND(((night / currency.rate) * '.$currency_rate.')) >= '.$min_price);
                }
                else
                {                    
                    $query->whereRaw('ROUND(((night / currency.rate) * '.$currency_rate.')) >= '.$min_price.' and ROUND(((night / currency.rate) * '.$currency_rate.')) <= '.$max_price);
                }
            });
        }
        
        return $rooms;
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