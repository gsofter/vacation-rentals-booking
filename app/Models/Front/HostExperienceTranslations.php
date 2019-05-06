<?php

/**
 * HostExperienceTranslations Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    HostExperienceTranslations
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HostExperienceTranslations
 *
 * @property int $id
 * @property int $host_experience_id
 * @property string $language
 * @property string $language_terms_reviewed
 * @property string $title
 * @property string $tagline
 * @property string $what_will_do
 * @property string $where_will_be
 * @property string $notes
 * @property string $about_you
 * @property string $location_name
 * @property string $special_certifications
 * @property string $additional_requirements
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereAboutYou($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereAdditionalRequirements($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereHostExperienceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereLanguageTermsReviewed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereLocationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereSpecialCertifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereWhatWillDo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HostExperienceTranslations whereWhereWillBe($value)
 * @mixin \Eloquent
 */
class HostExperienceTranslations extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'host_experience_translations';

    public $timestamps = true;
}
