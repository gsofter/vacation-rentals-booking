<?php

/**
 * UserVerification Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    UserVerification
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Front\UsersPhoneNumbers;

/**
 * App\Models\Front\UsersVerification
 *
 * @property int $user_id
 * @property string $email
 * @property string $facebook
 * @property string $google
 * @property string $linkedin
 * @property string $phone
 * @property string $fb_id
 * @property string $google_id
 * @property string $linkedin_id
 * @property-read mixed $phone_number
 * @property-read mixed $verified_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereFbId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereLinkedinId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\UsersVerification whereUserId($value)
 * @mixin \Eloquent
 */
class UsersVerification extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users_verification';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = ['user_id', 'email'];

    public $appends = ['verified_count', 'phone_number'];

    // Check to show Verification Panel

	/**
	 * @return bool
	 */
	public function show()
    {
        if($this->attributes['email'] == 'no' && $this->attributes['facebook'] == 'no' && $this->attributes['google'] == 'no' && $this->attributes['linkedin'] == 'no'  && $this->getPhoneNumberAttribute() == 'no')
            return false;
        else
            return true;
    }

	/**
	 * @return string
	 */
	public function getPhoneNumberAttribute(){
        $verfied_phone_numbers_count = UsersPhoneNumbers::where('user_id', $this->attributes['user_id'])->where('status', 'Confirmed')->count(); 
        if($verfied_phone_numbers_count > 0){
            return 'yes'; 
        }else{
            return 'no';
        }
    }

    // Verifications Count

	/**
	 * @return int
	 */
	public function verified_count()
    {
        $i = 0;

        if($this->attributes['email'] == 'yes')
            $i += 1;
        if($this->attributes['facebook'] == 'yes') 
            $i += 1;
        if($this->attributes['google'] == 'yes') 
            $i += 1;
        if($this->attributes['linkedin'] == 'yes') 
            $i += 1;
        if($this->getPhoneNumberAttribute() =='yes')
            $i +=1; 

        return $i;
    }

    // Verifications Count

	/**
	 * @return int
	 */
	public function getVerifiedCountAttribute()
    {
        $i = 0;

    	if($this->attributes['email'] == 'yes')
            $i += 1;
        if($this->attributes['facebook'] == 'yes') 
            $i += 1;
        if($this->attributes['google'] == 'yes') 
            $i += 1;
        if($this->attributes['linkedin'] == 'yes') 
            $i += 1;
        if($this->getPhoneNumberAttribute() =='yes')
            $i +=1; 

        return $i;
    }
}
