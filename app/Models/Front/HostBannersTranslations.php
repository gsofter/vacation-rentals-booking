<?php

/**
 * Host Banners Translations Model
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

/**
 * App\Models\HostBannersTranslations
 *
 * @property int $id
 * @property int $host_banners_id
 * @property string $title
 * @property string $description
 * @property string $link_title
 * @property string $locale
 * @property-read \App\Models\Front\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereHostBannersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereLinkTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostBannersTranslations whereTitle($value)
 * @mixin \Eloquent
 */
class HostBannersTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description', 'link_title'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language() {
    	return $this->belongsTo('App\Models\Front\Language','locale','value');
    }    
}
