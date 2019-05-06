<?php

namespace App\Models\admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Auth;
use Session;
use DB;
use App\User;
use App\Models\admin\Rooms;

class Reviews extends Model
{
	
	protected $table = 'reviews';	

	public function getRoomName(){
		$room = Rooms::find($this->room_id);
		if($room) return $room->name;
		else return "";
	}

	public function getUserFromName(){
		$user = User::find($this->user_from);
		if($user) return $user->first_name . " " . $user->last_name;
		else return "";
	}

	public function getUserToName(){
		$user = User::find($this->user_to);
		if($user) return $user->first_name . " " . $user->last_name;
		else return "";
	}
}
