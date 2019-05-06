<?php

/**
 * Page Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Page
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Dateformats
 *
 * @property int $id
 * @property string $display_format
 * @property string $display_format1
 * @property string $php_format
 * @property string $uidatepicker_format
 * @property string $daterangepicker_format
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereDaterangepickerFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereDisplayFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereDisplayFormat1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats wherePhpFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Dateformats whereUidatepickerFormat($value)
 * @mixin \Eloquent
 */
class Dateformats extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dateformats';
}
