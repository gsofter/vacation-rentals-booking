<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Session;
use App\Models\Front\Rooms;
use App\Models\admin\Timezone;
use App\Models\admin\Language;
use App\Models\admin\BedType;
use App\Models\admin\Subscription;
use App\Models\admin\PropertyType;
use App\Models\admin\RoomType;
use App\Models\Front\RoomsDescriptionLang;
use App\Models\Front\Country;
use App\Models\Front\Amenities;
use App\Models\Front\RoomsPhotos;
use App\Models\Front\Membershiptype;
use App\Models\Front\SubscribeList;



class RoomsController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth:admin');
       
        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
      
    }

///////////////////////////////////////////////////////////////////////////////////
////////////////////////////// Properties Manage Action ///////////////////////////
///////////////////////////////////////////////////////////////////////////////////

    /**
     * @des: Manage  rooms 
     * @param: 
     * @return: view-> admin/rooms/rooms.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function rooms()
    {           
        $data = Rooms::get();        
        return view('admin/rooms/index', compact('data'));
        
    }

    /**
     * @des: add  rooms 
     * @param: rooms Add Form Data
     * @return: view-> admin/rooms/add.blade.php  ///////  view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/12 
    */
    public function add(Request $request)
	{
		if(!$_POST){			
            
			return view('admin/rooms/add');
		}else{
                 
           
            $room                   = new Rooms;
            
            

            $room->save();

            $uid = $room->id;

            
            return redirect()->route('admin.rooms')
                ->with('success','New Room Added!');
			
		}
    }
    
   
    /**
     * @des: update  rooms 
     * @param: rooms Edit Form Data
     * @return: view-> admin/rooms/edit.blade.php  ///////   view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function update(Request $request)
	{
		if(!$_POST){
            $room                   = Rooms::find($request->id);
            $membership_types       = Membershiptype::all();
            $stripe_coupones        = \Stripe\Coupon::all();
            $stripe_coupones        = ($stripe_coupones->data);
            // dd($stripe_coupones);
			return view('admin/rooms/edit', compact('room', 'membership_types', 'stripe_coupones'));
		}else{
            // dd($request);
            if(isset($request->action) && $request->action == 'updatemembership'){

                $subscribe_list = SubscribeList::where('room_id',$request->id)->first();
                $room = Rooms::find($request->id);
              
                if($subscribe_list->stripe_id) {
                    $subscription = \Stripe\Subscription::retrieve($subscribe_list->stripe_id);
                    if($subscription){
                        $sub_id = $subscription->id;
                        //    dd(strtotime($request->extend_date));
                            if($room->stripe_id)\Stripe\Subscription::update($sub_id, [
                                 'trial_end' => strtotime($request->extend_date),
                                  'prorate' => false,
                              ]);
                    }
                //     $subscribe_list_id = SubscribeList::where('stripe_id',$subscribe_list->stripe_id)->first();
                
                // $subscription_extend  = SubscribeList::find($subscribe_list_id->id);
               
                }
                
             
          
                $subscribe_list->subscription_end_date = date('Y-m-d', strtotime($request->extend_date));
           
                $subscribe_list->save();
       
                 //rooms update subscription details
       
                $room = Rooms::find($request->id);
           
                $room->subscription_end_date = date('Y-m-d', strtotime($request->extend_date));
                $room->save();
                return redirect()->route('admin.rooms') 
                ->with('success','Room membership updated!');
            }
            else{
                $room                   = Rooms::find($request->id);
                $room->status           = $request ->status;
                $room->plan_type           = $request ->plan_type;
                $room->save();
                return redirect()->route('admin.rooms') 
                    ->with('success','Room Updated!');
            }
            
		}
		
    }

    /**
     * @des: delete  room 
     * @param: room delete id
     * @return: view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function room_delete(Request $request){
        // dd(Rooms::find($request->did));
        $room = Rooms::find($request->did);
        $room->Delete_All_Room_Relationship();
        // dd($room);
        return redirect()->route('admin.rooms') 
                ->with('success','Room Deleted!');
    }
    

    /**
     * @des: public/unpublic  room 
     * @param: room id
     * @return: view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function publish($id){        
        $room = Rooms::find($id);
		$prev = $room->status;
		switch($prev){
			case "Listed":
				Rooms::where('id',$id)->update(['status'=>'Unlisted']);
				break;
			case "Unlisted":
				Rooms::where('id',$id)->update(['status'=>'Listed']);
				break;
			default:
				//null
				break;
		}		
		return back()->with('success', 'Room Publhsh Updated Successfully');
    }
    
    /**
     * @des: popular/unpopular  room 
     * @param: room id
     * @return: view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function popular($id){
       
		$prev = Rooms::find($id)->popular;

		if($prev == 'Yes')
			Rooms::where('id',$id)->update(['popular'=>'No']);
		else
			Rooms::where('id',$id)->update(['popular'=>'Yes']);

            return back()->with('success', 'Room Popular Updated Successfully');
		
    }
    
    /**
     * @des: recommended/unrecommended  room 
     * @param: room id
     * @return: view-> admin/rooms/index.blade.php
     * @dev: Artemova
     * @date:2019/10/13 
    */
    public function recommended($id){ 
        $room           = Rooms::find($id);
		$user_check     = User::find($room->user_id);
		if($room->status != 'Listed')
		{			
            return back()->with('error', 'Not able to recommend for unlisted listing');
		}
		if($user_check->status != 'Active')
		{			
            return back()->with('error', 'Not able to recommend for Not Active users');
		}

		$prev = $room->recommended;

		if($prev == 'Yes')
			Rooms::where('id', $id)->update(['recommended'=>'No']);
		else
			Rooms::where('id', $id)->update(['recommended'=>'Yes']);
		
        return back()->with('success', 'Room Recommend Updated Successfully');
    }
    



}