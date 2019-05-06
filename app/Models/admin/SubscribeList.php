<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Models\admin\Rooms;

class SubscribeList extends Authenticatable
{
    protected $table = 'subscribe_list';

    public function getUserNameByHostID(){
        $user = User::where('id', $this->host_id)->first();
        return $user->first_name . " " . $user->last_name;
    }

    public function getRoomNameByRoomID(){        
        $room = Rooms::find($this->room_id);
		if($room) return $room->name;
		else return "";       
    }

}