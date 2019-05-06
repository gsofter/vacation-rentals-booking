<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\admin\UsersPhoneNumbers;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','first_name', 'last_name', 'dob', 'user_type' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /////////////////////////// addd new////////////////
    public function getPhoneNumberByUserID(){
        $result = UsersPhoneNumbers::where('user_id', '=', $this->id)->first();
        if($result) return $result->phone_number;
        else return "---";
    }
    /////////////////////////// addd new////////////////
}
