<?php


namespace App\Models\admin;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use DateTime;
use DateTimeZone;
use Config;
use DB;
use Auth;
use Session;
use App\User;
use App\Models\admin\Reservation;

use Request;


class Referrals extends Model {

	protected $table = 'referrals';
	protected $fillable = ['user_id', 'friend_id', 'credited_amount', 'status', 'currency_code'];
	protected $appends = ['referrer_name','referrer_full_name','referral_full_name', 'referee_name','referral_count', 'signup_count', 'total_booking_count', 'total_listing_count'];

	public function getUsernameByID(){

		$user = User::find($this->user_id);
		if($user) return $user->first_name . " " . $user->last_name;
		else return "";

	}

	public function countSignup(){

		return Referrals::where('user_id', '=', $this->user_id)->count();	

	}
	
	public function countBooking(){		

		return Reservation::where('user_id', '=', $this->friend_id)->count();
		
	}
	
	public function countListing(){

		$reff = Referrals::where('user_id', '=', $this->user_id)->get();
		
		$friendlst = [];
		foreach($reff as $r){
			array_push($friendlst, $r->friend_id);
		}
		
		$result = DB::table('rooms')
				->join('rooms_approved_status', 'rooms.id', '=', 'rooms_approved_status.room_id')				
				->select('rooms.id')
				->whereIn('rooms.user_id', $friendlst)  
				->where('rooms_approved_status.approved_status', '=', '1')  
				->count();
		return $result;	
		
	}
	
	public function countListingForDetails(){
		
		$result = DB::table('rooms')
				->join('rooms_approved_status', 'rooms.id', '=', 'rooms_approved_status.room_id')				
				->select('rooms.id')
				->where('rooms.user_id', $this->friend_id)  
				->where('rooms_approved_status.approved_status', '=', '1')  
				->count();
		return $result;	
		
	}
	
}
