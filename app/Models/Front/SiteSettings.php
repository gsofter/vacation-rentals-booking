<?php

/**
 * Site Settings Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Site Settings
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Front\SiteSettings
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\SiteSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\SiteSettings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\SiteSettings whereValue($value)
 * @mixin \Eloquent
 */
class SiteSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'site_settings';

    public $timestamps = false;
}
