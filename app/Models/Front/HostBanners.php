<?php

/**
 * Host Banners Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Host Banners
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;

/**
 * App\Models\HostBanners
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $link_title
 * @property string $link
 * @property-read mixed $image_url
 * @property-read mixed $link_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners translated()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBanners withTranslation()
 * @mixin \Eloquent
 */
class HostBanners extends Model
{
    use Translatable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_banners';

    public $timestamps = false;

    public $appends = ['image_url', 'link_url'];

    public $translatedAttributes = ['title', 'description', 'link_title'];

	/**
	 * HostBanners constructor.
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
            return $src = url('/').'/images/host_banners/'.$this->attributes['image'];
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

	/**
	 * @return string
	 */
	public function getLinkUrlAttribute()
    {
        return url('/').$this->attributes['link'];
    }
    
}
