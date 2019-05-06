<?php

/**
 * Timezone Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Timezone
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Timezone
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Timezone whereValue($value)
 * @mixin \Eloquent
 */
class Timezone extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timezone';
}
