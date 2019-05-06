<?php

/**
 * Metas Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Metas
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Metas
 *
 * @property int $id
 * @property string $url
 * @property string $title
 * @property string|null $meta_h1
 * @property string $description
 * @property string $keywords
 * @property int $page_id
 * @property string|null $meta_image
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereMetaH1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereMetaImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Metas whereUrl($value)
 * @mixin \Eloquent
 */
class Metas extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'metas';

    public $timestamps = false;
}
