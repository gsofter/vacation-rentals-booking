<?php

/**
 * HostExperiencePackingListTranslations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperiencePackingListTranslations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperiencePackingListTranslations
 *
 * @property int $id
 * @property int $host_experience_translation_id
 * @property int $host_experience_packing_list_id
 * @property string $item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingListTranslations whereHostExperiencePackingListId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingListTranslations whereHostExperienceTranslationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingListTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingListTranslations whereItem($value)
 * @mixin \Eloquent
 */
class HostExperiencePackingListTranslations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_packing_list_translations';

    public $timestamps = false;
}
