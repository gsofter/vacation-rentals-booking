<?php

/**
 * Fees Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Fees
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fees
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fees whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fees whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Fees whereValue($value)
 * @mixin \Eloquent
 */
class Fees extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fees';

    public $timestamps = false;
}
