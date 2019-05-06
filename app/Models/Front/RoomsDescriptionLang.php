<?php

/**
 * language description Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    language description
 * @author      Trioangle Product Team
 * @version     1.0
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoomsDescriptionLang
 *
 * @property int $id
 * @property int $room_id
 * @property string $lang_code
 * @property string $name
 * @property string $summary
 * @property string $space
 * @property string $access
 * @property string $interaction
 * @property string $notes
 * @property string $house_rules
 * @property string $neighborhood_overview
 * @property string $transit
 * @property-read mixed $name_original
 * @property-read mixed $steps_count
 * @property-read mixed $summary_original
 * @property-read \App\Models\Front\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereHouseRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereInteraction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereLangCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereNeighborhoodOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereSummary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescriptionLang whereTransit($value)
 * @mixin \Eloquent
 */
class RoomsDescriptionLang extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_description_lang';

    public $timestamps = false;


    protected $appends = ['name_original','summary_original','steps_count'];


    // Join with rooms_address table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function language()
    {
        return $this->belongsTo('App\Models\Front\Language','lang_code','value');
    }

	/**
	 * @return mixed
	 */
	public function getNameOriginalAttribute()
    {
        return $this->attributes['name'];
    }

	/**
	 * @return mixed
	 */
	public function getSummaryOriginalAttribute()
    {
        return $this->attributes['summary'];
    }
    // Get steps_count using sum of rooms_steps_status

	/**
	 * @return int|mixed|string
	 */
	public function getStepsCountAttribute()
    {
        $result = RoomsStepsStatus::find($this->attributes['room_id']);
        
        if($result)
            return 8 - (@$result->basics + @$result->description + @$result->location + @$result->photos + @$result->pricing + @$result->calendar + @$result->plans + @$result->terms);
        else
            return 8;
    }
}
