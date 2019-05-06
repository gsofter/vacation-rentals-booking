<?php

/**
 * HostExperienceLocation Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceLocation
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceLocation
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $location_name
 * @property string $address_line_1
 * @property string $address_line_2
 * @property string $city
 * @property string $state
 * @property string|null $country
 * @property string $postal_code
 * @property string $latitude
 * @property string $longitude
 * @property string $directions
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereAddressLine1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereDirections($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceLocation whereState($value)
 * @mixin \Eloquent
 */
class HostExperienceLocation extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_location';

    public $timestamps = false;
}
