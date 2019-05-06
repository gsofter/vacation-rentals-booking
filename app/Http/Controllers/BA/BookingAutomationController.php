<?php

namespace App\Http\Controllers\BA;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Http\Helper\BookingHelper;
use App\Models\Front\Rooms;
use App\Models\Front\RoomsPrice;
use App\Models\Front\Currency;
use App\Models\Front\Calendar;
use App\Models\Front\Reservation;

use Auth;

class BookingAutomationController extends Controller
{

    /*
    * prop_id : 77044
    * ota_password : 123456
    * api_key : S1RJCA5214KB8355
    * prop_key : DEJQ6XIT5IIAPXTB
    */
    public function createAccount(Request $request) {
        $currentUser = User::find(Auth::id());
        $currentUser->prop_id = $request->propid;
        $currentUser->ota_password = $request->otapassword;
        $currentUser->api_key = $request->apikey;
        $currentUser->prop_key = $request->propkey;
        $currentUser->save();

        echo "Successfully created!";
    }

    public function getPropId()
    {
        $user = User::find(Auth::id());
        echo $user->prop_id;
    }
 
    public function getCredential()
    {
        $user = User::find(Auth::id());

        if(!isset($user->prop_id) || $user->prop_id == ''){
            echo "Booking Acccount Credential not registered";
        }
        else
        {
            echo "prop_id: [".$user->prop_id."] ota_password: [".$user->ota_password."] api_key: [".$user->api_key."] prop_key : [".$user->prop_key."]";
        }
    }
 
    public function getBaCredential()
    {
        $user = User::find(Auth::id());

        if(!isset($user->prop_id) || $user->prop_id == ''){
            return json_encode(['success' => false]);
        }
        else
        {
            $data = [
                'prop_id' => $user->prop_id,
                'ota_password' => $user->ota_password,
                'api_key' => $user->api_key,
                'prop_key' => $user->prop_key
            ];

            return json_encode(['success' => true, 'data' => $data]);
        }
    }

    public function getPricing(Request $request, $roomid) {
        $roomid = "176579";


        $response = BookingHelper::getProperty();

        $decode_res = json_decode($response, true);
         
        $props = [];
        $props[0] = $decode_res['getProperty'][0];


        $rooms = $props[0]['roomTypes'];

        $room_for_id = null;
        foreach ($rooms as $key => $room) {
            # code...
            if($room['roomId'] == $roomid)
            {
                $room_for_id = $room;
            }
        }

        $resData = null;
        $resData['default_currency'] = $props[0]['currency'];
        $resData['charge_per_night'] = $room_for_id['minPrice'] * 1;
        $resData['weekly_price'] = $room_for_id['minPrice'] * 7;
        $resData['monthly_price'] = $room_for_id['minPrice'] * 30;
        $resData['monthly_price'] = $room_for_id['minPrice'] * 2;
        $resData['cleaning_fee'] = $room_for_id['cleaningFee'];
        $resData['tax_rate'] = $room_for_id['taxPercent'];
        $resData['max_occupants'] = $room_for_id['maxPeople'];
        $resData['base_occupants'] = 2;

        $data = [
            'default_currency' => '',
            'charge_per_night' => '',
            'weekly_price' => '',
            'monthly_price' => '',
            'weekend_price' => '',
            'weekend_days' => '',
            'minimum_nights' => '',
            'cleaning_fee' => '',
            'cleaning_fee_calc' => '',
            'tax_rate' => '',
            'refund_damage_fee' => '',
            'max_occupants' => 15,
            'base_occupants' => 5,
            'charges_per_guest' => 10,
            'charges_per_guest' => 5,
        ];

        dd($resData);
        return $resData;
    }

    /*
    *
    * Get property data of the current user
    */    
    public function getProperty() {
        $response = BookingHelper::getProperty();

        $decode_res = json_decode($response, true);
         
        $props = [];
        $props[0] = $decode_res['getProperty'][0];


        $rooms = $props[0]['roomTypes'];

        $room_for_id = $rooms[0];
        foreach ($rooms as $key => $room) {
            # code...
            if($room['roomId'] == "176579")
            {
                $room_for_id = $room;
            }
        }

        dd($props[0]);
    }

    /*
    *
    * Get room data for roomid
    *
    */
    public function getRoom($room_id) {

        $room_id = "176579";
        $response = BookingHelper::getProperty();

        $decode_res = json_decode($response, true);
         
        $props = [];
        $props[0] = $decode_res['getProperty'][0];


        $rooms = $props[0]['roomTypes'];

        $room_for_id = null;
        foreach ($rooms as $key => $room) {
            # code...
            if($room['roomId'] == $room_id)
            {
                $room_for_id = $room;
            }
        }
        
        // $room_for_id['charge_per_night'] = $props[0]['currency'];
        dd($room_for_id);
        return $room_for_id;
    }

    /*
    *
    * Get availability
    *
    */
    public function getAvailability($roomid, $start, $end){
        $response = BookingHelper::getAvailability($start, $end);

        $decode_res = json_decode($response, true);

        $room_data = null;
        foreach ($decode_res as $key => $value) {
            # code...
            if($key == $roomid)
            {
                $room_data = $value;
                dd($value);
            }
        }
        
        return $room_data;
    }

    public function getRoomDates($room_id){
        $response = BookingHelper::getRoomDates($room_id);

        //dd($decode_res);
        return $response;
    }

