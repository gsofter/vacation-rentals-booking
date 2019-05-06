<?php

namespace App\Models\admin;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use App\Models\admin\Country;
use Propaganistas\LaravelPhone\PhoneNumber;


class UsersPhoneNumbers extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_phone_numbers';

    protected $fillable = ['user_id', 'country_name', 'phone_number', 'phone_code', 'status'];

    protected $appends = ['phone_number_full', 'phone_number_protected', 'phone_number_nexmo', 'default_phone_code', 'phone_number_status_message', 'verification_message_text'];

    public $timestamps = false;

	
}
