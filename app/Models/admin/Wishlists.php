<?php

namespace App\Models\admin;
use Session;
use App\User;
use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Rooms;
use App\Models\admin\SavedWishlists;

class Wishlists extends Model
{
    protected $table = 'wishlists';
    public $timestamps = false;
    protected $fillable = ['name'];

    public function getUsernameByID(){
        $user = User::find($this->user_id);
		if($user) return $user->first_name . " " . $user->last_name;
		else return "";
    }

    public function getAllRooms(){
        return SavedWishlists::where('list_type','Rooms')
                        ->where('wishlist_id', $this->id)
                        ->count();
    }
	
}
