<?php

/**
 * Our Community Banners Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Our Community Banners
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Request;
use Session;

/**
 * App\Models\OurCommunityBanners
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $link
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBanners withTranslation()
 * @mixin \Eloquent
 */
class OurCommunityBanners extends Model
{
    use Translatable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'our_community_banners';

    public $timestamps = false;

    public $appends = ['image_url'];

    public $translatedAttributes = ['title', 'description'];

	/**
	 * OurCommunityBanners constructor.
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
            return url('/').'/images/our_community_banners/'.$this->attributes['image'];
        }
        else
        {
            $options['secure']=TRUE;
            // $options['width']=800;
            // $options['height']=1500;
        	$options['crop']    = 'fill';
            return $src=\Cloudder::show($this->attributes['image'],$options);
        }
    }

	/**
	 * @return mixed
	 */
	public static function active_all(){
        return OurCommunityBanners::whereStatus('Active')->get();
    }
}
