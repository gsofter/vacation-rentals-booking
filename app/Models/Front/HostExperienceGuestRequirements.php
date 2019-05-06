<?php

/**
 * HostExperienceGuestRequirements Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceGuestRequirements
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceGuestRequirements
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $includes_alcohol
 * @property int|null $minimum_age
 * @property string $allowed_under_2
 * @property string $special_certifications
 * @property string $additional_requirements
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereAdditionalRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereAllowedUnder2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereIncludesAlcohol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereMinimumAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceGuestRequirements whereSpecialCertifications($value)
 * @mixin \Eloquent
 */
class HostExperienceGuestRequirements extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_guest_requirements';

    public $timestamps = false;
}
