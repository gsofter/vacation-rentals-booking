<?php

/**
 * Testimonials Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Testimonials
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use App\Models\Front\User;
use Request;
use Session;
use Translatable;
use Carbon\Carbon;
/**
 * App\Models\Testimonials
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $excerpt
 * @property string|null $content
 * @property string $status
 * @property int $featured
 * @property string $slug
 * @property string|null $image
 * @property string $publish_date
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $author_name
 * @property int|null $author_id
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\User|null $author
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereAuthorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereExcerpt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials wherePublishDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Testimonials whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Testimonials extends Model
{

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'testimonials';

	//public $timestamps = false;

	public $appends = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function author(){
		return $this->belongsTo('App\Models\Front\User', 'author_id', 'id');
	}

	/**
	 * @return string
	 */
	public function getImageAttribute() {
		$author = \App\Models\Front\User::where('id',$this->attributes['author_id'])->first();
		$profile_picture = $author->profile_picture->src;
		$image = asset( $profile_picture);

		return $image;
	}

	/**
	 * @return \App\Models\Testimonials[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all(){
		return Testimonials::whereStatus('Active')->get();
	}

}
