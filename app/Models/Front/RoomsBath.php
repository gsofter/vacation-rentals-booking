<?php

/**
 * Room Bath Model
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
 * App\Models\RoomsBath
 *
 * @property int $id
 * @property int $room_id
 * @property string $bathroom_name
 * @property string $bathroom_type
 * @property string|null $bathfeature
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBath whereBathfeature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBath whereBathroomName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBath whereBathroomType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBath whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsBath whereRoomId($value)
 * @mixin \Eloquent
 */
class RoomsBath extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_bath';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\RoomsBath[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function getbath()
    {
    	return RoomsBath::get();
    }
}
