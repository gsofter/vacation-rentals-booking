<?php

/**
 * HostExperienceCategories Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceCategories
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceCategories
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class HostExperienceCategories extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_categories';

    public $timestamps = true;

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
    {
    	$query = $query->where('status', 'Active');
    	return $query;
    }
}
