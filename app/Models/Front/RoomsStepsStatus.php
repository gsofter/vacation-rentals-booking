<?php

/**
 * Rooms Steps Status Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms Steps Status
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoomsStepsStatus
 *
 * @property int $room_id
 * @property string $plans
 * @property string $basics
 * @property string $description
 * @property string $location
 * @property string $photos
 * @property string $pricing
 * @property string $calendar
 * @property string $terms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereBasics($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereCalendar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus wherePlans($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus wherePricing($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsStepsStatus whereTerms($value)
 * @mixin \Eloquent
 */
class RoomsStepsStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_steps_status';

    public $timestamps = false;

    protected $primaryKey = 'room_id';

	/**
	 * @param $attribute
	 * @param $value
	 *
	 * @return \Illuminate\Database\Eloquent\Model|void
	 */
	public function setAttribute($attribute, $value)
   	{
   		if($attribute != 'id')
   		{
   			$this->attributes[$attribute] = $value.'';
   		}
   	}
}
