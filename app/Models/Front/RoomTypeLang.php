<?php

/**
 * Room Type Lang Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Room Type Lang
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoomTypeLang
 *
 * @property int $id
 * @property int $room_type_id
 * @property string $name
 * @property string $description
 * @property string $lang_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereRoomTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTypeLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomTypeLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'room_type_lang';
   
    
}
