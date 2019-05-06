<?php
namespace App\Http\Controllers\Front;
use App\Models\Front\PaymentGateway;
use App\Models\Front\SubscribeList;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Front\PropertyType;
use App\Models\Front\PropertyTypeLang;
use App\Models\Front\Language;
use App\Models\Front\RoomType;
use App\Models\Front\RoomsBed;
use App\Models\Front\RoomsBath;
use App\Models\Front\Rooms;
use App\Models\Front\RoomsAddress;
use App\Models\Front\BedType;
use App\Models\Front\RoomsStepsStatus;
use App\Models\Front\Country;
use App\Models\Front\Amenities;
use App\Models\Front\AmenitiesType;
use App\Models\Front\RoomsPhotos;
use App\Models\Front\RoomsPrice;
use App\Models\Front\RoomsDescription;
use App\Models\Front\RoomsDescriptionLang;
use App\Models\Front\Calendar;
use App\Models\Front\SeasonalPrice;
use App\Models\Front\Currency;
use App\Models\Front\Reservation;
use App\Models\Front\SavedWishlists;
use App\Models\Front\Messages;
use App\Models\Front\SiteSettings;
use App\Models\Front\RoomsPriceRules;
use App\Models\Front\RoomsAvailabilityRules;
use App\Models\Front\ImportedIcal;
use App\Http\Helper\PaymentHelper;
use App\Http\Start\Helpers;
use App\Models\Front\User;
use App\Models\Front\Subscription;
use App\Models\Front\Subscriptions;
use App\Models\Front\Membershiptype;
use App\Models\Front\RoomsApprovedStatus;
use App\Models\Front\Metas;
use App\Models\Front\UsersPhoneNumbers;
use Illuminate\Routing\Route;
use Illuminate\Validation\Rule;
use App\Events\ProcessPhotos;
use App\Http\Helper\StripeHelper;
use App\Mail\ReservationEmailNotification;
use Event;
use Log;
use Auth;
use DB;
use Mail;
use DateTime;
use Session;
use Image;
use Validator;
use App\Rules\NoneBedSelected;
use Carbon\Carbon;
use App\Traits\MetaHelpers;
use Cloudder;
use Twilio;
class RoomsController extends Controller
{
	use MetaHelpers;
	protected $payment_helper;
	protected $stripe_helper;
	protected $helper;

	public function __construct(PaymentHelper $payment, StripeHelper $stripeHelper){
		$this->payment_helper = $payment;
		$this->stripe_helper = $stripeHelper;
		$this->helper = new Helpers;
	}
	public function roombooking(Request $request){
		$user_id = Rooms::find($request->room_id)->user_id;
		if($user_id == $request->request_user_id){
			return array (
				'status' => 'error',
				'message' => 'Sorry, This is your listing.'
			);
		}
		$price_list = json_decode($this->payment_helper->price_calculation($request->room_id, $request->checkin, $request->checkout, $request->guest_count, $request->guest_options,$request->special_offer_id));
		if(@$price_list->status == 'Not available'){
			return array (
				'status' => 'error',
				'message' => trans('messages.rooms.dates_not_available')
			);
		}

			$room_id            =  $request->room_id;
			$payment_checkin    =  $request->checkin;
			$payment_checkout   =  $request->checkout;
			$number_of_guests   =  $request->guest_count;
			$cancellation       =  $request->payment_cancellation;
			$rooms = Rooms::find($room_id);
			$reservation = new Reservation;
			$reservation->room_id          = $room_id;
			$reservation->host_id          = Rooms::find($room_id)->user_id;
			$reservation->user_id          = $request->request_user_id;
			$reservation->checkin          = date('Y-m-d', strtotime($payment_checkin));
			$reservation->checkout         = date('Y-m-d', strtotime($payment_checkout));
			$reservation->number_of_guests = $number_of_guests;
			$reservation->nights           =$price_list->total_nights;
			$reservation->per_night        =$price_list->per_night;
			$reservation->subtotal         =$price_list->subtotal;
			$reservation->cleaning         =$price_list->cleaning_fee;
			$reservation->additional_guest =$price_list->additional_guest;
			$reservation->security         =$price_list->security_fee;


			$reservation->total_taxes_pay  = $price_list->total_taxes_price;
			$reservation->tax_rate  = $price_list->taxes_pay;
			$reservation->additional_charge  = json_encode($price_list->additional);
			$reservation->total_additional_charge  = $price_list->total_additional_charge;
			$reservation->cleaning_fee_type  = $price_list->cleaning_fee_type;
			$reservation->total            = $price_list->total_price;
			$reservation->currency_code    = $price_list->currency;
			$reservation->type             = 'reservation';
			$reservation->status           = 'Pending';
			$reservation->cancellation     = 'Moderate';
			$reservation->country          = 'US';//'US'; mobile change
			$reservation->paymode          = 'Credit Card';//mobile change

			$reservation->base_per_night                = $price_list->base_rooms_price;
			$reservation->length_of_stay_type           = $price_list->length_of_stay_type;
			$reservation->length_of_stay_discount       = $price_list->length_of_stay_discount;
			$reservation->length_of_stay_discount_price = $price_list->length_of_stay_discount_price;
			$reservation->booked_period_type            = $price_list->booked_period_type;
			$reservation->booked_period_discount        = $price_list->booked_period_discount;
			$reservation->booked_period_discount_price  = $price_list->booked_period_discount_price;

			$reservation->save();

			
			$host_user = User::find($user_id);
			$question =  'Hello '.$host_user->full_name.'! You have a new reservation request.  To view, visit Vacation.rentals';
			$message = new Messages;

			$message->room_id        = $room_id;
			$message->reservation_id = $reservation->id;
			$message->user_to        = $rooms->user_id;
			$message->user_from      = $request->request_user_id;
			$message->message        = $question;
			$message->message_type   = 1;
			$message->read           = 0;

			$message->save();
			Mail::to($host_user->email)->send(new ReservationEmailNotification($reservation, $message));
			$phone_numbers = $host_user->users_phone_numbers;
			foreach($phone_numbers as $phone_number) {
				if($phone_number->status == "Confirmed") {
					$message = 'Hello '.$host_user->full_name."! You have a new reservation request.  To view, visit Vacation.rentals";
					// $message_response = $user_controller->send_twilio_message($phone_number->phone_number_nexmo, $message);
					Twilio::message($phone_number->phone_number, $message);
				}
			}
			return array(
				'status' => 'success',
				'message' => trans('Your booking request was successfully sent to the owner. Please allow 24 hours for them to reply!')
			);
	 
 
	}
	public function index()
	{

	
		$data['rooms_list'] = Rooms::user()->get();
		 
		$data['current_date'] = date('Y-m-d');
		Rooms::user()->where('started', 'Yes')->update(['started' => 'No']);
        return array(
            'status' => 'success',
            'page_data' => $data
        );
    }
    public function changestatus(Request $request){
        $room = Rooms::find($request->room_id);
        $room->status = $request->status;
        $room->save();
        return array(
            'status' => 'success',
            'message' => 'Saved Successfully'
        );
    }
	public function new_room()
	{
		$data['property_type'] = PropertyType::active_all();
		$data['room_type']     = RoomType::active_all();
		$data['plan_type']     = Subscription::active_all();
		return $data;
	}

	public function updateSlug($room_id, $slug = null) {
		$room = Rooms::find($room_id);
		$room->slug = $slug;
		$room->save();
	}

	public function create(Request $request)
	{
		
		$rooms = new Rooms;
		$property_type = PropertyType::find($request->active_home_type)->name;
	 
		$URL = "https://maps.googleapis.com/maps/api/geocode/json?latlng=$request->latitude,$request->longitude&key=AIzaSyA34nBk3rPJKXaNQaSX4YiLFoabX3DhkXs";
            $data = file_get_contents($URL);
			$geoAry = json_decode($data,true);
			$street = ''; $city_addr = ''; $state_addr = '';$country_addr=''; $route_addr =''; $postal_code =''; $country_code = '';
			foreach($geoAry['results'][0]['address_components'] as $result){
				if(in_array('street_number', $result['types'])){
					$street = $result['long_name'];
				}
				if(in_array('administrative_area_level_2', $result['types'])){
					$city_addr = $result['long_name'];
				}
				if(in_array('administrative_area_level_1', $result['types'])){
					$state_addr = $result['long_name'];
				}
				if(in_array('country', $result['types'])){
					$country_code = $result['short_name'];
					$country_addr = $result['long_name'];
				}
				if(in_array('route', $result['types'])){
					$route_addr = $result['long_name'];
				}
				if(in_array('postal_code', $result['types'])){
					$postal_code = $result['long_name'];
				}
			}
		$rooms->user_id       = Auth::user()->id;
		$rooms->name          = $property_type .' in '.$city_addr . ' ' . $state_addr; // Assign temporary name
		$rooms->sub_name      = $property_type .' in '.$city_addr;
		$rooms->property_type = $request->active_home_type;
		$rooms->room_type     = 1;//Set default room type to 1
		$rooms->accommodates  = $request->active_accommodates;
		$rooms->calendar_type = 'Always';
		$rooms->plan_type = 5;     // set to "No Subscription" which means that plan is undecided yet.
		$rooms->booking_type = "request_to_book";
		$rooms->save(); // Store data to rooms Table
		$rooms_address = new RoomsAddress;
		$rooms_address->room_id        = $rooms->id;
		$rooms_address->address_line_1 = $street ? $street.', ' : '';
		$rooms_address->address_line_1.= $route_addr;
		$rooms_address->city           = $city_addr;
		$rooms_address->state          = $state_addr;
		$rooms_address->country        = $country_code;
		$rooms_address->postal_code    = $postal_code;
		$rooms_address->latitude       = $request->latitude;
		$rooms_address->longitude      = $request->longitude;

		$rooms_address->save(); // Store data to rooms_address Table

		$this->updateSlug($rooms->id);

		$rooms_price = new RoomsPrice;

		$rooms_price->room_id       = $rooms->id;
		$rooms_price->currency_code = Session::get('currency') ? Session::get('currency') : 'USD';

		$rooms_price->save();   // Store data to rooms_price table

		$rooms_status = new RoomsStepsStatus;
		$rooms_status->calendar = 1;
		$rooms_status->room_id = $rooms->id;
		$rooms_status->save();  // Store data to rooms_steps_status table
		$rooms_approved_status = new RoomsApprovedStatus;
		$rooms_approved_status->room_id = $rooms->id;
		$rooms_approved_status->save();
		$rooms_description = new RoomsDescription;
		$rooms_description->room_id = $rooms->id;
		$rooms_description->save(); // Store data to rooms_description table
		return array(
			'status' => 'success',
			'room_id' => $rooms->id,
			'redirect_url' => 'manage-listing/'.$rooms->id.'/basics'
		);
	}
	public function get_additional_charges(Request $request){
		$data['result']         = Rooms::check_user($request->id);
		$data['rooms_price'] = $data['result']->rooms_price;
		$additional_charge = $data['result']->rooms_price->additional_charge;
		return $additional_charge;
	}
	public function get_last_min_rules(Request $request){
		$data['result']         = Rooms::check_user($request->id);
		$data['last_min_rules'] = $data['result']->last_min_rules;
		return $data['last_min_rules'];
	}
	public function get_location($id){
		$room = Rooms::check_user($id);
		$rooms_status   = RoomsStepsStatus::where('room_id',$id)->first();
		$location = $rooms_status->location;
		$rooms_address = $room->rooms_address;
		if(!$rooms_address){
			$rooms_address = new RoomsAddress;
			$rooms_address->country = 'us';
			$rooms_address->room_id = $id;
			$rooms_address->save();
		}
		$countries = Country::all();
		return array(
			'location' => $location,
			'address' => $rooms_address,
			'countries' => $countries
		);

	}
	public function get_amenities($id){
		$amenities      = Amenities::active_all();
		$amenities_type = AmenitiesType::active_all();
		$room =  Rooms::check_user($id);
		$prev_amenities = $room->amenities ?  explode(',',$room->amenities) : [];
		return array(
			'amenities' => $amenities, 
			'amenities_type' => $amenities_type,
			'prev_amenities' => $prev_amenities
		);
	}
	public function get_videoUrl($id){
		$room =  Rooms::check_user($id);
		return array(
			'url' => $room->video
		);
	}
	public function get_cancel_message($id){
		$room =  Rooms::check_user($id);
		return array(
			'cancel_message' => $room->cancel_message
		);
	}
	
