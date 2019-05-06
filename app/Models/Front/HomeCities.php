<?php

/**
 * Home Cities Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Home Cities
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HomeCities
 *
 * @property int $id
 * @property string $name
 * @property string $country
 * @property string $image
 * @property-read mixed $country_url
 * @property-read mixed $image_url
 * @property-read mixed $location_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeCities whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeCities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeCities whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HomeCities whereName($value)
 * @mixin \Eloquent
 */
class HomeCities extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'home_cities';

    public $timestamps = false;

    public $appends = ['image_url'];

	/**
	 * @return string
	 */
	public function getImageUrlAttribute()
    {
        $photo_src=explode('.',$this->attributes['image']);
        if(count($photo_src)>1)
        {
            return $src = url('/').'/images/home_cities/'.$this->attributes['image'];
        }
        else
        {
            $options['secure']=TRUE;
            // $options['width']=1300;
            // $options['height']=600;
            $options['crop']    = 'fill';
            return $src=\Cloudder::show($this->attributes['image'],$options);
        }
    }

	/**
	 * @return mixed|null|string|string[]
	 */
	public function getLocationUrlAttribute()
    {
       return $this->clean($this->attributes['name']);
    }

	/**
	 * @return mixed|null|string|string[]
	 */
	public function getCountryUrlAttribute()
    {
        if($this->attributes['country'])
            return $this->clean($this->attributes['country']);
        else
            return 'country'; 
    }

	/**
	 * @param $string
	 *
	 * @return mixed|null|string|string[]
	 */
	public static function clean($string) {
       $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
       $string = preg_replace('/[^A-Za-z0-9\-]/', '-', $string); // Removes special chars.
       return $string; // Replaces multiple hyphens with single one.
    }
}
