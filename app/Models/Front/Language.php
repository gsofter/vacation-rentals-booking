<?php

/**
 * Language Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Language
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Front\Language
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $status
 * @property string $default_language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Language whereDefaultLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Language whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\Language whereValue($value)
 * @mixin \Eloquent
 */
class Language extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'language';

    public $timestamps = false;
}
