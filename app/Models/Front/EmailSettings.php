<?php

/**
 * Email Settings Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Email Settings
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EmailSettings
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailSettings whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailSettings whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailSettings whereValue($value)
 * @mixin \Eloquent
 */
class EmailSettings extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_settings';

    public $timestamps = false;
}
