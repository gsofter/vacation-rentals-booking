<?php

/**
 * Room Bed Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Room Type
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;
/**
 * App\Models\RoomsBed
 *
 * @property int $id
 * @property int $room_id
 * @property string $bedroom_name
 * @property string $bedroom_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBed whereBedroomDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBed whereBedroomName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBed whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBed whereRoomId($value)
 * @mixin \Eloquent
 */
class RoomsBed extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_bed';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\RoomsBed[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function getbed()
    {
    	return RoomsBed::get();
    }
}
