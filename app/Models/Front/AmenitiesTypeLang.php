<?php

/**
 * Amenities Type Lang Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Amenities Type Lang
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AmenitiesTypeLang
 *
 * @property int $id
 * @property int $amenities_type_id
 * @property string $name
 * @property string $description
 * @property string $lang_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereAmenitiesTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesTypeLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AmenitiesTypeLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amenities_type_lang';
   
    
}

