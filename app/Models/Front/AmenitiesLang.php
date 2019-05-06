<?php

/**
 * Amenities Lang Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Amenities Lang
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AmenitiesLang
 *
 * @property int $id
 * @property int $amenities_id
 * @property string $name
 * @property string $description
 * @property string $lang_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereAmenitiesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AmenitiesLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amenities_lang';
   
    
}
