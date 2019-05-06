<?php
/**
 * Bed Type Lang Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Bed Type Lang
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\BedTypeLang
 *
 * @property int $id
 * @property int $bed_type_id
 * @property string $name
 * @property string $lang_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereBedTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedTypeLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BedTypeLang extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bed_type_lang';

    //public $timestamps = false;

  
}
