<?php

/**
 * Country Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Country
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Country
 *
 * @property int $id
 * @property string $short_name
 * @property string $long_name
 * @property string $iso3
 * @property string $num_code
 * @property string $phone_code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\RoomsAddress[] $rooms_address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereIso3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereNumCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country wherePhoneCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Country whereShortName($value)
 * @mixin \Eloquent
 */
class Country extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'country';

    public $timestamps = false;

    // Join to rooms_address table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function rooms_address()
    {
        return $this->belongsToMany('App\Models\Front\RoomsAddress');
    }
}
