<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Auth;
use Session;
use DB;
use DateTime;
use App\User;
use App\Models\admin\Rooms;


class Reservation extends Model
{
	
	protected $table = 'reservation';

	protected $fillable = ['checkin','checkout','code', 'room_id', 'start_time', 'end_time', 'number_of_guests', 'nights', 'per_night', 'subtotal', 'cleaning', 'additional_guest', 'security', 'service', 'host_fee', 'total','coupon_code', 'coupon_amount', 'base_per_night'];
	protected $appends = ['created_at_timer','status_color','receipt_date', 'dates_subject', 'checkin_arrive', 'checkout_depart', 'guests', 'host_payout', 'guest_payout', 'admin_host_payout', 'admin_guest_payout', 'checkin_md', 'checkout_md', 'checkin_mdy', 'checkout_mdy','check_total', 'checkin_site_date_format', 'checkout_site_date_format', 'review_end_date','grand_total','room_category','avablity','checkinformatted','checkoutformatted','status_language','review_link','original_created_at', 'guests_text','address_url','total_additional_charge'];

	public function getUserNameByHostID(){
		$user = User::find($this->host_id);
		if($user) return $user->first_name;
		else return ""; 
	}
	
	public function getFullUserNameByHostID(){
		$user = User::find($this->host_id);
		if($user) return $user->first_name . " " . $user->last_name;
		else return ""; 
	}
	
	public function getUserNameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->first_name;
		else return "";
	}
	
	public function getFullUserNameByUserID(){
		$user = User::find($this->user_id);
		if($user) return $user->first_name . " " . $user->last_name;
		else return ""; 
	}

    public function getRoomNameByRoomID(){        
        $room = Rooms::find($this->room_id);
		if($room) return $room->name;
		else return "";       
    }

}
