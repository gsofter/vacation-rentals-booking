<?php

/**
 * Rooms Address Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms Address
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use App\Traits\ModelHelpers;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomsAddress
 *
 * @package App\Models
 * @property int $room_id
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string $postal_code
 * @property string $latitude
 * @property string $longitude
 * @property-read mixed $country_name
 * @property-read mixed $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Front\RoomsAddress whereState($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Front\Rooms $room
 * @property-write mixed $address
 */
class RoomsAddress extends Model
{
	use ModelHelpers;
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'rooms_address';

	public $timestamps = false;

	protected $primaryKey = 'room_id';

	protected $appends = ['country_name','steps_count'];

	protected $fillable = ['city', 'state'];


	/**
	 * Get specific fields by using given id and field name
	 * @param $id
	 * @param $field
	 *
	 * @return mixed
	 */
	public static function single_field($id, $field)
	{
		return RoomsAddress::find($id)->first()->$field;
	}

	/**
	 * If field is null, convert to empty string
	 * @param $value
	 */
	public function setAddressAttribute($value) {
		$this->attributes['address_line_1'] = $this->nullToEmpty( $value);
	}

	/**
	 * If field is null, convert to empty string
	 * @param $value
	 */
	public function setCityAttribute($value) {
		$this->attributes['city'] = $this->nullToEmpty( $value);
	}

	/**
	 * If field is null, convert to empty string
	 * @param $value
	 */
	public function setStateAttribute($value) {
		$this->attributes['state'] = $this->nullToEmpty( $value);
	}

	/**
	 * If field is null, convert to empty string
	 * @param $value
	 */
	public function setPostalCodeAttribute($value) {
		$this->attributes['postal_code'] = $this->nullToEmpty( $value);
	}

	/**
	 * Get country_name by using country code in Country table
	 * @return mixed
	 */
	public function getCountryNameAttribute()
	{
		return Country::where('short_name',$this->attributes['country'])->first()->long_name;
	}

	/**
	 * Get steps_count using sum of rooms_steps_status
	 * @return int|mixed
	 */
	public function getStepsCountAttribute()
    {
        $result = RoomsStepsStatus::find($this->attributes['room_id']);
        if($result)
            return 8 - (@$result->basics + @$result->description + @$result->location + @$result->photos + @$result->pricing + @$result->calendar + @$result->plans + @$result->terms);
        else
            return 8;
    }

    // Join with rooms table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function room()
    {
        return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
    }

}
