<?php

/**
 * Theme Settings Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Theme Settings
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ThemeSettings
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThemeSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThemeSettings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ThemeSettings whereValue($value)
 * @mixin \Eloquent
 */
class ThemeSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'theme_settings';

    public $timestamps = false;
}