    public function getRoomStatus(Request $request){
        // echo "string";
        // $rooms = Rooms::find();
        $curreny = Currency::all();

        $firstroom = Rooms::first();
        $firstroom_price = $firstroom->room_price;
        $room_price = RoomsPrice::where(['room_id' => 10001])->get()->first();

        $room_price->night = 0;
        $room_price->week = 0;
        $room_price->month = 0;
        $room_price->cleaning = 0;
        $room_price->tax = 0;
        $room_price->weekend = 0;
        $room_price->save();

        dd($room_price);
    }


    public function getBookings()
    {
        $bookings = BookingHelper::getBookings();
        dd($bookings);
    }

    public function update(){
        $response = BookingHelper::getProperty();
        $decode_res = json_decode($response, true);
        $props = [];
        $props[0] = $decode_res['getProperty'][0];
        $rooms_ba = $props[0]['roomTypes'];

        $rooms_vr = Rooms::where(['user_id' => Auth::id()])->get();
        //dd($rooms_vr);
        // dd($rooms_ba[0]);
        for ($id=0; $id < count($rooms_ba); $id++) {
            $rba = $rooms_ba[$id];
            // $rvr = $rooms_vr[$id];
            // dd($rba['name']);
            $rvr = Rooms::where(['ba_roomid' => $rba['roomId'], 'user_id' => Auth::id()])->get()->first();
            // dd($rvr);
            if($rvr == null) continue;
            $room_price = RoomsPrice::where(['room_id' => $rvr->id])->get()->first();
            $room_price->night = $rba['minPrice'];
            $room_price->week = $rba['minPrice'] * 7;
            $room_price->month = $rba['minPrice'] * 30;
            $room_price->weekend = $rba['minPrice'] * 2;
            $room_price->cleaning = $rba['cleaningFee'];
            $room_price->tax = $rba['taxPercent'];
            $room_price->save();                  
        }

        
        //Update bookings
        $bookings = BookingHelper::getBookings();

        foreach ($bookings as $key => $booking) {
            # add booking to database here code...

            $start_time = strtotime($booking['firstNight']);
            $last_time = strtotime($booking['lastNight'].'+ 1 days');

            $start_date = date('Y-m-d',$start_time);
            $last_date = date('Y-m-d',$last_time);

            $begin = new \DateTime( $start_date );
            $end = new \DateTime( $last_date );

            $rvr = Rooms::where(['ba_roomid' => $booking['roomId'], 'user_id' => Auth::id()])->get()->first();

            if($rvr == null) continue;

            // dd($rvr);

            $requestid = $rvr['id'];
            echo "requestid " . $requestid .PHP_EOL;
            
            $seasonal_name = $booking['guestFirstName'].$booking['guestName'];
            echo "seasonal_name " . $seasonal_name.PHP_EOL;

            $guests =  $booking['numAdult'] + $booking['numChild'];
            echo "guests " . $guests;

            $notes = $booking['notes'];
            echo "notes " .PHP_EOL;

            $price = $booking['price'];
            for($date = $begin; $date <= $end; $date->modify('+1 day')){
                $reservation = [
                    'room_id' => $requestid,
                    'date'    => $date,
                    'seasonal_name'    => $seasonal_name,
                    'start_date' => $start_date,
                    'end_date' => $last_date,
                    'notes'   => $notes,
                    'guests'   => $guests,
                    'source' => 'Import',
                    'price' => $price,
                    'status' => "Not available"
                ];
                // dd($reservation);
                Calendar::updateOrCreate(['room_id' => $requestid, 'date' => $date], $reservation);
            }

            $reserveid = $booking['bookId'];
            $reserveprice = $booking['price'];
            $reservation = [                                                        
                            'checkin' => $begin,
                            'checkout' => $end,
                            'nights'   => $reserveprice,
                            'number_of_guests'   => $guests,                                                     
                        ];


            //Reservation::updateOrCreate(['id' => $reserveid], $reservation);

            //echo $calendar = Calendar::where(['room_id' => $requestid, 'date' => $start_date])->get()->first();
            // dd($calendar);
        }

        return $bookings;
        dd($bookings);
    }

    public function setBaRoomId(Request $request){
        // dd($id);
        $temp = Rooms::where(['ba_roomid' => $request['ba_roomid']])->get()->first();
        if($temp != null)
            return array('success' => false, 'message' => 'BA id already exists!');
        $roomid = $request['roomid'];
        $room = Rooms::where(['id' => $roomid, 'user_id' => Auth::id()])->get()->first();
        $room->ba_roomid = $request['ba_roomid'];
        $room->save();

        return array('success' => true, 'message' => 'success');
    }

    /*Get the ba_roomid for the selected room*/
    public function getBaRoomId(Request $request){
        $roomid = $request['roomid'];

        $correspondRoom = Rooms::where(['id' => $roomid, 'user_id' => Auth::id()])->get()->first();

        // dd($correspondRoom);
        
        if(!isset($correspondRoom->ba_roomid ) || $correspondRoom->ba_roomid == '')
        {
            // dd('aa');
            return json_encode(['success' => false]);
            
        } 
        else
        {
            // dd('bb');
            return ['success' => true, "ba_roomid" => $correspondRoom->ba_roomid];

        }

        // echo "asdf";
    }

    /*Get listings that has ba_roomid*/
    public function getListingsHasBa(){
        $data['rooms_list'] = Rooms::user()->get();

        return array(
            'success' => true, 
            'data' => $data['rooms_list']
        );

        $lists = [];
        foreach ($data['rooms_list'] as $key => $room) {
            # code...
            if(isset($room->ba_roomid) && ($room->ba_roomid) != '')
                array_push($lists, $room);

        }

        dd($lists);
        return array(
            'success' => true, 
            'data' => $lists
        );
    }

    /**/
}