	public function manage_listing(Request $request, CalendarController $calendar)
	{
		$data['property_type']  = PropertyType::dropdown();
		$data['room_type']      = RoomType::dropdown();
		$data['room_types']     = RoomType::where('status','Active')->limit(3)->get();
		$data['bed_type']       = BedType::active_all();
		$data['amenities']      = Amenities::active_all();
		$data['amenities_type'] = AmenitiesType::active_all();
		$data['plans_type']     = Subscription::active_all()->where('id', '!=', "5");     // 5 is correspoding to "No Subscription"
		$data['room_type_is_shared']    = RoomType::where('status','Active')->pluck('is_shared', 'id');
		$data['room_id']        = $request->id;
		$data['room_step']      = $request->page;    // It will get correct view file based on page name
		
		$data['result']         = Rooms::check_user($request->id); // Check Room Id and User Id is correct or not
		
		$data['rooms_price'] = $data['result']->rooms_price;
		$data['rooms_price']['additional_charge'] = $data['result']->rooms_price ? $data['result']->rooms_price->additional_charge : '';
		$data['currencies'] 	= Currency::all();
		$data['rooms_status']   = RoomsStepsStatus::where('room_id',$request->id)->first();
		
		// return $data;
		$data['imported_ical']  = ImportedIcal::where('room_id',$request->id)->get();

		$data['prev_amenities'] = explode(',', $data['result']->amenities);

		$data['length_of_stay_options'] = Rooms::getLenghtOfStayOptions();
		$data['availability_rules_months_options'] = Rooms::getAvailabilityRulesMonthsOptions();
		Session::forget('ajax_redirect_url');

		// $data['seasonal_price_detail'] = SeasonalPrice::where([['room_id',$request->id]])->groupBy('seasonal_name')->get();

		$data['not_available_days'] = Calendar::where([['room_id',$request->id], ['status', '=', 'Not available']])->groupBy('seasonal_name')->get();
		$data['bathrooms']=RoomsBath::where('room_id',$request->id)->get();
		$data['bedrooms']=RoomsBed::where('room_id',$request->id)->get();
		return $data;
		return view('list_your_space.main', $data);
	}
	public function ajax_manage_listing(Request $request, CalendarController $calendar)
	{
		$data['property_type']  = PropertyType::dropdown();
		$data['room_type']      = RoomType::dropdown();
		$data['room_types']     = RoomType::where('status','Active')->limit(3)->get();
		$data['bed_type']       = BedType::active_all();
		$data['amenities']      = Amenities::active_all();
		$data['amenities_type'] = AmenitiesType::active_all();

		$data['plans_type']     = Subscription::active_all()->where('id', '!=', "5");     // 5 is correspoding to "No Subscription"

		$data['room_type_is_shared']    = RoomType::where('status','Active')->pluck('is_shared', 'id');

		$data['room_id']        = $request->id;
		$data['room_step']      = $request->page;

		$data['result']         = Rooms::check_user($request->id); // Check Room Id and User Id is correct or not

		if(@$data['result'] == NULL)
		{
			return json_encode(['success_303'=>'false', 'status' => '300']); exit;
		}
		$data['success_303'] = 'true';
		$data['prev_amenities'] = explode(',', $data['result']->amenities);

		$data['rooms_status']   = RoomsStepsStatus::where('room_id',$request->id)->first();

		if($request->page == 'calendar')
		{
			$data_calendar     = @json_decode($request['data']);
			$year              = @$data_calendar->year;
			$month             = @$data_calendar->month;
			$data['room_step'] = 'edit_calendar';
			$data['calendar']  = $calendar->generate($request->id, $year, $month);
			$data['imported_ical']  = ImportedIcal::where('room_id',$request->id)->get();
		}

		$data['length_of_stay_options'] = Rooms::getLenghtOfStayOptions();
		$data['availability_rules_months_options'] = Rooms::getAvailabilityRulesMonthsOptions();
		$data['seasonal_price_detail'] = SeasonalPrice::where([['room_id',$request->id]])->groupBy('seasonal_name')->get();
		$data['not_available_days'] = Calendar::where([['room_id',$request->id], ['status', '=', 'Not available']])->groupBy('seasonal_name')->get();
		$data['bathrooms']=RoomsBath::where('room_id',$request->id)->get();
		$data['bedrooms']=RoomsBed::where('room_id',$request->id)->get();
		return view('list_your_space.'.$data['room_step'], $data);
	}
	public function ajax_header(Request $request)
	{
		$data['room_id']   = $request->id;
		$data['room_step'] = $request->page;

		$data['result']    = Rooms::check_user($request->id); // Check Room Id and User Id is correct or not

		return view('list_your_space.header', $data);
	}
	public function update_rooms(Request $request )
	{

		$data  = $request;
		$data  = json_decode($data['data']); // AngularJS data decoding


		if($request->current_tab)
		{

			if($request->current_tab == 'en')
			{
				$rooms = Rooms::find($request->id); // Where condition for Update
			}
			else
			{

				$des_id = RoomsDescriptionLang::where('room_id', $request->id)->where('lang_code', $request->current_tab)->first()->id;

				$rooms = RoomsDescriptionLang::find($des_id);

			}

		}
		else
		{
			$rooms = Rooms::find($request->id);
		}

		$email = '';
		
		foreach($data as $key=>$value)
		{
			if($key != 'video')
				$rooms->$key =$this->helper->url_remove($value);     // Dynamic Update
			else {
				$search     = '#(.*?)(?:href="https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch?.*?v=))([\w\-]{10,12}).*#x';
				$count      = preg_match($search, $value);
				$rooms      = Rooms::find($request->id);
				if($count == 1) {
					$replace    = 'https://www.youtube.com/embed/$2';
					$video      = preg_replace($search,$replace,$value);
					$rooms->$key = $video;
				}
				else {
					return json_encode(['success'=>'false', 'steps_count' => $rooms->steps_count]);
				}
			}

			if($key == 'booking_type')
				$rooms->$key = (!empty($value)) ? $value : NULL;

			if($key == 'room_type')
				$rooms->sub_name = RoomType::single_field($value, 'name').' in '.RoomsAddress::single_field($request->id, 'city');

			if($key == 'status' && $value == 'Listed'){
				$email = 'Listed';

			}

			if($key == 'status' && $value == 'Unlisted'){
				$email = 'Unlisted';
				$rooms->recommended='No';
			}

		}

		$rooms->save(); // Save rooms data to rooms table


		if($email == 'Listed' && $rooms->approved_status != "1") {
		}

		if(($email =='Unlisted') && $rooms->approved_status != "1") {
		} else{
			$this->update_status($request->id); // This function for update steps count in rooms_steps_count table
		}
		$address_url = url($rooms->address_url.'/'.$rooms->id);


		return json_encode(['success'=>'true', 'steps_count' => $rooms->steps_count, 'video' => $rooms->video, 'address_url' => $address_url, 'room_id' => $request->id]);
	}
	public function update_free_plan($id)
	{
		$rooms = Rooms::find($id);
		$plan = Subscription::find(4);
		$check_already_subscribe = SubscribeList::where('room_id',$id)->first();

		if(count($check_already_subscribe)){
			$subscription  = SubscribeList::find($check_already_subscribe->id);
		}else{
			$subscription  = new SubscribeList;
		}
		$current_date = date('Y-m-d');
		$subscription->room_id = $id;
		$subscription->host_id = $rooms->user_id;
		$subscription->amount= 0;
		$subscription->subscription_days = $plan->days;
		$subscription->subscription_start_date = date('Y-m-d');
		$subscription->subscription_end_date = date('Y-m-d', strtotime($current_date. ' + '.$plan->days.' day'));
		$subscription->currency_code = $rooms->currency_code ? $rooms->currency_code : Session::get('currency');
		$subscription->stripe_customer_id =  '';
		$subscription->status = 'Free';
		$subscription->save();


		$rooms->subscription_days = $plan->days;
		$rooms->subscription_start_date = date('Y-m-d');
		$rooms->subscription_end_date = date('Y-m-d', strtotime($current_date. ' + '.$plan->days.' day'));
		if($rooms->steps_count == '0' && $rooms->approved_status != "1"){
			$rooms->save();
		}
		return true;
	}
	public function update_status($id)
	{
		// echo $id;exit;
		$result_rooms = Rooms::whereId($id)->first();

		$rooms_status = RoomsStepsStatus::find($id);
	 
		if(!$rooms_status){
			$rooms_status = new RoomsStepsStatus;
			$rooms_status->room_id = $id;
			// 
		}
		$bedrooms= RoomsBed::where('room_id', $id)->get()->count();
		$bathrooms= RoomsBath::where('room_id', $id)->get()->count();
		if(@$result_rooms->name != '' && @$result_rooms->summary != '' )
		{
			// var_dump($rooms_status);exit;
			$rooms_status->description = 1;
		}
		else
		{
			$rooms_status->description = 0;
		}

		if($bedrooms > 0)
		{
			$rooms_status->basics = 1;
		}
		else
		{
			$rooms_status->basics = 0;
		}
		$photos_count = RoomsPhotos::where('room_id', $id)->count();

		if($photos_count > 0)
		{
			$rooms_status->photos = 1;
		}
		else
		{
			$rooms_status->photos = 0;
		}

		$price = RoomsPrice::find($id);

		if($price != NULL)
		{
			if($price->night != 0)
			{
				$rooms_status->pricing = 1;
			}
			else
			{
				$rooms_status->pricing = 0;
			}
		}

		if($result_rooms->calendar_type != NULL)
		{
			$rooms_status->calendar = 1;
		}

		if($result_rooms->cancel_message != NULL)
		{
			$rooms_status->terms = 1;
		}
		else
		{
			$rooms_status->terms = 0;
		}

		if($result_rooms->plan_type == 5)       // check if plan type is "No Subscription"
		{
			$rooms_status->plans = 1;
		}
		else
		{
			$rooms_status->plans = 1;
		}

		$rooms_status->save(); // Update Rooms Steps Count

		return true;
	}
	public function enter_address(Request $request)
	{
		$data_result['room_id']   = $request->id;
		$data_result['room_step'] = $request->page;
		$data_result['country']   = Country::all()->pluck('long_name','short_name');

		$data  = $request;

		$data  = json_decode($data['data']); // AngularJS data decoding

		$data->country_name = Country::where('short_name', $data->country)->first()->long_name;

		$data_result['result'] = $data;

		return view('list_your_space.enter_address', $data_result);
	}
	public function add_bedroom(Request $request)
	{
		$data_result['room_id']   = $request->id;
		$data_result['id']=$request->data['bed_id'];
		$data_result['room_step'] = $request->page;
		if($data_result['id']){
			$data_result['bed']=Roomsbed::where('id', $data_result['id'])->first();
		}else{
			$data_result['bed']=array('bedroom_name'=>'Bedroom 1');
		}
		return view('list_your_space.add_bedroom',$data_result);
	}
	public function deletebedroom(Request $request){
		$res=Roomsbed::where('id', $request->bedid)->delete();
		$this->update_room_bedrooms($request->room_id);
		$bedrooms=RoomsBed::where('room_id',$request->room_id)->get();
		if($res){
			return response()->json(array("message"=>"Deleted.", 'status' => 'success', 'bedrooms' => $bedrooms));
		}
		return response()->json(array("message"=>"Faild."));
	}
	public function deletebathroom(Request $request){
		$res=Roomsbath::where('id', $request->bathid)->delete();
		$this->update_room_bathrooms($request->room_id);
		$bathrooms=RoomsBath::where('room_id',$request->room_id)->get();
		if($res){
			return response()->json(array("message"=>"Deleted.",'status' => 'success', 'bathrooms' => $bathrooms));
		}
		return response()->json(array("message"=>"Faild."));
	}
	public function addupdatebathroom(Request $request){
	 
	 
		$rules    = [
			'bathroom_name'   => 'required',
			'bathroom_type'   => 'required|in:Full,Half,Shower',
			// 	function($attribute, $value, $fail) {
			// 			return $fail('invalid');
			// 	}
			'bathfeature'     => 'array|min:1'
		];

		$attributes = [
			'bathroom_name'   => 'Bathroom Name',
			'bathroom_type'   => 'Bathroom Type',
			'bathfeature'     => 'Bathroom Feature'
		];

		$validator = Validator::make($request->all(), $rules, [], $attributes);
		if($validator->fails()) {
			$errors = @$validator->errors()->getMessages();
			return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
		}

		$bath=new RoomsBath;
		if($request->id){
			$bath=RoomsBath::find($request->id);
		}
		$bath->room_id=$request->room_id;
		$bath->bathroom_name=$request->bathroom_name;
		$bath->bathroom_type=$request->bathroom_type;
		
		$bath->bathfeature=implode(',',$request->bathfeature);
		$res=$bath->saveOrFail();
		$this->update_room_bathrooms($request->room_id);

		if($res){
			return response()->json(array("message"=>"Add Successfully.", 'status' => 'success', 'result' => $bath));
		}else{
			return response()->json(array("message"=>"Add Faild."));
		}
	}
	public function addupdatebedroom(Request $request){
		$params = ['nooqueen','noofdouble','twinsingle','bunkbed','nochildbed','nosleepsofa','murphy','babycrib'];
		$rules    = [
			'bedroom_name' => 'required',
			'noof_king'    => ['integer', new NoneBedSelected($params)],
			'nooqueen' 		 => 'integer',
			'noofdouble' 	 => 'integer',
			'twinsingle'   => 'integer',
			'bunkbed'    	 => 'integer',
			'nochildbed' 	 => 'integer',
			'nosleepsofa'  => 'integer',
			'murphy'		   => 'integer',
			'babycrib'		 => 'integer',
		];

		$attributes = [
			'bedroom_name'  => 'Bedroom Name',
			'noof_king'     => 'King',
			'nooqueen'      => 'Queen',
			'noofdouble'    => 'Double',
			'twinsingle'    => 'Twin / Single',
			'bunkbed'       => 'Bunk bed',
			'nochildbed'    => 'Clild bed',
			'nosleepsofa'   => 'Sleep sofa / futon',
			'murphy'        => 'Murphy bed',
			'babycrib'      => 'Baby crib'
		];

		$validator = Validator::make($request->all(), $rules, [], $attributes);
		if($validator->fails()) {
			$errors = @$validator->errors()->getMessages();
			return json_encode(['success' => 'false', 'validator' => 'fail', 'errors' => $errors]);
		}

		$bed=new RoomsBed;
		if($request->id){
			$bed=Roomsbed::find($request->id);
		}
		$bed->room_id=$request->room_id;
		$bed->bedroom_name=$request->bedroom_name;
		$bed->bedroom_details=json_encode(array('king'=>$request->noof_king,'queen'=>$request->nooqueen,'double'=>$request->noofdouble,'single'=>$request->twinsingle,'bunk'=>$request->bunkbed,'child'=>$request->nochildbed,'sleepsofa'=>$request->nosleepsofa,'murphy'=>$request->murphy,'babycrib'=>$request->babycrib));
		$res=$bed->saveOrFail();
		$this->update_room_bedrooms($request->room_id);

		$this->update_status($request->room_id); // This function for update steps count in rooms_steps_count table

		if($res){
			if($request->id){
				return response()->json(array("status" => 'success', "message"=>"Update Successfully.", 'result' => $bed));
			}
			else{
				return response()->json(array("status" => 'success', "message"=>"Add Successfully.", 'result' => $bed));
			}
			
		}else{
			return response()->json(array("message"=>"Add Faild."));
		}
		return 'success';
	}
	public function add_bathroom(Request $request)	{
		$data_result['room_id']   = $request->id;
		$data_result['id']=$request->data['bath_id'];
		$data_result['room_step'] = $request->page;
		if($data_result['id']){
			$data_result['bath']=Roomsbath::where('id', $data_result['id'])->first();
		}else{
			$data_result['bath']='';
		}
		return view('list_your_space.add_bathroom',$data_result);
	}
	public function update_room_bedrooms($id) {
		$result_rooms = Rooms::whereId($id)->first();

		$bedrooms= RoomsBed::where('room_id', $id)->get()->count();
		$bedrooms ?? 0;

		$result_rooms->bedrooms = $bedrooms;

		$result_rooms->save();
	}
	public function update_room_bathrooms($id) {
		$result_rooms = Rooms::whereId($id)->first();
		$count = 0;
		$bathrooms= RoomsBath::where('room_id', $id)->get();

		if($bathrooms->count() > 0) {
			foreach($bathrooms as $bathroom) {
				if($bathroom->bathroom_type == "Full") {
					$count ++;
				} elseif($bathroom->bathroom_type == "Half" || $bathroom->bathroom_type == "Shower") {
					$count += 0.5;
				}
			}
		}

		$result_rooms->bathrooms = $count;

		$result_rooms->save();
	}
	public function location_not_found(Request $request)
	{
		$data  = $request;

		$data  = json_decode($data['data']); // AngularJS data decoding
		$data->country_name = Country::where('short_name', $data->country)->first()->long_name;

		$data_result['result'] = $data;

		return view('list_your_space.location_not_found', $data_result);
	}
	public function verify_location(Request $request)
	{
		$data  = $request;

		$data  = json_decode($data['data']); // AngularJS data decoding
		$data->country_name = Country::where('short_name', $data->country)->first()->long_name;
		$data_result['result'] = $data;

		return view('list_your_space.verify_location', $data_result);
	}
	public function finish_address(Request $request )
	{
		$data  = $request;

		$data  = json_decode($data['data']); // AngularJS data decoding

		$rooms = RoomsAddress::find($request->id); // Where condition for Update

		foreach($data as $key=>$value)
		{
			$rooms->$key = $value;          // Dynamic Update
		}

		$rooms->save();

		$rooms_status = RoomsStepsStatus::find($request->id);

		$rooms_status->location = 1;

		$rooms_status->save();

		$data_result = RoomsAddress::find($request->id);
		$room = Rooms::find($request->id);
		$address_url = url($room->address_url.'/'.$room->id);
		$data_result['address_url'] = $address_url;

		return json_encode($data_result);
	}
	public function update_amenities(Request $request )
	{
		$rooms = Rooms::find($request->id);

		$rooms->amenities = rtrim($request->data,',');

		$rooms->save();


		return json_encode(['success'=>'true']);
	}
	public function change_photo_order(Request $request){
		$cnt = count($request->image_id);
		foreach($request->image_id as $image_id){
			RoomsPhotos::where('room_id',$request->id)->where('id',$image_id)->update(['order' => $cnt]);
			$cnt--;
		}

	}

