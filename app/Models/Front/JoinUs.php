<?php

/**
 * Join Us Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Join Us
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\JoinUs
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JoinUs whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JoinUs whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\JoinUs whereValue($value)
 * @mixin \Eloquent
 */
class JoinUs extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'join_us';

    public $timestamps = false;
}
