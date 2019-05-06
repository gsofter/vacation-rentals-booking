<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Post_Tags
 *
 * @property int $id
 * @property int $post_id
 * @property int $tag_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Tags whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Tags whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Tags wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Tags whereTagId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Tags whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post_Tags extends Pivot{
    protected $table = 'post_tags';
    
    protected $guarded = [];
}
