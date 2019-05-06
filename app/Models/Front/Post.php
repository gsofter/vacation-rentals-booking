<?php

/**
 * Posts Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Posts
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Http\Controllers\PostController;
use Devio\Permalink\Contracts\Permalinkable;
use Devio\Permalink\HasPermalinks;
use Illuminate\Database\Eloquent\Model;
use Request;
use Session;
use Translatable;
use Carbon\Carbon;

/**
 * App\Models\Posts
 *
 * @property int                                                                  $id
 * @property string                                                               $title
 * @property string                                                               $slug
 * @property string                                                               $excerpt
 * @property string                                                               $content
 * @property string|null                                                          $image
 * @property string                                                               $status
 * @property int                                                                  $featured
 * @property string                                                               $publish_date
 * @property string                                                               $meta_title
 * @property string                                                               $meta_description
 * @property int                                                                  $author_id
 * @property \Carbon\Carbon|null                                                  $created_at
 * @property \Carbon\Carbon|null                                                  $updated_at
 * @property-read \App\Models\Front\User                                                $author
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Category[] $categories
 * @property-read mixed                                                           $featured_date
 * @property-read mixed                                                           $image_url
 * @property-read mixed                                                           $post_excerpt
 * @property-read mixed                                                           $post_image
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[]      $tags
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereAuthorId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereContent( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereExcerpt( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereFeatured( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereImage( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDescription( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublishDate( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereSlug( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereStatus( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle( $value )
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt( $value )
 * @mixin \Eloquent
 * @property null $permalink_parent
 * @property-read string $route
 * @property \Devio\Permalink\Permalink $permalink
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post active()
 */
class Post extends Model implements Permalinkable {
	use HasPermalinks;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'posts';
	protected $guarded = [];

	//public $timestamps = false;

	public $appends = ['image', 'publish_date', 'author_name', 'categories', 'slug'];

	//Enable permalink & seo management
	public $managePermalinks = true;

	/**
	 * Get the model action.
	 *
	 * @return string
	 */
	public function permalinkAction() {
		return PostController::class . '@show';
	}

	/**
	 * Get the options for the sluggable package.
	 *
	 * @return array
	 */
	public function slugSource(): array {
		return [ 'source' => 'permalinkable.title' ];
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function tags() {
		return $this->belongsToMany( Tag::class, 'post_tags', 'post_id', 'tag_id' )->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function categories() {
		return $this->belongsToMany( Category::class, 'post_categories', 'post_id', 'category_id' )->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author() {
		return $this->belongsTo( 'App\Models\Front\User', 'author_id', 'id' );
	}

	/**
	 * Scope active pages query
	 *
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive( $query ) {
		return $query->whereStatus( 'Active' );
	}

	/**
	 * @deprecated
	 * @return \App\Models\Post[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all() {
		return Post::whereStatus( 'Active' )->get();
	}

	/**
	 * @return string
	 */
	public function getPublishDay() {
		$date = new Carbon( $this->publish_date );

		return $date->format( 'j' );
	}

	/**
	 * @return string
	 */
	public function getPublishMonth() {
		$date = new Carbon( $this->publish_date );

		return $date->format( 'M' );
	}

	/**
	 * @return bool|string
	 */
	public function smallExcerpt() {
		$small = substr( $this->excerpt, 0, 144 );

		return $small;
	}

	/**
	 * @return array
	 * @throws \InvalidArgumentException
	 */
	public function related() {
		if ( $this->categories->isNotEmpty() ) {
			$random_category = $this->categories->random();
			$related_post    = $random_category->posts->where( 'slug', '!=', $this->slug )->shuffle()->take( 3 );

			return $related_post;
		} elseif ( $this->tags->isNotEmpty() ) {
			$random_tag   = $this->tags->random();
			$related_post = $random_tag->posts->where( 'slug', '!=', $this->slug )->shuffle()->take( 3 );

			return $related_post;
		} else {
			return [];
		}
	}


	/**
	 * @return string
	 */
	public function getFeaturedDateAttribute() {
		$date = new Carbon( $this->publish_date );

		return $date->format( 'M d, Y' );
	}


	/**
	 * @return string
	 */
	public function getPostExcerptAttribute() {
		return strip_tags( str_limit( $this->attributes['content'], 350, '...' ) );
	}


	/**
	 * @return mixed
	 */
	public function getSlugAttribute() {
		return '';
	}

	/**
	 * Gets image url
	 *
	 * @return string
	 */
	public function getImageAttribute() {
		//if the image is store locally
		if ( substr_count( $this->attributes['image'], '.' ) + 1 ) {
			return asset( '/images/posts/' . $this->attributes['image'] );
		}
		//if the image is store in cloudinary
		$options['secure'] = true;
		$options['width']  = 800;
		$options['height'] = 1500;
		$options['crop']   = 'fill';

		return $src = \Cloudder::show( $this->attributes['image'], $options );
	}
	public function getAuthorNameAttribute (){
		return User::find($this->attributes['author_id'])->full_name;
	}
	public function getPublishDateAttribute (){
		return date('c', strtotime($this->attributes['publish_date']));
	}
	public function getCategoriesAttribute (){
		$post_categories = Post_Categories::where('post_id', $this->id)->pluck('category_id')->toArray();
		return Category::whereIn('id', $post_categories)->get();

		$categories =  $this->belongsToMany( Category::class, 'post_categories', 'post_id', 'category_id' );
		// var_dump($categories);exit;
	}
	/**
	 * Gets meta title
	 *
	 * @return mixed
	 */
	public function getMetaTitleAttribute() {
		if($this->permalink){
			return $this->permalink->seo['meta']['title'];
		}
		else{
			return null;
		}
		
	}

	/**
	 * Gets Meta Description
	 *
	 * @return mixed
	 */
	public function getMetaDescriptionAttribute() {
		if($this->permalink){
			return $this->permalink->seo['meta']['description'];
		}
		else{
			return null;
		}
		
	}
}
