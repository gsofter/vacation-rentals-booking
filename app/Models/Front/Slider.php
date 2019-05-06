<?php

/**
 * Slider Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Slider
 * @author      Trioangle Product Team
 * @version     0.8
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Slider
 *
 * @property int $id
 * @property string $image
 * @property int $order
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slider whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Slider extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'slider';

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
            return url('/').'/images/slider/'.$this->attributes['image'];
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']='auto';
            $options['height']=800;
            $options['crop']='fill';
            $options['flags']='lossy';
            $options['quality']='auto:low';
            $options['crop']    = 'fill';
            return $src=\Cloudder::show('images/'.$this->attributes['image'],$options);
        }
    }
}
