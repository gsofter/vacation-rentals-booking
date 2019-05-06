<?php

/**
 * Our Community Banners Translations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Our Community Banners Translations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OurCommunityBannersTranslations
 *
 * @property int $id
 * @property int $our_community_banners_id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property-read \App\Models\Front\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBannersTranslations whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBannersTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBannersTranslations whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBannersTranslations whereOurCommunityBannersId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OurCommunityBannersTranslations whereTitle($value)
 * @mixin \Eloquent
 */
class OurCommunityBannersTranslations extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language() {
    	return $this->belongsTo('App\Models\Front\Language','locale','value');
    }    
}
