<?php

/**
 * Page Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Page
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Http\Controllers\PageController;
use Devio\Permalink\Contracts\Permalinkable;
use Devio\Permalink\HasPermalinks;
use Devio\Permalink\Permalink;
use Illuminate\Database\Eloquent\Model;
use Request;
use Session;


/**
 * App\Models\Page
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Page active()
 * @method static \Illuminate\Database\Eloquent\Builder|Page listsTranslations($translationField)
 * @method static \Illuminate\Database\Eloquent\Builder|Page notTranslatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page orWhereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page orWhereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page translated()
 * @method static \Illuminate\Database\Eloquent\Builder|Page translatedIn($locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTranslation($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereTranslationLike($key, $value, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUnder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page withTranslation()
 * @method static \Illuminate\Database\Eloquent\Builder|Page underSection($section)
 * @method static \Illuminate\Database\Eloquent\Builder|Page hasFooter()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property string|null $excerpt
 * @property string $footer
 * @property string|null $under
 * @property string $content
 * @property string|null $image
 * @property int $template_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property false|string $updated_at
 * @property string|null $deleted_at
 * @property-read string $image_url
 * @property-read mixed $meta_description
 * @property-read mixed $meta_title
 * @property null $permalink_parent
 * @property-read mixed $permalink_parent_name
 * @property-read string $route
 * @property-read mixed $url
 * @property \Devio\Permalink\Permalink $permalink
 * @property-read \App\Models\Template $template
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTemplateId($value)
 */
class Page extends Model implements Permalinkable
{
	use HasPermalinks;
	use Translatable;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'pages';
	protected $guarded =  [];
	public $translatedAttributes = [];

	//Enable permalink & seo management
	public $managePermalinks = true;

	/**
	 * Page Category relationship
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function template() {
		return $this->belongsTo( Template::class, 'template_id', 'id' );
	}

	/**
	 * Get the model action.
	 *
	 * @return string
	 */
	public function permalinkAction()
	{
		return PageController::class . '@showStaticPage';
	}

	/**
	 * Get the options for the sluggable package.
	 *
	 * @return array
	 */
	public function slugSource(): array
	{
		return ['source' => 'permalinkable.name'];
	}

	/**
	 * Scope active pages query
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
	{
		return $query->whereStatus('Active');
	}

	/**
	 * Scope show page on footer query
	 * @param $query
	 * @method static \Illuminate\Database\Eloquent\Builder|Page hasFooter()
	 * @return mixed
	 */
	public function scopeHasFooter($query) {
		return $query->whereFooter('Yes');
	}

	/**
	 * Scope show page on section query
	 * @param $query
	 * @param $section
	 * @method static \Illuminate\Database\Eloquent\Builder|Page underSection($section)
	 * @return mixed
	 */
	public function scopeUnderSection($query, $section) {
		return $query->whereUnder($section);
	}

	/**
	 * Checks if page has a parent
	 * @return bool
	 */
	public function hasParent() {
		if(isset($this->permalink->parent_id)) {
			return true;
		}
		return false;
	}

	/**
	 * Gets active pages collection
	 *
	 * @return Page[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function getActive()
	{
		return $this->active()->get();
	}

	/**
	 * Gets the parent permalink name
	 *
	 * @return mixed
	 */
	public function getPermalinkParentNameAttribute() {
		return Page::whereId( $this->permalink->parent->permalinkable_id )->first()->name;
	}

	/**
	 * Get page url
	 * @deprecated use permalink $model->route attribute instead
	 * @return mixed
	 */
	public function getUrlAttribute() {
		return $this->route;
	}

	/**
	 * Gets updated time/date
	 * @return false|string
	 * @property \Carbon\Carbon|null $created_at
	 * @property false|string $updated_at
	 */
	public function getUpdatedAtAttribute(){
		return date(PHP_DATE_FORMAT.' H:i:s',strtotime($this->attributes['updated_at']));
	}

	/**
	 * Gets image url
	 * @return string
	 */
	public function getImageUrlAttribute(){
		//if the image is store locally
		if(substr_count($this->attributes['image'], '.') + 1) {
			return asset('/images/pages/'.$this->attributes['image']);
		}
		//if the image is store in cloudinary
		$options['secure'] =TRUE;
		$options['width']  =800;
		$options['height'] =1500;
		$options['crop']   = 'fill';

		return $src=\Cloudder::show($this->attributes['image'],$options);
	}

	/**
	 * Gets meta title
	 *
	 * @return mixed
	 */
	public function getMetaTitleAttribute() {
		return $this->permalink->seo['meta']['title'];
	}

	/**
	 * Gets Meta Description
	 *
	 * @return mixed
	 */
	public function getMetaDescriptionAttribute() {
		return $this->permalink->seo['meta']['description'];
	}


}
