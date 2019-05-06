<?php

/**
 * Property Type Lang Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Property Type Lang
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PropertyTypeLang
 *
 * @property int $id
 * @property int $property_id
 * @property string $name
 * @property string $description
 * @property string $lang_code
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang wherePropertyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyTypeLang whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PropertyTypeLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'property_type_lang';
   
    
}
