<?php
namespace App\Models\admin;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\User;

class PropertyManager extends Authenticatable
{
    protected $table = 'property_manager';

	protected $fillable = ['email', 'access_code'];

	protected $appends = ['first_name','last_name','status', 'user_id'];

    public function getUserFirstnameByUserID(){
        return User::find($this->user_id)->first_name;
    }

    public function getUserLastnameByUserID(){
        return User::find($this->user_id)->last_name;
    }
}