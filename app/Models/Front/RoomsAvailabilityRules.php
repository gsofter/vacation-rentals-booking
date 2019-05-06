<?php

/**
 * RoomsAvailabilityRules Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    RoomsAvailabilityRules
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use App\Models\Front\Currency;
use Session;

/**
 * App\Models\RoomsAvailabilityRules
 *
 * @property int $id
 * @property int $room_id
 * @property string $type
 * @property int|null $minimum_stay
 * @property int|null $maximum_stay
 * @property string $start_date
 * @property string $end_date
 * @property-read mixed $during
 * @property-read mixed $end_date_formatted
 * @property-read mixed $start_date_formatted
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereMaximumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereMinimumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsAvailabilityRules whereType($value)
 * @mixin \Eloquent
 */
class RoomsAvailabilityRules extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_availability_rules';

    protected $appends = ['during', 'start_date_formatted', 'end_date_formatted'];

    protected $fillable = ['id'];

    public $timestamps = false;

	/**
	 * @return false|string
	 */
	public function getStartDateFormattedAttribute() {
        return date(PHP_DATE_FORMAT, strtotime(@$this->attributes['start_date']));
    }

	/**
	 * @return false|string
	 */
	public function getEndDateFormattedAttribute() {
        return date(PHP_DATE_FORMAT, strtotime(@$this->attributes['end_date']));
    }

	/**
	 * @return string
	 */
	public function getDuringAttribute() {
    	$start_date = date('d M Y', strtotime(@$this->attributes['start_date']));
    	$end_date = date('d M Y', strtotime(@$this->attributes['end_date']));

    	$during = $start_date.' - '.$end_date;
    	return $during;
    }

}
