<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Front\Contactus;
use App\Models\Front\PropertyType;
use App\Models\Front\Rooms;
use App\Models\Front\RoomsAddress;
use App\Models\Front\RoomsPrice;
use App\Models\Front\RoomsStepsStatus;
use App\Models\Front\RoomsApprovedStatus;
use App\Models\Front\RoomsDescription;
use Auth;
use Session;


class PostController extends Controller
{
    //contact us
    public function sendcontactinformation(Request $request){
      
        $contactus = Contactus::create($request->all());
        return array(
            'success' => 'true',
            'data' => $contactus
        );
    }
    //Other in list your home
    public function getother(Request $request){
        $name = PropertyType::all();
        return $name;
    }
    //create listing in list your home
    public function createlist(Request $request){
        // saving datas into Rooms
        $rooms = new Rooms;
        
        $address = $request->address;
        $address = explode(',', $address); 
        $address = array_reverse($address);
        
        

        $property_type = PropertyType::find($request->active_home_type)->name;
        $rooms->user_id       = Auth::user()->id;
        // $rooms->name          = $property_type .' in '.$request->hosting['city'] . ' ' . $request->hosting['state']; // Assign temporary name
        // $rooms->sub_name      = $property_type .' in '.$request->hosting['city'];
        $rooms->name = $property_type;
        $rooms->sub_name = $property_type;
        $rooms->property_type = $request->active_home_type; 
        $rooms->room_type     = 1;
        $rooms->accommodates  = $request->active_accommodates;
        $rooms->calendar_type = 'Always';
        $rooms->plan_type = 5;
        $rooms->booking_type = "request_to_book";
        $rooms->save(); 
        //////////////////address//////////////////
        $rooms_address = new RoomsAddress;
        $rooms_address->room_id = $rooms->id;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // $rooms_address->address_line_1 = $request->hosting['street_number'] ? $request->hosting['street_number'].', ' : ''; 
		// $rooms_address->address_line_1.= $request->hosting['route'];
		// $rooms_address->city           = $request->hosting['city'];
		// $rooms_address->state          = $request->hosting['state'];
		// $rooms_address->country        = $request->hosting['country'];
		// $rooms_address->postal_code    = $request->hosting['postal_code'];
		// $rooms_address->latitude       = $request->hosting['latitude'];
		// $rooms_address->longitude      = $request->hosting['longitude'];
        $rooms_address->save();
        
        ///////////// Saving data into rooms_price table
        $rooms_price = new RoomsPrice;
        $rooms_price->room_id = $rooms->id;
        // $rooms_price->currency_code = Session::get('currency');
        $rooms_price->save();

        //////////// Saving data into rooms_steps_status table
        $rooms_status = new RoomsStepsStatus;
        $rooms_status->calendar = 1;
        $rooms_status->room_id = $rooms->id;
        $rooms_status->save();

        ///////////Saving data into rooms_approved_status table
        $rooms_approved_status = new RoomsApprovedStatus;
        $rooms_approved_status->room_id = $rooms->id; 
        $rooms_approved_status->save();

        //////////Saving data into rooms_description table
        $rooms_description = new RoomsDescription;
        $rooms_description->room_id = $rooms->id;
        $rooms_description->save();

        $result = array(
            'status' => 'success',
            'room_data' => $rooms->toArray(),
            'rooms_address' => $rooms_address->toArray(),
            'rooms_price' => $rooms_price->toArray(),
            'rooms_status' => $rooms_status->toArray(),
            'rooms_approved_status' => $rooms_approved_status->toArray(),
            'rooms_description' => $rooms_description->toArray()
        );
        return response()->json($result);

    }
    
}
