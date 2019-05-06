<?php

/**
 * HostExperienceProvideItems Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceProvideItems
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceProvideItems
 *
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideItems whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HostExperienceProvideItems extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_provide_items';

    public $timestamps = true;

    protected $appends = ['image_url'];

	/**
	 * @return \Illuminate\Contracts\Routing\UrlGenerator|string
	 */
	public function getImageUrlAttribute()
    {
        $url = '';
        if($this->attributes['image'])
        {
            $photo_src=explode('.',$this->attributes['image']);
            if(count($photo_src)>1)
            {
                $url = url('images/host_experiences/provide_items/'.$this->attributes['image']);
            }
            else
            {
                $options['secure']=TRUE;
                $options['width']=16;
                $options['height']=19;
                $url =\Cloudder::show($this->attributes['image'],$options);
            }
        }
        return $url;
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
    {
    	$query = $query->where('status', 'Active');
    	return $query;
    }
}
