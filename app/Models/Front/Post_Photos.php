<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post_Photos
 *
 * @property-read \App\Models\Post $post
 * @mixin \Eloquent
 */
class Post_Photos extends Model{
    protected $table = "post_photos";
    
    protected $guarded = [];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function post(){
	    return $this->belongsTo( Post::class, 'post_id' );
    }
}
