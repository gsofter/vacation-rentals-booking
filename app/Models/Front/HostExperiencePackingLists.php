<?php

/**
 * HostExperiencePackingLists Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperiencePackingLists
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperiencePackingLists
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingLists whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingLists whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperiencePackingLists whereItem($value)
 * @mixin \Eloquent
 */
class HostExperiencePackingLists extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_packing_lists';

    public $timestamps = false;
}
