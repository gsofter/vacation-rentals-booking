<?php

/**
 * RoomsPriceRules Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    RoomsPriceRules
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
 * App\Models\RoomsPriceRules
 *
 * @property int $id
 * @property int $room_id
 * @property string|null $type
 * @property int $period
 * @property int $discount
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules type($type)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules wherePeriod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPriceRules whereType($value)
 * @mixin \Eloquent
 */
class RoomsPriceRules extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_price_rules';

    protected $appends = [];

    protected $fillable = ['period', 'discount'];

    public $timestamps = false;

	/**
	 * @param $query
	 * @param $type
	 *
	 * @return mixed
	 */
	public function scopeType($query, $type) {
      $query = $query->where('type', $type);
      return $query;
    }

}
