<?php

/**
 * Pages Translations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Page Translations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PageTranslations
 *
 * @property int $id
 * @property int $pages_id
 * @property string $name
 * @property string $content
 * @property string $locale
 * @property-read \App\Models\Front\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations wherePagesId($value)
 * @mixin \Eloquent
 * @property int $page_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PageTranslations wherePageId($value)
 */
class PageTranslations extends Model
{
	protected $table = 'page_translations';
    public $timestamps = false;
    protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language() {
    	return $this->belongsTo('App\Models\Front\Language','locale','value');
    }
}
