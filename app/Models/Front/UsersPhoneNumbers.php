<?php

/**
 * UsersPhoneNumbers Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    UsersPhoneNumbers
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Http\Start\Helpers;
use Illuminate\Database\Eloquent\Model;
use App\Models\Front\Country;
use Propaganistas\LaravelPhone\PhoneNumber;

/**
 * App\Models\UsersPhoneNumbers
 *
 * @property int $id
 * @property int $user_id
 * @property int $phone_code
 * @property string $phone_number
 * @property int|null $otp
 * @property string $status
 * @property-read mixed $default_phone_code
 * @property-read mixed $phone_number_full
 * @property-read mixed $phone_number_nexmo
 * @property-read mixed $phone_number_protected
 * @property-read mixed $phone_number_status_message
 * @property-read mixed $verification_message_text
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers whereOtp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers wherePhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers whereUserId($value)
 * @mixin \Eloquent
 * @property string|null $country_name
 * @property-read \App\Models\Front\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UsersPhoneNumbers whereCountryName($value)
 */
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

    protected $hidden = ['otp'];
    public $timestamps = false;

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user()
    {
    	return $this->belongsTo( User::class);
    }


	/**
	 * Get phone_number_full Attribute
	 * @return mixed
	 */
	public function getPhoneNumberFullAttribute(){
        return $this->attributes['phone_number'];
    }

    // Get phone_number_protected Attribute

	/**
	 * @return mixed|string
	 */
	public function getPhoneNumberProtectedAttribute(){
        $phone_number = $this->attributes['phone_number'];
        if($phone_number != ''){
            $repeat_length = strlen($phone_number)-3 > 0 ? strlen($phone_number)-3 : strlen($phone_number);
            $replace = str_repeat('* ',$repeat_length);
            $phone_number_protected = substr_replace($phone_number, $replace, 0, -3);
            return $phone_number_protected;
        }

	    return '';
    }

    // Get phone_number_nexmo Attribute

	/**
	 * @return mixed
	 */
	public function getPhoneNumberNexmoAttribute(){
        return $this->attributes['phone_number'];
    }

    // Get phone_number_status_message Attribute

	/**
	 * @return array|\Illuminate\Contracts\Translation\Translator|null|string
	 */
	public function getPhoneNumberStatusMessageAttribute(){
        return trans('messages.profile.'.$this->attributes['status']);
    }

    // Get verification_message_text Attribute

	/**
	 * @return string
	 */
	public function getVerificationMessageTextAttribute(){
        return env('SITE_NAME').' '.trans('messages.profile.security_code').': '.$this->attributes['otp'] .'. '.trans('messages.profile.use_this_to_verify');
    }

	/**
	 * @return mixed|string
	 */
	public function getDefaultPhoneCodeAttribute(){
    	$phone_country = Country::where('short_name','US')->first();
    	$phone_code = $phone_country->phone_code;
        return $phone_code;
    }
}
