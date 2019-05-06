<?php

/**
 * Profile Picture Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Profile Picture
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProfilePicture
 *
 * @property int $user_id
 * @property string $src
 * @property string|null $photo_source
 * @property-read mixed $email_src
 * @property-read mixed $header_src510
 * @property-read mixed $header_src
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfilePicture wherePhotoSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfilePicture whereSrc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ProfilePicture whereUserId($value)
 * @mixin \Eloquent
 */
class ProfilePicture extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'profile_picture';

    protected $primaryKey = 'user_id';

    public $timestamps = false;

    protected $fillable = ['user_id', 'src', 'photo_source'];

    public $appends = ['header_src', 'email_src'];

    // Get picture source URL based on photo_source

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
	 */
	public function getSrcAttribute()
    {
    	if($this->attributes['photo_source'] == 'Google')
    		$src = str_replace('50', '225', $this->attributes['src']);
        else
    		$src = $this->attributes['src'];
        
        if($src == '')
            $src = url('images/user_pic-225x225.png');
        else if($this->attributes['photo_source'] == 'Local'){
            $photo_src=explode('.',$this->attributes['src']);
            if(count($photo_src)>1)
            {
                $picture_details = pathinfo($this->attributes['src']);
                $src = url('images/users/'.$this->attributes['user_id'].'/'.@$picture_details['filename'].'_225x225.'.@$picture_details['extension']);
            }
            else
            {
                $options['secure']=TRUE;
                $options['height']=225;
                $options['width']=225;
                $src=\Cloudder::show($this->attributes['src'],$options);
            }
        }

        return $src;
    }

    // Get header picture source URL based on photo_source

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
	 */
	public function getHeaderSrcAttribute()
    {
        if($this->attributes['photo_source'] == 'Facebook')
            $src = str_replace('large', 'small', $this->attributes['src']);
        else
            $src = $this->attributes['src'];

        if($src == '')
            $src = url('images/profile_photo.png');
        else if($this->attributes['photo_source'] == 'Local'){
            $photo_src=explode('.',$this->attributes['src']);
            if(count($photo_src)>1)
            {
                $picture_details = pathinfo($this->attributes['src']);
                $src = url('images/users/'.$this->attributes['user_id'].'/'.@$picture_details['filename'].'_225x225.'.@$picture_details['extension']);
            }
            else
            {
                $options['secure']=TRUE;
                $options['height']=225;
                $options['width']=225;
                $src=\Cloudder::show($this->attributes['src'],$options);
            }
        }

        return $src;
    }
    //mobile hearder picture src 

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|mixed|string
	 */
	public function getHeaderSrc510Attribute()
    {
        if($this->attributes['photo_source'] == 'Facebook')
            $src = str_replace('large', 'small', $this->attributes['src']);
        else
            $src = $this->attributes['src'];

        if($src == '')
            $src = url('images/profile_photo.png');
        else if($this->attributes['photo_source'] == 'Local'){
            $photo_src=explode('.',$this->attributes['src']);
            if(count($photo_src)>1)
            {
                $picture_details = pathinfo($this->attributes['src']);
                $src = url('images/users/'.$this->attributes['user_id'].'/'.@$picture_details['filename'].'_510x510.'.@$picture_details['extension']);
            }
            else
            {
                $options['secure']=TRUE;
                $options['height']=510;
                $options['width']=510;
                $src=\Cloudder::show($this->attributes['src'],$options);
            }
        }

        return $src;
    }

	/**
	 * @return mixed|string
	 */
	public function getEmailSrcAttribute(){
        if($this->attributes['photo_source'] == 'Facebook')
            $src = str_replace('large', 'small', $this->attributes['src']);
        else
            $src = $this->attributes['src'];

        $url = SiteSettings::where('name' , 'site_url')->first()->value.'/';

        if($src == '')
            $src = $url.'images/profile_photo.png';
        else if($this->attributes['photo_source'] == 'Local'){
            $photo_src=explode('.',$this->attributes['src']);
            if(count($photo_src)>1)
            {
                $picture_details = pathinfo($this->attributes['src']);
                $src = $url.'images/users/'.$this->attributes['user_id'].'/'.@$picture_details['filename'].'_225x225.'.@$picture_details['extension'];
            }
            else
            {
                $options['secure']=TRUE;
                $options['height']=225;
                $options['width']=225;
                $src=\Cloudder::show($this->attributes['src'],$options);
            }
        }

        return $src;
    }
}
