<?php

/**
 * HostExperiencePhotos Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperiencePhotos
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperiencePhotos
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $name
 * @property-read mixed $image_url
 * @property-read mixed $og_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePhotos whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePhotos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePhotos whereName($value)
 * @mixin \Eloquent
 */
class HostExperiencePhotos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_photos';

    public $timestamps = false;

    protected $appends = ['image_url','og_image'];

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getImageUrlAttribute()
    {
        $url = '';
        $filename = @$this->attributes['name'];
        if($filename)
        {
            $photo_src=explode('.',$filename);
            if(count($photo_src)>1)
            {
                $url = url('images/host_experiences/'.$this->attributes['host_experience_id'].'/'.$filename);
            }
            else
            {
                $options['secure']=TRUE;
                $options['width']=480;
                $options['height']=720;
                $url =\Cloudder::show($filename,$options);
            }
        }
    	return $url;
    }

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getOgImageAttribute()
    {
        $url = '';
        $filename = $this->attributes['name'];
        $picture_details = pathinfo($this->attributes['name']);

        $url = '';
        $filename = @$this->attributes['name'];
        if($filename)
        {
            $photo_src=explode('.',$filename);
            if(count($photo_src)>1)
            {
                $url = url('images/host_experiences/'.$this->attributes['host_experience_id'].'/'.@$picture_details['filename'].'_853x1280.'.@$picture_details['extension']);
                if(!file_exists($url))
                {
                    $url = url('images/host_experiences/'.$this->attributes['host_experience_id'].'/'.$filename);
                }
            }
            else
            {
                $options['secure']=TRUE;
                $options['width']=853;
                $options['height']=1280;
                $url =\Cloudder::show($filename,$options);
            }
        }
        return $url;
    }
}
