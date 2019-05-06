<?php

/**
 * Bottom Slider Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Bottom Slider
 * @author      Trioangle Product Team
 * @version     0.8
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Request;
use Session;

/**
 * App\Models\BottomSlider
 *
 * @property int $id
 * @property string $image
 * @property string $title
 * @property string $description
 * @property int $order
 * @property string $status
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSlider withTranslation()
 * @mixin \Eloquent
 */
class BottomSlider extends Model
{
    use Translatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bottom_slider';

    public $timestamps = false;

    public $appends = ['image_url'];
    
    public $translatedAttributes = ['title', 'description'];

	/**
	 * BottomSlider constructor.
	 *
	 * @param array $attributes
	 */
	public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        if(Request::segment(1) == 'admin_url') {
            $this->defaultLocale = 'en';
        }
        else {
            $this->defaultLocale = Session::get('language');
        }
    }

	/**
	 * @return string
	 */
	public function getImageUrlAttribute()
    {
        $photo_src=explode('.',$this->attributes['image']);
        if(count($photo_src)>1)
        {
            return $src = url('/').'/images/bottom_slider/'.$this->attributes['image'];
        }
        else
        {
            $options['secure']=TRUE;
            // $options['width']=1500;
            // $options['height']=800;
            $options['crop']    = 'fill';
            return $src=\Cloudder::show($this->attributes['image'],$options);
        }
    }
}
