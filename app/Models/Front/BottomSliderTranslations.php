<?php

/**
 * Bottom Slider Translations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Bottom Slider Translations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BottomSliderTranslations
 *
 * @property int $id
 * @property int $bottom_slider_id
 * @property string $title
 * @property string $description
 * @property string $locale
 * @property-read \App\Models\Front\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSliderTranslations whereBottomSliderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSliderTranslations whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSliderTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSliderTranslations whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BottomSliderTranslations whereTitle($value)
 * @mixin \Eloquent
 */
class BottomSliderTranslations extends Model
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
