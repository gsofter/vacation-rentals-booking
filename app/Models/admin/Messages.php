<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\User;
use App\Models\admin\Rooms;
use App\Models\admin\ProfilePicture;

class Messages extends Authenticatable
{
    protected $table = 'messages';

    protected $appends = ['created_time','pending_count','archived_count','reservation_count','unread_count','stared_count','all_count','host_check','guest_check'];

    public function getUserImageByID(){
        return  ProfilePicture::where('user_id', $this->user_from)->first();
        // // dd($user);
		// if($user) return $user->src;
		// else return ""; 
    }

    public function getFullUserNameByFromUserID(){
		$user = User::find($this->user_from);
		if($user) return $user->first_name . " " . $user->last_name;
		else return ""; 
	}

}