<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Tag
 *
 * @property int                                                              $id
 * @property string                                                           $name
 * @property string                                                           $slug
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model{
    protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function posts(){
	    return $this->belongsToMany( Post::class, 'post_tags', 'tag_id', 'post_id' );
    }
}
