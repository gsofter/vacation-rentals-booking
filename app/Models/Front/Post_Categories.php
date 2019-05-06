<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * App\Models\Post_Categories
 *
 * @property int $id
 * @property int $post_id
 * @property int $category_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Categories whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Categories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Categories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Categories wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post_Categories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post_Categories extends Pivot{
    protected $table = 'post_categories';
    protected $guarded = [];
}