	public function update_upload_progress() {
		$progress_step = session()->get('upload_progress_step');
		$progress = session()->get('upload_progress');
		$progress += (float)$progress_step;
		session()->put('upload_progress', $progress);
		return;
	}
	public function add_photos(Request $request )
	{
		 

		$room = Rooms::find($request->id);
		$uploaded = RoomsPhotos::where('room_id',$request->id)->first();
		if($uploaded)
			$photos_count = $uploaded->photos_count;
		else
			$photos_count = 0;
		
		if(/*$room->image_upload_count > $photos_count*/ 1)
		{
			if(isset($_FILES["photos"]["name"]))
			{

				$rows = array();
				$err = array();

				$total_cnt_to_upload = count($_FILES["photos"]["error"]);
				$processes_per_img = 5;
				$progress_step = 1 / ($total_cnt_to_upload * $processes_per_img);
				session()->put('upload_progress_step', $progress_step);
				$progress = 0;
				session()->put('upload_progress', $progress);

				$file_names = array();

				foreach($_FILES["photos"]["error"] as $key=>$error)
				{
					$room = Rooms::find($request->id);
					$uploaded = RoomsPhotos::where('room_id',$request->id)->first();
					if($uploaded)
						$photos_count = $uploaded->photos_count;
					else
						$photos_count = 0;

					$tmp_name = $_FILES["photos"]["tmp_name"][$key];



					$name = str_replace(' ', '_', $_FILES["photos"]["name"][$key]);

					$size = $_FILES["photos"]["size"][$key];


					$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

					$name = time() . '_' . random_int( 100, 999) . $key;// . '_.' . $ext;

					$filename = dirname($_SERVER['SCRIPT_FILENAME']).'/images/rooms/'.$request->id;

					if(!file_exists($filename))
					{
						if ( ! mkdir( dirname( $_SERVER['SCRIPT_FILENAME'] ) . '/images/rooms/' . $request->id, 0777, true ) && ! is_dir( dirname( $_SERVER['SCRIPT_FILENAME'] ) . '/images/rooms/' . $request->id ) ) {
							throw new \RuntimeException( sprintf( 'Directory "%s" was not created', dirname( $_SERVER['SCRIPT_FILENAME'] ) . '/images/rooms/' . $request->id ) );
						}
					}
					if(1)
					{
						$max_limit_of_img_size = 10;     // 7 Mbyte
						if($size > $max_limit_of_img_size * 1024 * 1024) {       // restrict file size to 7 Mb
							$rows['error'] = array('error_title' => ' Photo Error', 'error_description' => trans('messages.lys.filesize_exceed_error', ['max_limit' => $max_limit_of_img_size]));
							$result = RoomsPhotos::where('room_id',$request->id)->orderBy('order','desc')->get();
							$rows['succresult'] = $result;
							return json_encode($rows);
						}if($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif')
						{
							
								// move_uploaded_file($tmp_name, "images/rooms/".$request->id."/".$name);
								$image_name =$tmp_name;;
								$option1 = array(
									"folder" => "/images/rooms/$request->id",
									"public_id" => $name,
									"quality"=>"auto:low",
									"flags"=>"lossy",
									"resource_type"=>"image"
								);
							 
								Cloudder::upload($tmp_name, null, $option1);
								if(Cloudder::getResult()){
									array_push($file_names, $name);
							$photos          = new RoomsPhotos;
							$photos->room_id = $request->id;
							$photos->name    = $name;
							$photos->storage = 'cloud';

							$photos->save();
								}
								

							$this->update_status($request->id);
						}
						else
						{
							$err = array('error_title' => ' Photo Error', 'error_description' => 'This is not an image file');

						}
					}
					/*else
					{
						$rows['error'] = array('error_title' => ' Photo Error', 'error_description' => trans('messages.lys.image_exceed_error'));
						$result = RoomsPhotos::where('room_id',$request->id)->get();
						$rows['succresult'] = $result;

						return json_encode($rows);
					}*/
				}
				// $this->process_image($request->id, $file_names);
				// event(new ProcessPhotos($request->id, $file_names));
				$result = RoomsPhotos::where('room_id',$request->id)->orderBy('order','desc')->get();
				$rows['succresult'] = $result;
				$rows['error'] = $err;
				return json_encode($rows);

			}
		}
		/*else
		{
			$rows['error'] = array('error_title' => ' Photo Error', 'error_description' => trans('messages.lys.image_exceed_error'));
			$result = RoomsPhotos::where('room_id',$request->id)->orderBy('order','desc')->get();
			$rows['succresult'] = $result;

			return json_encode($rows);
		}*/

	}
	public static function process_image($id, $file_names)
	{

		foreach ($file_names as $key => $name) {

			$pathinfo = pathinfo("images/rooms/".$id."/".$name);

			$SourceFile =   "images/rooms/".$id."/".$name;
			$watermark_img = "images/logos/favicon.png";

			$img = Image::make($SourceFile)->orientate();
			$img->resize(null, 960, function ($constraint) {
				$constraint->aspectRatio();
			});

			$img->insert($watermark_img,'top-left',40,40);
			$new_img1 = "images/rooms/".$id."/".$pathinfo['filename'].'_1440x960.'.$pathinfo['extension'];
			$img->save($new_img1);


			$img = Image::make($SourceFile)->orientate();
			$img->resize(null, 402, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->insert($watermark_img,'top-left',40,40);
			$new_img2 = "images/rooms/".$id."/".$pathinfo['filename'].'_1349x402.'.$pathinfo['extension'];
			$img->save($new_img2);


			$img = Image::make($SourceFile)->orientate();
			$img->resize(null, 250, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->insert($watermark_img,'top-left',40,40);
			$new_img3 = "images/rooms/".$id."/".$pathinfo['filename'].'_450x250.'.$pathinfo['extension'];
			$img->save($new_img3);


			$img = Image::make($SourceFile)->orientate();
			$img->resize(null, 200, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->insert($watermark_img,'top-left',20,20);
			$new_img4 = "images/rooms/".$id."/".$pathinfo['filename'].'_200x200.'.$pathinfo['extension'];
			$img->save($new_img4);


			$img = Image::make($SourceFile)->orientate();
			$img->resize(null, 100, function ($constraint) {
				$constraint->aspectRatio();
			});
			$img->insert($watermark_img,'top-left',10,10);
			$new_img5 = "images/rooms/".$id."/".$pathinfo['filename'].'_100x100.'.$pathinfo['extension'];
			$img->save($new_img5);
		}

	}
	public function featured_image(Request $request)
	{
		RoomsPhotos::whereRoomId($request->id)->update(['featured' => 'No']);

		RoomsPhotos::whereId($request->photo_id)->update(['featured' => 'Yes']);

		$photos = RoomsPhotos::where('room_id', $request->id)->orderBy('order','desc')->get();

		return json_encode($photos);
	}
	public function delete_photo(Request $request )
	{
		$photos          = RoomsPhotos::find($request->photo_id);
		if($photos != NULL){
			$this->remove_photo_files($request->id, $photos->original_name);
			$photos->delete();

		}

		$photos_featured = RoomsPhotos::where('room_id',$request->id)->where('featured','Yes');

		if($photos_featured->count() == 0)
		{
			$photos_featured = RoomsPhotos::where('room_id',$request->id);

			if($photos_featured->count() != 0)
			{
				$photos = RoomsPhotos::where('room_id',$request->id)->first();
				$photos->save();
			}
		}

		$rooms = Rooms::find($request->id);

		$this->update_status($request->id);

		return json_encode(['success'=>'true', 'steps_count' => $rooms->steps_count]);
	}
	public function remove_photo_files($room_id, $file_name) {

		$pathinfo = pathinfo("images/rooms/".$room_id."/".$file_name);


		$img = $pathinfo['dirname']."/".$pathinfo['filename'].'.'.$pathinfo['extension'];
		$img1 = $pathinfo['dirname']."/".$pathinfo['filename'].'_1440x960.'.$pathinfo['extension'];
		$img2 = $pathinfo['dirname']."/".$pathinfo['filename'].'_1349x402.'.$pathinfo['extension'];
		$img3 = $pathinfo['dirname']."/".$pathinfo['filename'].'_450x250.'.$pathinfo['extension'];
		$img4 = $pathinfo['dirname']."/".$pathinfo['filename'].'_200x200.'.$pathinfo['extension'];
		$img5 = $pathinfo['dirname']."/".$pathinfo['filename'].'_100x100.'.$pathinfo['extension'];


		if(file_exists($img)) unlink($img);
		if(file_exists($img1)) {

			unlink($img1);
		}
		if(file_exists($img2)) unlink($img2);
		if(file_exists($img3)) unlink($img3);
		if(file_exists($img4)) unlink($img4);
		if(file_exists($img5)) unlink($img5);
	}
	public function photos_list(Request $request)
	{
		$photos = RoomsPhotos::where('room_id', $request->id)->orderBy('order', 'desc')->get();

		return json_encode($photos);
	}
	public function photo_highlights(Request $request)
	{
		$photos = RoomsPhotos::find($request->photo_id);
		if(!$photos) {

			return json_encode(['success'=>'false', 'msg'=>'Saving failed. Something wrong, retry!']);
		}

		$photos->highlights = $request->data;

		$photos->save();

		return json_encode(['success'=>'true']);
	}
	public function update_price_rules(Request $request )
	{
		$rules    = [
			'period'    => 'required|integer|unique:rooms_price_rules,period,'.@$request->data['id'].',id,type,'.$request->type.',room_id,'.$request->id,
			'discount' => 'required|integer|between:1,99',
		];
		if($request->type == 'early_bird') {
			$rules['period'] .= '|between:30,1080';
		}
		if($request->type == 'last_min') {
			$rules['period'] .= '|between:1,28';
		}

		$messages = [
			'period.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.period')]),
			'discount.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.discount')]),
		];
		$attributes = [
			'period'    => trans('messages.lys.period'),
			'discount' => trans('messages.lys.discount'),
		];

		$validator = \Validator::make($request->data, $rules, $messages, $attributes);

		if($validator->fails()) {
			$errors = @$validator->errors()->getMessages();
			return json_encode(['success' => 'false', 'errors' => $errors]);
		}

		$rule = $request->data;
		if(@$rule['id']) {
			$check = [
				'id' => $rule['id'],
				'room_id' => $request->id,
				'type'    => $request->type,
			];
		}
		else {
			$check = [
				'room_id' => $request->id,
				'type'    => $request->type,
				'period'  => $rule['period']
			];
		}
		$price_rule = RoomsPriceRules::firstOrNew($check);
		$price_rule->room_id = $request->id;
		$price_rule->type =  $request->type;
		$price_rule->period = $rule['period'];
		$price_rule->discount = $rule['discount'];

		$price_rule->save();

		return json_encode(['success'=>'true', 'id' => $price_rule->id]);
	}
	public function delete_price_rule(Request $request) {
		$id = $request->rule_id;
		RoomsPriceRules::where('id', $id)->delete();
		return json_encode(['success' => true]);
	}
	public function delete_availability_rule(Request $request) {
		$id = $request->rule_id;
		RoomsAvailabilityRules::where('id', $id)->delete();
		return json_encode(['success' => true]);
	}
	public function update_reservation_settings(Request $request )
	{
		$room = Rooms::find($request->id);
		$rooms_price = $room->rooms_price;

		$rules    = [
			'minimum_stay' => 'integer|min:1|before:'.$request->maximum_stay,
			'maximum_stay'  => 'integer|min:1'
		];

		$messages = [
			'minimum_stay.before'   => trans('validation.max.numeric', ['attribute' => trans('messages.lys.minimum_stay'), 'max' => trans('messages.lys.maximum_stay')]),
			'minimum_stay.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.minimum_stay')]),
			'maximum_stay.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.maximum_stay')]),
		];
		$attributes = [
			'minimum_stay'    => trans('messages.lys.minimum_stay'),
			'maximum_stay' => trans('messages.lys.maximum_stay'),
		];

		$request_data = $request->all();
		$request_data['minimum_stay'] = is_numeric($request->minimum_stay) ? $request->minimum_stay -0 : $request->minimum_stay;
		$request_data['maximum_stay'] = is_numeric($request->maximum_stay) ? $request->maximum_stay -0 : $request->maximum_stay;
		$validator = \Validator::make($request_data, $rules, $messages, $attributes);

		if($validator->fails()) {
			$errors = @$validator->errors()->getMessages();
			return json_encode(['success' => 'false', 'errors' => $errors]);
		}

		$rooms_price->minimum_stay = $request->minimum_stay ?: null;
		$rooms_price->maximum_stay = $request->maximum_stay ?: null;

		$rooms_price->save();

		return json_encode(['success'=>'true']);
	}
	public function update_availability_rule(Request $request)
	{
		$rules    = [
			'type'         => 'required',
			'start_date'   => 'required',
			'end_date'     => 'required',
			'minimum_stay' => 'integer|min:1|before:'.@$request->availability_rule_item['maximum_stay'],
			'maximum_stay' => 'integer|min:1|required_if:minimum_stay,""'
		];

		$messages = [
			'minimum_stay.before'   => trans('validation.max.numeric', ['attribute' => trans('messages.lys.minimum_stay'), 'max' => trans('messages.lys.maximum_stay')]),
			'maximum_stay.required_if' => trans('messages.lys.minimum_or_maximum_stay_required'),
			'minimum_stay.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.minimum_stay')]),
			'maximum_stay.integer'  => trans('validation.numeric', ['attribute' => trans('messages.lys.maximum_stay')]),
		];
		$attributes = [
			'type'          => trans('messages.lys.select_dates'),
			'start_date'    => trans('messages.lys.start_date'),
			'end_date'      => trans('messages.lys.end_date'),
			'minimum_stay'  => trans('messages.lys.minimum_stay'),
			'maximum_stay'  => trans('messages.lys.maximum_stay'),
		];

		$request_data = $request->availability_rule_item;

		$request_data['minimum_stay'] = is_numeric(@$request_data['minimum_stay']) ? @$request_data['minimum_stay'] -0 : @$request_data['minimum_stay'];
		$request_data['maximum_stay'] = is_numeric(@$request_data['maximum_stay']) ? @$request_data['maximum_stay'] -0 : @$request_data['maximum_stay'];

		$validator = \Validator::make($request_data, $rules, $messages, $attributes);

		if($validator->fails()) {
			$errors = @$validator->errors()->getMessages();
			return json_encode(['success' => 'false', 'errors' => $errors]);
		}

		$rule = $request->availability_rule_item;
		$rooms = Rooms::where('id', $request->id)->first();

		$check = [
			'id' => @$rule['id'] ?: '',
		];
		$availability_rule = RoomsAvailabilityRules::firstOrNew($check);
		$availability_rule->room_id = $rooms->id;
		$availability_rule->start_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['start_date'], PHP_DATE_FORMAT));
		$availability_rule->end_date = date('Y-m-d', $this->helper->custom_strtotime(@$rule['end_date'], PHP_DATE_FORMAT));
		$availability_rule->minimum_stay = @$rule['minimum_stay'] ?: null;
		$availability_rule->maximum_stay = @$rule['maximum_stay'] ?: null;
		$availability_rule->type = @$rule['type'] != 'prev' ? @$rule['type']: @$availability_rule->type;
		$availability_rule->save();


		return json_encode(['success'=>'true', 'availability_rules' => $rooms->availability_rules]);
	}
	public function rooms_short_detail( Request $request, CalendarController $calendar){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::find($request->room_id);
		$data['latitude']            = $data['result']->rooms_address->latitude;
		$data['longitude']            = $data['result']->rooms_address->longitude;

		return $data;
	}
	public function getRoomReviews(Request $request){
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);
		$data['reviews'] = $data['result']->reviews()->active();
		foreach($data['reviews'] as $key => $review){
			$data['reviews'][$key]['user_full_name']  = $review->users_from()->first()->full_name;
			$data['reviews'][$key]['user_avatar']  = $review->users_from()->first()->profile_picture()->first()->src;
			$data['reviews'][$key]['user_id']  = $review->users_from()->first()->id;
		}
		$data['overall_star_rating'] = $data['result']->overall_star_rating;
		return $data;
	}
	public function getHouseType(Request $request){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);
		$property_type = $data['result']->property_type;
		$data['house_type'] = PropertyType::where('id', $property_type)->first();
		return $data;
	}
	public function get_amenities_type(Request $request){
		$data['room_id']  = $request->room_id;
		$room  = Rooms::with('rooms_price')->find($request->room_id);
		$amenities_id = explode(",",	$room['amenities']);
		foreach ($amenities_id as $id) {
			$amenities[] = Amenities::where('id', $id)->first();
		}
		$prev = null;

		if($amenities[0] == null) {
			$amenities = [];
			$amenities_type = [];
		}

		foreach ($amenities as $amenitie) {
			if ($amenitie) {
				if($amenitie->type_id != $prev){
					$amenities_type[] = AmenitiesType::where('id', $amenitie->type_id)->first();
				}
				$prev = $amenitie->type_id;
			}
		}

		$data['amenities']        = $amenities;
		$data['amenities_icon']   = Amenities::where('status','Active')->get();
		$data['safety_amenities'] = Amenities::selected_security($request->room_id);
		$data['amenities_type']   = $amenities_type;
		return $data;
	}
	public function getRoomDescriptions(Request $request){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);
		$data ['rooms_description'] = $data['result']-> rooms_description;
		return $data;
	}
	public function get_room_seasonal_rate(Request $request){
	 
		$data['seasonal_price_detail'] = SeasonalPrice::where([['room_id',$request->room_id]])->groupBy('seasonal_name')->get();
		return $data;
	}
	public function getRoomPhotos(Request $request){
		$data['rooms_photos']     = RoomsPhotos::where('room_id', $request->room_id)->orderBy('order','desc')->get();
		foreach($data['rooms_photos'] as $key => $room_photo){
			$data['rooms_photos'][$key]['slide_image_name'] = $room_photo->slider_image_name;
			$data['rooms_photos'][$key]['listing_image_name'] = $room_photo->listing_image_name;
			// $data['rooms_photos'][$key]['manage_listing_photos_image_name'] = $room_photo->manage_listing_photos_image_name;
		}
		return $data;
	}
	public function getSimilarListings(Request $request){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);
		$rooms_address            = $data['result']->rooms_address;
		$latitude                 = $rooms_address->latitude;
		$longitude                = $rooms_address->longitude;
			$data['similar'] = Rooms::with('rooms_price') ->join('rooms_address', function($join) {
						$join->on('rooms.id', '=', 'rooms_address.room_id');
					})
					->leftJoin('users', 'rooms.user_id', 'users.id')
					->select(DB::raw('
					`rooms`.`id`,
					`name`,
					`sub_name`,
					 ( 3959 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) as distance'))
					->having('distance', '<=', 30)
					->where('rooms.id', '!=', $request->room_id)
					->where('rooms.status', 'Listed')
					->where('users.status', 'Active')
					// ->whereHas('users', function($query)  {
					// 	$query->where('users.status','Active');
					// })
					->where('subscription_end_date','>=',date('Y-m-d'))
					->get();
					// exit;
			// $data['similar'] = Rooms::with('rooms_price') ->join('rooms_address', function($join) {
			// 			$join->on('rooms.id', '=', 'rooms_address.room_id');
			// 		})
			// 		->select(DB::raw('
			// 		`id`,
			// 		`name`,
			// 		`sub_name`,
			// 		 ( 3959 * acos( cos( radians('.$latitude.') ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians('.$longitude.') ) + sin( radians('.$latitude.') ) * sin( radians( latitude ) ) ) ) as distance'))
			// 		->having('distance', '<=', 30)
			// 		->where('rooms.id', '!=', $request->room_id)
			// 		->where('rooms.status', 'Listed')
			// 		->whereHas('users', function($query)  {
			// 			$query->where('users.status','Active');
			// 		})
			// 		->where('subscription_end_date','>=',date('Y-m-d'))
			// 		->toSql();

			   foreach($data['similar'] as $key => $room){
		   		$data['similar'][$key]['slide_image_name'] = $room->getFeaturedImageSmallAttribute();
			  }
			//   exit;
			// echo json_encode($data);exit;
		return $data;
	}
	public function unavailable_calendar( Request $request){
		return Calendar::where([['room_id',$request->room_id], ['status', '=', 'Not available']])->groupBy('seasonal_name')->get();
	}
	public function rooms_detail( Request $request, CalendarController $calendar){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);
		// $property_type = $data['result']->property_type;
		// $data['house_type'] = PropertyType::where('id', $property_type)->first();
		// $data['is_wishlist'] = SavedWishlists::where('user_id',@Auth::user()->id)->where('room_id',$request->room_id)->count();
		// if(!$data['result']) {
		// 	return redirect( 'search' );
		// }
		
		$data['user_details']   =   User::find($data['result']->user_id);
		$data['user_details']['user_profile_pic'] =  User::find($data['result']->user_id)->profile_picture()->first()->src;
		// if($data['user_details']->status != 'Active' && $data['result']->user_id != @Auth::user()->id) {
	
		// 	// return redirect( 'search' );
		// }
		// else if($data['result']->status != 'Listed' && $data['result']->user_id != @Auth::user()->id) {
		// 	// echo $room->address_url != $request->address_url;exit;
		// 	// return redirect( 'search' );
		// }
		// else if($data['result']->subscription_end_date < date('Y-m-d') && $data['result']->user_id != @Auth::user()->id) {
		// }
		
		// if($data['result']->user_id != @Auth::user()->id && $data['result']->status == 'Listed' ){
		// 	$data['result']->views_count += 1;
		// 	$data['result']->save();
		// }

	
		// $data['rooms_photos']     = RoomsPhotos::where('room_id', $request->room_id)->orderBy('order','desc')->get();
		// foreach($data['rooms_photos'] as $key => $room_photo){
		// 	$data['rooms_photos'][$key]['slide_image_name'] = $room_photo->slider_image_name;
		// 	$data['rooms_photos'][$key]['listing_image_name'] = $room_photo->listing_image_name;
		// 	// $data['rooms_photos'][$key]['manage_listing_photos_image_name'] = $room_photo->manage_listing_photos_image_name;
		// }
		// $data['room_types']       = $data['result']->room_type_name;
		// $data['cancellation']     = $data['result']->cancel_policy;
		$rooms_address            = $data['result']->rooms_address;		
		// $latitude                 = $rooms_address->latitude;
		// $longitude                = $rooms_address->longitude;

		// if($request->checkin != '' && $request->checkout != ''){
		// 	$data['checkin']         = date('m/d/y', $this->helper->custom_strtotime($request->checkin));
		// 	$data['checkout']        = date('m/d/y', $this->helper->custom_strtotime($request->checkout));
		// 	$data['formatted_checkin'] = date('d-m-Y',$this->helper->custom_strtotime($request->checkin));
		// 	$data['formatted_checkout'] = date('d-m-Y',$this->helper->custom_strtotime($request->checkout));
		// 	if(@$data['result']['accommodates'] >= @$request->guests){
		// 		$data['guests']          = $request->guests;}else{
		// 		$data['guests']          = '1';
		// 	}
		// }
		// else{
		// 	$data['checkin'] = '';
		// 	$data['checkout'] = '';
		// 	$data['guests'] = @$request->guests ;
		// 	$data['formatted_checkin'] = '';
		// 	$data['formatted_checkout'] = '';
		// }
		
		// $meta = Metas::where('url', $data['result']->slug)->first();
		// if($meta){
		// 	$meta_title = $this->meta( $data['result']->slug, 'title');
		// 	$meta_h1 = $this->meta( $data['result']->slug, 'meta_h1');
		// 	$meta_description = $this->meta($data['result']->slug, 'description');
		// 	$data['meta_keywords'] = $this->meta($data['result']->slug, 'keywords');
		// 	$meta_image = $this->meta( $data['result']->slug, 'meta_image');
		// }
		// //store meta
		// $this->setMeta( $room );
		// $data['meta_h1'] = $meta_h1 ?? $room->meta_h1;
		// 
		// // $data['not_available_days'] = 

		// $data['bathrooms']=RoomsBath::where('room_id',$request->room_id)->get();
		// $data['bedrooms']=RoomsBed::where('room_id',$request->room_id)->get();
		// $data['no_of_bathrooms']=RoomsBath::where('room_id',$request->room_id)->get()->count();
		// $data['no_of_bedrooms']=RoomsBed::where('room_id',$request->room_id)->get()->count();
		// $data['room_type_name'] = $data['result']->room_type_name;

		// $bed_type_no = Rooms::where('id', $request->room_id)->first();

		// $bed_type = BedType::where('id', $bed_type_no->bed_type)->first();

		// if($bed_type !=null && isset($bed_type))
		// 	$data['bed_type_name'] = $bed_type->name;
		// else
		// 	$data['bed_type_name'] = '';

	
		// $data['result']['property_type_name'] = $data['house_type']['name'];
		// 
		return $data;
		return view('rooms.rooms_detail', $data);
	}
	public function room_details( Request $request){
		$data['room_id']  = $request->room_id;
		$data['result']  = Rooms::with('rooms_price')->find($request->room_id);		
		$rooms_address = $data['result']->rooms_address;
		$data['city'] = $rooms_address->city;
		$data['state'] = $rooms_address->state;
		$roomdetail = $data['city'].' '.$data['state'].' Vacation Rentals Property '.$data['room_id'];
		$rooms_description = $data['result']->summary;	
		$featured_image = $data['result']->featured_image	;
		
		// dd($rooms_description);
		 
		return view('listingdetail', compact('roomdetail', 'rooms_description', 'featured_image'));
	}
	public function ajax_calendar_fetch(Request $request, CalendarController $calendar) {
		$data_calendar     = @json_decode($request['data']);

		$target_year              = @$data_calendar->year;
		$target_month             = @$data_calendar->month;

		return $calendar->generate_month_calendar($request->id, $target_year, $target_month);
	}
	public function remove_video(Request $request){
		$rooms = Rooms::find($request->id);

		$rooms->video = '';
		$rooms->save();
		return json_encode(['success' => 'true', 'video' => '']);
	}
	public function rooms_slider(Request $request)
	{
		$data['room_id']      = $request->id;

		$data['result']       = Rooms::find($request->id);

		$data['rooms_photos'] = RoomsPhotos::where('room_id', $request->id)->orderBy('order','desc')->get();

		$data['version'] = @SiteSettings::where('name', 'version')->first()->value;

		return view('rooms.rooms_slider', $data);
	}
	public function currency_check(Request $request)
	{
		$id             = $request->id;
		$new_price      = $request->n_price;
		$price          = RoomsPrice::find($id);
		$minimum_amount = $this->payment_helper->currency_convert('USD', $price->currency_code, 10);
		$currency_symbol = Currency::whereCode($price->currency_code)->first()->original_symbol;
		if($minimum_amount > $new_price)
		{
			echo "fail";
		}
		else
		{
			echo "success";
		}
	}
	public function update_price(Request $request)
	{
		$data           = $request;
		$data           = json_decode($data['data']); // AngularJS data decoding
		foreach ($data as $key => $value)
		{
			if($key == 'currency_code') {
				if(Currency::where('code', $value)->count() == 0) {
					return json_encode(['success'=>'false','msg' => 'This is invalid currency type.', 'attribute' => $key]);
				}
			} else if($key == 'weekenddays') {
				if(!in_array($value, [1 ,2, 3])) {
					return json_encode(['success'=>'false','msg' => 'This is invalid type.', 'attribute' => $key]);
				}
			} else if($key == 'cleaning_fee_type') {
				if(!in_array($value, [0, 1, 2, 3])) {
					return json_encode(['success'=>'false','msg' => 'This is invalid type.', 'attribute' => $key]);
				}
			} else if($key == 'tax') {
				if(!is_numeric($value) || ($value < 0)) {
					return json_encode(['success'=>'false','msg' => 'This field must be integer/float.', 'attribute' => $key]);
				}
			} else {
				if(!is_numeric($value)) {
					return json_encode(['success'=>'false','msg' => 'This field must be integer.', 'attribute' => $key]);
				} else if( !is_int( $value * 1) || $value < 0) {
					return json_encode(['success'=>'false','msg' => 'This field must be integer.', 'attribute' => $key]);
				}
			}
		}

		$minimum_amount = $this->payment_helper->currency_convert('USD', isset($data->currency_code) ? $data->currency_code : 'USD', 10);
		$currency_symbol = Currency::whereCode(isset($data->currency_code) ? $data->currency_code : 'USD')->first()->original_symbol;

		if(isset($data->night))
		{
			$old_currency_format = RoomsPrice::find($request->id);
			$night_price = $data->night;
			if(is_numeric($night_price) && $night_price < $minimum_amount)
			{
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'night', 'currency_symbol' => $currency_symbol,'min_amt' => $minimum_amount]);
			}
			$data->night=$night_price;
		} else {
			$night_price = '';
		}

		if(isset($data->week) && @$data->week !='0' && @$data->week !=''){
			$week_price = $data->week;
			if($week_price < $minimum_amount){
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'week', 'currency_symbol' => $currency_symbol]);
			}
		}

		if(isset($data->month) && @$data->month !='0' && @$data->month !=''){
			$month_price = $data->month;
			if($month_price < $minimum_amount){
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => 'price', 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'month', 'currency_symbol' => $currency_symbol]);
			}
		}

		if(isset($data->additional_charge) && @$data->additional_charge !='0' && @$data->additional_charge !=''){
			$additional_charge = $data->additional_charge;
		}

		$price          = RoomsPrice::find($request->id);
		if(!$price){
			$price = new RoomsPrice;
			
			$price->currency_code = isset($data->currency_code) ? $data->currency_code : 'USD';
			// $price->save();
		}
		$price->room_id = $request->id;
		foreach ($data as $key => $value)
		{
			$price->$key = $value;
		}

		$price->save();

		$this->update_status($request->id);


		return json_encode(['success'=>'true', 'currency_symbol' => $price->currency->original_symbol, 'steps_count' => $price->steps_count,'night_price'=>$night_price]);
	}
	public function update_additional_price(Request $request){
		$label = array();
		foreach ($request->additional_charges as $key => $charge) {
			$label[] = $charge['label'];
			if($charge['label'] == '' || $charge['price'] == '') {
				return json_encode(['success'=>'false','msg' => 'There is a empty charge name or charge fee.', 'attribute' => 'additional_charge']);
			}

			if($charge['price_type'] == '' || $charge['calc_type'] == '' || $charge['guest_opt'] == '') {
				return json_encode(['success'=>'false','msg' => 'There is a unselected calculation type, price type or guest option.', 'attribute' => 'additional_charge']);
			}

			if(!in_array($charge['price_type'], [0, 1])) {
				return json_encode(['success'=>'false','msg' => 'Price type is invalid.', 'attribute' => 'additional_charge']);
			}

			if(!in_array($charge['calc_type'], [0, 1, 2])) {
				return json_encode(['success'=>'false','msg' => 'Price type is invalid.', 'attribute' => 'additional_charge']);
			}

			if(!in_array($charge['guest_opt'], [0, 1])) {
				return json_encode(['success'=>'false','msg' => 'Price type is invalid.', 'attribute' => 'additional_charge']);
			}

		}

		foreach ($label as $key => $value) {
			if($value != '') {
				$temp = $label;
				unset($temp[$key]);
				if(in_array($value, $temp)) {
					return json_encode(['success'=>'false','msg' => 'There is a duplication of charge name.', 'attribute' => 'additional_charge']);
				}
			}
		}

		$price = RoomsPrice::find($request->id);
		$price->additional_charge=json_encode($request->additional_charges);
		$price->save();
		return json_encode(['success'=>'true']);
	}
	public function rooms_steps_status(Request $request)
	{
		return RoomsStepsStatus::find($request->id);
	}
	public function rooms_data(Request $request)
	{
		$data           = Rooms::find($request->id);
		$address_url = $data->link;

		$rooms_address  = array_merge($data->toArray(),$data->rooms_address->toArray());

		$rooms_price    = array_merge($rooms_address,$data->rooms_price->toArray());

		$rooms_currency = array_merge($rooms_price,['symbol' => $data->rooms_price->currency->symbol,'address_url' => $address_url ]);

		return json_encode($rooms_currency);
	}
	public function rooms_calendar(Request $request)
	{
		Session::forget('coupon_code');
		Session::forget('coupon_amount');
		Session::forget('remove_coupon');
		Session::forget('manual_coupon');

		$id  = $request->data;
		$result['not_available_checkin'] = Calendar::where([
			['room_id', $id],
			['status', '<>', 'Available'],
		])->get()->pluck('date');

		$result['not_available_checkout'] = Calendar::where([
			['room_id', $id],
			['status', '<>', 'Available'],
		])->whereRaw('date != start_date')->get()->pluck('date');

		$result['changed_price'] = Calendar::where([
			['room_id', $id],
		])->get()->pluck('price','date');


		$result['price'] = RoomsPrice::where('room_id', $id)->get()->pluck('original_night');
		$result['weekend'] = RoomsPrice::where('room_id', $id)->get()->pluck('original_weekend');

		$result['currency_symbol'] = RoomsPrice::where('room_id', $id)->first()->currency->original_symbol;

		return json_encode($result);
	}
	public function rooms_calendar_alter(Request $request)
	{
		$id     = $request->data;

		$checkin                      = date('Y-m-d', strtotime($request->checkin));
		$date2                    = date('Y-m-d', strtotime($request->checkout));

		$checkout                      = date('Y-m-d',(strtotime ( '-1 day' , strtotime ($date2 ) ) ));

		$booked_days = $this->get_days($checkin, $checkout);

		$result['not_available'] = Calendar::where('room_id', $id)->where('status','Not available')->whereNotIn('date',$booked_days)->get()->pluck('date');

		$result['changed_price'] = Calendar::where('room_id', $id)->get()->pluck('price','date');

		$result['price'] = RoomsPrice::where('room_id', $id)->get()->pluck('night');

		$result['currency_symbol'] = Currency::find(1)->symbol;

		return json_encode($result);
	}
	public function price_calculation(Request $request)
	{
		Session::forget('coupon_code');
		Session::forget('coupon_amount');
		Session::forget('remove_coupon');
		Session::forget('manual_coupon');

		session(['guest_options' => $request->guest_options]);		// save guest option info for other pages

		return $this->payment_helper->price_calculation($request->room_id, $request->checkin, $request->checkout, $request->guest_count, $request->guest_options ,'',$request->change_reservation);
	}
	public function check_availability(Request $request)
	{
		$room_id = $request->room_id;
		$checkin = $request->checkin;
		$checkout= $request->checkout;
		$date_from = strtotime($checkin);
		$date_to = strtotime($checkout);
		$date_ar=array();
		for ($i=$date_from; $i<=$date_to - 1; $i+=86400) {
			$date_ar[]= date("Y-m-d", $i);
		}
		$check=array();
		for ($i=0, $iMax = count( $date_ar ); $i < $iMax; $i++) {
			$check[]=DB::table('calendar')->where([ 'room_id' => $room_id, 'date' => $date_ar[$i], 'status' => 'Not available' ])->first();
		}

		return $check;
		exit;
	}
	public function checkin_date_check(Request $request)
	{
		$room_id = $request->room_id;
		$date = $request->date;
		$date = (strtotime($date)) - (24*3600*1);
		$date = date('Y-m-d',$date);
		$result = DB::table('calendar')->where([ 'room_id' => $room_id, 'date' => $date, 'status' => 'Not available' ])->get();
		$checkout = (strtotime($request->date)) + (24*3600*1);
		$checkout =  date('mm-dd-yyyy',$checkout);
		$check = array(
			'checkin'=>$request->date,
			'checkout'=>$checkout
		);
		return $check;
	}
	public function current_date_check(Request $request)
	{
		$room_id = $request->room_id;
		$checkin = $request->checkin;
		$check_in=date('Y-m-d', strtotime($checkin));
		$result = DB::table('calendar')->where([ 'room_id' => $room_id, 'date' => $check_in, 'status' => 'Not available' ])->get();
		$check=array();
		if(count($result) >= 1 )
		{
			$chck_date=strtotime($checkin);
			$end_date = $chck_date + (24*3600*50);
			for ($i=$chck_date + (24*3600*1) ; $i < $end_date; $i+=86400)
			{

				$check[] = DB::table('calendar')->where([ 'room_id' => $room_id, 'date' => date("Y-m-d", $i), 'status' => 'Not available' ])->first();
				if($check)
				{
					$available_date= date('Y-m-d', $i);
					return $available_date; exit;
				}
			}
		}
		else
		{

			return $result[0]->date;
		}
	}
	public function get_days($sStartDate, $sEndDate){
		$aDays[]      = $sStartDate;

		$sCurrentDate = $sStartDate;

		while($sCurrentDate < $sEndDate){

			$sCurrentDate = gmdate("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));

			$aDays[]      = $sCurrentDate;
		}

		return $aDays;
	}
	public function update_description(Request $request)
	{
		$data           = @$request;
		$data           = json_decode($data['data']); // AngularJS data decoding
		$request->current_tab = @$request->current_tab  ?: 'en';
		if(@$request->current_tab != 'en')
		{
			$roomlang          = RoomsDescriptionLang::where('room_id',@$request->id)->where('lang_code',@$request->current_tab)->first();
			if($roomlang !='')
			{
				$roomlang->room_id = @$request->id;
				$roomlang->lang_code = @$request->current_tab;
				foreach ($data as $key => $value)
				{
					$roomlang->$key =  $value;
				}
				$roomlang->save();
			}else
			{  $roomlang = new RoomsDescriptionLang;
				$roomlang->room_id = @$request->id;
				$roomlang->lang_code = @$request->current_tab;
				foreach ($data as $key => $value)
				{
					$roomlang->$key =  $value;
				}
				$roomlang->save();
			}
		}else{
			$price          = @RoomsDescription::find(@$request->id);
			if($price != '')
			{
				$price->room_id = @$request->id;

				foreach ($data as $key => $value)
				{
					$price->$key =  $value;
				}
				$price->save();
			}else
			{   $price          = new RoomsDescription;
				$price->room_id = @$request->id;
				foreach ($data as $key => $value)
				{
					$price->$key =  $value;
				}

				$price->save();
			}
		}
		foreach ($data as $key => $value)
		{
			if($key == 'space'){
				$field = 'The Space';
			}elseif ($key == 'access') {
				$field = 'Guest Access';
			}elseif ($key == 'interaction') {
				$field = 'Interaction with Guests';
			}elseif ($key == 'notes') {
				$field = 'Other Things to Note';
			}elseif ($key == 'house_rules') {
				$field = 'House Rules';
			}elseif ($key == 'neighborhood_overview') {
				$field = 'Overview';
			}elseif ($key == 'transit') {
				$field = 'Getting Around';
			}else{
				$field = '';
			}

			if($field != ''){
			}
		}

		return json_encode(['success'=>'true']);
	}
	public function calendar_edit(Request $request)
	{
		$start_date = date('Y-m-d', strtotime($request->start_date));
		$start_date = strtotime($start_date);

		$end_date   = date('Y-m-d', strtotime($request->end_date));
		$end_date   = strtotime($end_date);
		$room_price=RoomsPrice::where('room_id',$request->id)->first()->original_night;
		if($request->price && $request->price-0 > 0){
			for ($i=$start_date; $i<=$end_date; $i+=86400)
			{
				$date = date("Y-m-d", $i);

				$is_reservation = Reservation::whereRoomId($request->id)->whereRaw('status!="Declined"')->whereRaw('status!="Expired"')->whereRaw('status!="Cancelled"')->whereRaw('(checkin = "'.$date.'" or (checkin < "'.$date.'" and checkout > "'.$date.'")) ')->get()->count();
				if($is_reservation == 0)
				{
					$data = [ 'room_id' => $request->id,
					          'price'   => ($request->price) ? $request->price : '0',
					          'status'  => "$request->status",
					          'notes'   => $request->notes,
					          'source'  => 'Calendar'
					];
					Calendar::updateOrCreate(['room_id' => $request->id, 'date' => $date], $data);
					if($request->status=="available" && $room_price==$request->price && $request->notes == '')
					{
						Calendar::where('room_id',$request->id)->where('date',$date)->delete();
					}
				}
			}
		}
	}
	public function contact_request(Request $request)
	{
		$data['price_list']       = json_decode($this->payment_helper->price_calculation($request->id, $request->message_checkin, $request->message_checkout, $request->message_guests));
		$rooms = Rooms::find($request->id);
		if(@$data['price_list']->status == 'Not available')
		{
			$this->helper->flash_message('error', @$data['price_list']->error ?: trans('messages.rooms.dates_not_available')); // Call flash message function
			return redirect()->route('rooms.rooms_detail', ['address'=>$rooms->address_url,'id'=>$rooms->id]);
		}



		$reservation = new Reservation;

		$reservation->room_id          = $request->id;
		$reservation->host_id          = $rooms->user_id;
		$reservation->user_id          = Auth::user()->id;
		$reservation->checkin          = date('Y-m-d', strtotime($request->message_checkin));
		$reservation->checkout         = date('Y-m-d', strtotime($request->message_checkout));
		$reservation->number_of_guests = $request->message_guests;
		$reservation->nights           = $data['price_list']->total_nights;
		$reservation->per_night        = $data['price_list']->per_night;
		$reservation->subtotal         = $data['price_list']->subtotal;
		$reservation->cleaning         = $data['price_list']->cleaning_fee;
		$reservation->additional_guest = $data['price_list']->additional_guest;
		$reservation->security         = $data['price_list']->security_fee;
		$reservation->service          = $data['price_list']->service_fee ?? 0;
		$reservation->host_fee         = $data['price_list']->host_fee ?? 0;
		$reservation->total            = $data['price_list']->total;
		$reservation->currency_code    = $data['price_list']->currency;
		$reservation->type             = 'contact';
		$reservation->country          = 'US';

		$reservation->base_per_night                = $data['price_list']->base_rooms_price;
		$reservation->length_of_stay_type           = $data['price_list']->length_of_stay_type;
		$reservation->length_of_stay_discount       = $data['price_list']->length_of_stay_discount;
		$reservation->length_of_stay_discount_price = $data['price_list']->length_of_stay_discount_price;
		$reservation->booked_period_type            = $data['price_list']->booked_period_type;
		$reservation->booked_period_discount        = $data['price_list']->booked_period_discount;
		$reservation->booked_period_discount_price  = $data['price_list']->booked_period_discount_price;

		$reservation->save();
		$question = $request->question;
		$replacement = "[url_removed]";
		$url_pattern = "/[a-zA-Z]*[:\/\/]*[A-Za-z0-9\-_]+\.+[A-Za-z0-9\.\/%&=\?\-_]+/i";
		$replace = array($replacement, $replacement);

		$question = preg_replace($url_pattern, $replacement, $question);

		$message = new Messages;

		$message->room_id        = $request->id;
		$message->reservation_id = $reservation->id;
		$message->user_to        = $rooms->user_id;
		$message->user_from      = Auth::user()->id;
		$message->message        = $question;
		$message->message_type   = 9;
		$message->read           = 0;

		$message->save();


		$this->helper->flash_message('success', trans('messages.rooms.contact_request_has_sent',['first_name'=>$rooms->users->first_name])); // Call flash message function
		return redirect()->route('rooms.rooms_detail', ['address'=>$rooms->address_url,'id'=>$rooms->id]);
	}
	public function get_lang_details(Request $request)
	{

		$data = RoomsDescriptionLang::with(['language'])->where('room_id', $request->id)->get();

		return json_encode($data);
	}
	public function get_lang(Request $request)
	{

		$data = Language::where('status','Active')->where('name', '!=', 'English')->get();

		return json_encode($data);
	}
	public function add_description(Request $request)
	{

		$language = new RoomsDescriptionLang;

		$language->room_id        = $request->id;
		$language->lang_code      = $request->lan_code;
		$language->name           = '';
		$language->summary        = '';

		$language->save();
		$result = RoomsDescriptionLang::with(['language'])->where('room_id', $request->id)->get();

		if($result->count())
		{
			foreach($result as $row)
			{
				$row->lan_id = count($result);
			}
			return json_encode($result);
		}
		else
		{
			return '[{"name":"", "summary":"","space":"","access":"","interaction":"","notes":"","house_rules":"",
             "neighborhood_overview":"","transit":"","lang_code":""}]';
		}
		return json_encode($result);

	}
	public function delete_language(Request $request)
	{


		RoomsDescriptionLang::where('room_id', $request->id)->where('lang_code', $request->current_tab)->delete();

		return json_encode(['success'=>'true']);

	}
	public function lan_description(Request $request)
	{
		$result = RoomsDescriptionLang::with(['language'])->where('room_id', $request->id)->get();

		if($result->count())
		{
			foreach($result as $row)
			{
				$row->lan_id = count($result);
			}
			return json_encode($result);
		}
		else
		{
			return '[{"name":"", "summary":"","space":"","access":"","interaction":"","notes":"","house_rules":"",
             "neighborhood_overview":"","transit":"","lang_code":""}]';
		}
	}
	public function get_description(Request $request)
	{

		if($request->lan_code =="en")
		{
			$result = Rooms::with(['rooms_description'])->where('id', $request->id)->get();

		}
		else
		{
			$result = RoomsDescriptionLang::with(['language'])->where('room_id', $request->id)->where('lang_code', $request->lan_code)->get();
		}


		if($result->count())
		{
			return json_encode($result);
		}
		else
		{
			return '[{"name":"", "summary":"","space":"","access":"","interaction":"","notes":"","house_rules":"",
             "neighborhood_overview":"","transit":"","lang_code":""}]';
		}
	}
	public function get_all_language(Request $request)
	{

		$result = DB::select( DB::raw("select * from language where language.value not in (SELECT language.value FROM `language` JOIN rooms_description_lang on (rooms_description_lang.lang_code = language.value AND rooms_description_lang.room_id = '$request->id')) AND  language.status = 'Active' AND language.name != 'English'  ") );

		return json_encode($result);

	}
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 * @throws \Exception
	 */
	public function add_seasonal_price(Request $request){

		$checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
		$checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));


		$days = $this->get_days($checkin,$checkout);

		$rooms_price = RoomsPrice::where('room_id',$request->id)->first();

		$minimum_amount = $this->payment_helper->currency_convert('USD',$rooms_price->currency_code , 10);

		$currency_symbol = Currency::whereCode($rooms_price->currency_code)->first()->original_symbol;

		if($request->price)
		{
			$old_currency_format = RoomsPrice::find($request->id);
			$night_price = $request->price;
			if(is_numeric($night_price) && $night_price < $minimum_amount)
			{
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'price', 'currency_symbol' => $currency_symbol,'min_amt' => $minimum_amount]);
			}
		}

		if($request->week)
		{
			$old_currency_format = RoomsPrice::find($request->id);
			$night_price = $request->week;
			if(is_numeric($night_price) && $night_price < $minimum_amount)
			{
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'week', 'currency_symbol' => $currency_symbol,'min_amt' => $minimum_amount]);
			}
		}

		if($request->month)
		{
			$old_currency_format = RoomsPrice::find($request->id);
			$night_price = $request->month;
			if(is_numeric($night_price) && $night_price < $minimum_amount)
			{
				return json_encode(['success'=>'false','msg' => trans('validation.min.numeric', ['attribute' => trans('messages.inbox.price'), 'min' => $currency_symbol.$minimum_amount]), 'attribute' => 'month', 'currency_symbol' => $currency_symbol,'min_amt' => $minimum_amount]);
			}
		}

		if($request->edit_season_name !== ""){          // when edit season
			$calendar = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->edit_season_name)->where('status', '!=', 'Not available')->delete();
			SeasonalPrice::where('room_id',$request->id)->where('seasonal_name',$request->edit_season_name)->delete();
		}
		foreach($days as $day){
			$not_available_date = Calendar::where([
				['room_id',$request->id],
				['date',$day],
				['status', 'Not available']
			])->first();
			if($not_available_date) continue; // if "Not Available" date exist, skip

			$reserved_date = Calendar::where([
				['room_id',$request->id],
				['date',$day],
				['status', 'Reserved']
			])->first();
			if($reserved_date) continue; // if "Not Available" date exist, skip

			$calendar = new Calendar;
			$calendar->room_id = $request->id;
			$calendar->seasonal_name = $request->season_name;
			$calendar->date = $day;
			$calendar->start_date = $checkin;
			$calendar->end_date = $checkout;
			$calendar->price = $request->price;
			$calendar->week = @$request->week;
			$calendar->month = @$request->month;
			$calendar->weekend = @$request->weekend;
			$calendar->additional_guest = @$request->additional_price;
			$calendar->guests = @$request->additional_price ? '1' : '0';
			$calendar->minimum_stay = $request->minimum_stay;
			$calendar->status = $request->status;
			$calendar->source = 'Calendar';
			$calendar->save();

		}

		$seasonal_price = new SeasonalPrice;
		$seasonal_price->room_id = $request->id;
		$seasonal_price->seasonal_name = $request->season_name;
		$seasonal_price->start_date = $checkin;
		$seasonal_price->end_date = $checkout;
		$seasonal_price->price = $request->price;
		$seasonal_price->week = @$request->week;
		$seasonal_price->month = @$request->month;
		$seasonal_price->weekend = @$request->weekend;
		$seasonal_price->additional_guest = @$request->additional_price;
		$seasonal_price->guests = @$request->additional_price ? '1' : '0';
		$seasonal_price->minimum_stay = $request->minimum_stay;
		$seasonal_price->save();


		return json_encode(['success' =>'true']);
	}
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function check_seasonal(Request $request){

		$checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
		$checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));


		$check_cal = SeasonalPrice::where([['room_id', $request->id], ['seasonal_name','!=',$request->edit_season_name], ['start_date', '<=', $checkin], ['end_date', '>=', $checkin]])->orWhere([['room_id', $request->id], ['seasonal_name','!=',$request->edit_season_name], ['start_date', '<=', $checkout], ['end_date', '>=', $checkout]])->first();


		if($check_cal){

			return response()->json([
				'status' => 'Already',
				'seasonal_name' => $check_cal->seasonal_name
			]);
		}

	}
	public function check_not_available_overlap(Request $request){

		$checkin =  date('Y-m-d',$this->helper->custom_strtotime($request->start_date));
		$checkout =  date('Y-m-d',$this->helper->custom_strtotime($request->end_date));

		$days = $this->get_days($checkin,$checkout);

		foreach ($days as $day ) {
			$check_cal = Calendar::where('date',$day)->where('room_id',$request->id)->where('seasonal_name','!=','')
			                     ->where('seasonal_name','!=',$request->edit_season_name)
			                     ->where(function($query) {
				                     $query->where('status', 'Not available')->orWhere('status', 'Reserved');
			                     })->first();

			if(count($check_cal)) {

				return response()->json([
					'status' => 'Already',
					'seasonal_name' => $check_cal->seasonal_name
				]);
			}
		}
	}
	/**
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return false|string
	 */
	public function check_season_name(Request $request){

		$check_cal = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->first();//->where('seasonal_name','!=',$request->edit_season_name)//
		if($check_cal ){
			return json_encode(['status' => 'Already Name']);
		}

		$check_cal = SeasonalPrice::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->first();//->where('seasonal_name','!=',$request->edit_season_name)//
		if($check_cal){
			return json_encode(['status' => 'Already Name']);
		}

	}
	public function fetch_unavailable(Request $request){
		$fetch = Calendar::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->first();
		return json_encode($fetch);
	}
	public function fetch_seasonal(Request $request){
		$fetch = SeasonalPrice::where('room_id',$request->id)->where('seasonal_name',$request->season_name)->first();
		return json_encode($fetch);
	}
	public function delete_seasonal(Request $request){
		$seasonal_id = $request->seasonal_id;
		$seasonal_data = SeasonalPrice::find($seasonal_id);

		$calendar = Calendar::where('room_id',$request->id)
		->where('seasonal_name',$seasonal_data->season_name)
		->where('status', '!=', 'Not available')
		->where('status', '!=', 'Reserved')
		->where('date', '>=', $seasonal_data->start_date)
		->where('date', '<=', $seasonal_data->end_date)
		->delete();
		$seasonal_data->delete();

		return array(
			'status' => 'success',
			'message' => 'Removed Seasonal'
		);
	}
	public function fetch_conflict_seasonal(Request $request){  //get the season data which conflict with the date selected on datepicker
		$fetch = SeasonalPrice::where([
			['room_id',$request->id],
			['start_date', '<=', $request->date],
			['end_date', '>=', $request->date],
		])->first();
		return json_encode($fetch);
	}
	public function fetch_conflict_unavailable(Request $request){       //get the unavailable date range data which conflict with the date selected on datepicker
		$fetch = Calendar::where([
			['room_id',$request->id],
			['status', '!=', 'Available'],
			['date', $request->date],
		])->first();
		return json_encode($fetch);
	}

	public function getpublishlistings(Request $request){
		$data['room_id'] = $request->id;
		$rooms = $data['result']  = Rooms::where('id',$request->id)->first();
		$current_date = date('Y-m-d');
		if($rooms->hasActiveSubscription()){
			$this->helper->flash_message('error',  trans('messages.plan_detail.already_list_subscribe')); // Call flash message function
			return array(
				'plan_types' =>  Membershiptype::orderBy('annual_fee')->get(),
				'listings' => array(),
				'subscribed_listings' => array()

			);
		
		}
		$users = User::find($rooms->user_id);
		$user = User::find(Auth::user()->id);
		$current_membership = $user->previous_membership();
		$data['plan_type'] = Membershiptype::where('Name','=', $current_membership)->first();
		$data['plan_types'] = Membershiptype::orderBy('annual_fee')->get();
		$paymentSubscription = $rooms->paymentSubscription();
		$data['listings'] = [];
		$data['subscribed_listings'] = [];
		// $data['listings'][] = $rooms;
		$listings= Rooms::where('user_id', Auth::user()->id)->get();
		foreach ($listings as $listing) {
			if($listing->steps_count == 0 && !$listing->hasActiveSubscription()) {
				$data['listings'][] = $listing;
			}
		 
		}
		return $data;
	}
	public function post_subscribe_property_paypal(Request $request){

	}
	public function post_subscribe_property(Request $request){
		$listing_array = array();
		$listingIds = array();
		foreach($request->listings as $listing){
			if(in_array($listing['id'], $request->publish_listings)){
				if(isset($listing['membership_type']) && $listing['membership_type']){
					$listing_array[] = array(
						'listing_id' => $listing['id'],
						'membership_type' => $listing['membership_type']
					);
					$listingIds[] = $listing['id'];
				}
				else{
					return array(
						'status' => 'error',
						'listing_id' => $listing['id'],
						'message' => 'Please select membership type!'
					);
				}
			}
		}
	
		$customerArray =  $this->stripe_helper->stripeCustomer($request->id, $request->token['id']);
		
		 $faild_count = 0;
		 $success_count = 0;
			if($customerArray['result'] == 'success'){
				$customer = $customerArray['customer'];
				foreach($listing_array as $key => $roomItem){
					$room = Rooms::find($roomItem['listing_id']);
					$subscription_plan = Membershiptype::find($roomItem['membership_type']);
					$response1 = $this->create_stripe_subscription($room, $customer, $subscription_plan, $request->coupon_code);
					// var_dump($response1);exit;
					if(isset($response1) && $response1['status'] == 'failed') {
						$faild_count ++ ;
					}
					else{
						$success_count ++ ;
					}
				}
			}
			
			return array(
				'status' => 'success',
				'success_count' => $success_count,
				'failed_count' => $faild_count
			);
	}
	public function create_stripe_subscription($room,  $customer, $plan , $coupon_code = null){
			$data = array();
			$subscriptionArray = $this->stripe_helper->stripeRoomSubscriptions($room,$customer,$plan, $coupon_code); 

		if($subscriptionArray['result'] =='success') {
			$subscription = $subscriptionArray['subscription'];

		 
				$room->stripe_id = $customer->id;
				$room->plan_type = $plan->id;
				$room->card_brand = $customer->sources->data[0]->brand;
				$room->card_last_four = $customer->sources->data[0]->last4;
				if(isset($subscription->trial_end)) {
					$room->trial_ends_at = date('Y-m-d H:i:s', $subscription->trial_end);
				}
				$room->subscription_start_date = date('Y-m-d H:i:s');
				$room->subscription_end_date = date('Y-m-d H:i:s', $subscription->current_period_end );
				$room->subscription_days = '365';
				$room->braintree_id = null;
				$room->paypal_email = null;
				$room->status = 'Listed';
				$room->save();

				$approved_status = RoomsApprovedStatus::whereRoomId($room->id)->first();
				if(!$approved_status){
					$approved_status = new RoomsApprovedStatus;
					$approved_status->room_id = $room->id;
				}
				$approved_status->approved_status = '0';
				$approved_status->save();

				$paymentSubscriptions = new SubscribeList();
				$paymentSubscriptions->room_id = $room->id;
				$paymentSubscriptions->name = 'main';
				$paymentSubscriptions->amount = $plan->annual_fee;
				$paymentSubscriptions->host_id = $room->user_id;
				$paymentSubscriptions->stripe_customer_id = $customer->id;
				$paymentSubscriptions->status = 'Subscribe';
				$paymentSubscriptions->stripe_id = $subscription->id;
				$paymentSubscriptions->stripe_plan =$subscription->plan->id;
				$paymentSubscriptions->quantity = $subscription->quantity;
				$paymentSubscriptions->braintree_id = null;
				$paymentSubscriptions->braintree_plan = null;
				if(isset($subscription->trial_end)) {
					$paymentSubscriptions->trial_ends_at = date( 'Y-m-d H:i:s', $subscription->trial_end );
				}
				$paymentSubscriptions->currency_code = 'USD';
				$paymentSubscriptions->subscription_days = '365';
				$paymentSubscriptions->subscription_start_date = date('Y-m-d H:i:s');
				$paymentSubscriptions->subscription_end_date = date('Y-m-d H:i:s', $subscription->current_period_end );
				$paymentSubscriptions->save();

				//Now delete the free subscriptions
				$freeSubscription = SubscribeList::whereStatus('Free')->whereRoomId($room->id)->first();
				if($freeSubscription) {
					$freeSubscription->delete();
				}

				$data['status'] ='success';
		}else{
			$data['status'] ='failed';
			$data['error'] = $subscriptionArray['error'];
		}

		return $data;
	}
}