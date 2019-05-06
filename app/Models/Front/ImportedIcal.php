<?php

/**
 * Imported iCal Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Imported iCal
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ImportedIcal
 *
 * @property int $id
 * @property int $room_id
 * @property string $url
 * @property string $name
 * @property string $last_sync
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImportedIcal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImportedIcal whereLastSync($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImportedIcal whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImportedIcal whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ImportedIcal whereUrl($value)
 * @mixin \Eloquent
 */
class ImportedIcal extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'imported_ical';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'url', 'name', 'last_sync'];
}
