<?php

/**
 * HostExperienceProvideTranslations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceProvideTranslations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceProvideTranslations
 *
 * @property int $id
 * @property int $host_experience_translation_id
 * @property int $host_experience_provide_id
 * @property string $name
 * @property string $additional_details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideTranslations whereAdditionalDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideTranslations whereHostExperienceProvideId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideTranslations whereHostExperienceTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvideTranslations whereName($value)
 * @mixin \Eloquent
 */
class HostExperienceProvideTranslations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_provide_translations';

    public $timestamps = false;
}
