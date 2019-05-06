<?php

/**
 * HostExperienceProvides Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceProvides
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceProvides
 *
 * @property int $id
 * @property int $host_experience_id
 * @property int $host_experience_provide_item_id
 * @property string $name
 * @property string $additional_details
 * @property-read \App\Models\HostExperienceProvideItems $provide_item
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvides whereAdditionalDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvides whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvides whereHostExperienceProvideItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvides whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceProvides whereName($value)
 * @mixin \Eloquent
 */
class HostExperienceProvides extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_provides';

    public $timestamps = false;

	/**
	 * @param bool $ordered
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function newQuery($ordered = true)
    {
        $query = parent::newQuery();

        if (empty($ordered)) {
            return $query;
        }

        return $query->orderBy('host_experience_provide_item_id', 'asc');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function provide_item()
    {
    	return $this->belongsTo('App\Models\HostExperienceProvideItems','host_experience_provide_item_id','id');
    }
}
