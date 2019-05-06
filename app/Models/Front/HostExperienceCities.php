<?php

/**
 * HostExperienceCities Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceCities
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DateTime;
use DateTimeZone;

/**
 * App\Models\HostExperienceCities
 *
 * @property int $id
 * @property string $name
 * @property int $timezone
 * @property string $currency_code
 * @property string $address
 * @property string $latitude
 * @property string $longitude
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\Front\Currency $currency
 * @property-read mixed $timezone_abbr
 * @property-read \App\Models\Timezone $timezone_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereCurrencyCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCities whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HostExperienceCities extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_cities';

    public $timestamps = true;

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
    {
    	$query = $query->where('status', 'Active');
    	return $query;
    }

    // Join with currency table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function currency()
    {
        return $this->belongsTo('App\Models\Front\Currency','currency_code','code');
    }

    // Join with timezone table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function timezone_details()
    {
        return $this->belongsTo('App\Models\Timezone','timezone','id');
    }

	/**
	 * @return string
	 */
	public function getTimezoneAbbrAttribute()
    {
        $timezone = $this->timezone_details->value;
        $dateTime = new DateTime(); 
        $dateTime->setTimeZone(new DateTimeZone($timezone)); 
        $timezone_abbr = $dateTime->format('T');

        return $timezone_abbr;
    }
}
