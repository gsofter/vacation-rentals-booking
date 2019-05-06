<?php

/**
 * HostExperienceCalendar Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceCalendar
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceCalendar
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $date
 * @property int $price
 * @property int $spots_booked
 * @property string $spots
 * @property string $source
 * @property string|null $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $spots_array
 * @property-read mixed $spots_left
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereSpots($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereSpotsBooked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCalendar whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HostExperienceCalendar extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_calendar';

    protected $fillable = ['host_experience_id', 'date', 'price', 'status'];

    public $timestamps = true;

    public function host_experience()
    {
    	$this->belongsTo('App\Models\HostExperiences','host_experience_id','id');
    }

	/**
	 * @return int
	 */
	public function getSpotsLeftAttribute()
    {
    	$spots_booked  = @$this->attributes['spots_booked'];
	    $total_spots = $this->host_experience->number_of_guests;
	    $spots_left = ($total_spots - $spots_booked);
	    $spots_left = $spots_left > 0 ? $spots_left : 0;
    	return $spots_left;
    }

	/**
	 * @return array
	 */
	public function getSpotsArrayAttribute()
    {
        $spots_array = explode(',', @$this->attributes['spots']);
        $spots_array = array_map('intval', $spots_array);
        return $spots_array;
    }

}
