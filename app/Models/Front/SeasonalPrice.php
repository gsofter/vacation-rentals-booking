<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SeasonalPrice
 *
 * @property int $id
 * @property int $room_id
 * @property string $seasonal_name
 * @property string $start_date
 * @property string $end_date
 * @property int $price
 * @property int $week
 * @property int $month
 * @property int $additional_guest
 * @property int $guests
 * @property int $weekend
 * @property int|null $minimum_stay
 * @property string|null $notes
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read string $seasonal_date_range
 * @property-read mixed $seasonal_end_date
 * @property-read mixed $seasonal_start_date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereAdditionalGuest($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereGuests($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereMinimumStay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereSeasonalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereWeek($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SeasonalPrice whereWeekend($value)
 * @mixin \Eloquent
 */
class SeasonalPrice extends Model
{
    //
    protected $table = 'seasonal_prices';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'price','start_date', 'end_date', 'notes', 'is_shared','week','month','additional_guest','guests','weekend','minimum_stay','seasonal_name'];

    // Get Seasonal Start Date

	/**
	 * @return false|string
	 */
	public function getSeasonalStartDateAttribute()
    {
      $start_date = @$this->attributes['start_date'];
      $start = date(PHP_DATE_FORMAT, strtotime($this->attributes['start_date']));

      return $start;
    }

    // Get Seasonal End Date

	/**
	 * @return false|string
	 */
	public function getSeasonalEndDateAttribute()
    {
      $end_date = @$this->attributes['end_date'];
      $end = date(PHP_DATE_FORMAT, strtotime($this->attributes['end_date']));

      return $end;
    }

	/**
	 * Get Seasonal Date Range
	 * @return string
	 *
	 */
    public function getSeasonalDateRangeAttribute() {
		$start_date = $this->attributes['start_date'];
		$end_date = $this->attributes['end_date'];
		return date('m/d/Y', strtotime($this->attributes['start_date'])) . ' - ' . date('m/d/Y', strtotime($this->attributes['end_date']) );
	}
}
