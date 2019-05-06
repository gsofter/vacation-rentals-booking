<?php

/**
 * Rooms Description Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms Description
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;

/**
 * App\Models\RoomsDescription
 *
 * @property int $room_id
 * @property string $space
 * @property string $access
 * @property string $interaction
 * @property string $notes
 * @property string $house_rules
 * @property string $neighborhood_overview
 * @property string $transit
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereAccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereHouseRules($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereInteraction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereNeighborhoodOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereSpace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsDescription whereTransit($value)
 * @mixin \Eloquent
 */
class RoomsDescription extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_description';

    public $timestamps = false;

    protected $primaryKey = 'room_id';
    protected $fillable = ['space', 'access','interaction','notes','house_rules'];
/*    public function setSpaceAttribute($input){
         $this->attributes['space'] = strip_tags($input);
    }
    public function setAccessAttribute($input){
         $this->attributes['access'] = strip_tags($input);
    }
    public function setInteractionAttribute($input){
         $this->attributes['interaction'] = strip_tags($input);
    }
    public function setNotesAttribute($input){
         $this->attributes['notes'] = strip_tags($input);
    }*/
   /* public function setHouseRulesAttribute($input){
         $this->attributes['house_rules'] = strip_tags($input);
    }*/


	/**
	 * @return mixed|string
	 */
	public function getSpaceAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;
        
       if($lang == 'en')
           return $this->attributes['space'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->space;
           if($name)
               return $name;
           else
               return $this->attributes['space'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getHouseRulesAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;
        
       if($lang == 'en')
           return $this->attributes['house_rules'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->house_rules;
           if($name)
               return $name;
           else
               return $this->attributes['house_rules'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getTransitAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;
        
       if($lang == 'en')
           return $this->attributes['transit'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->transit;
           if($name)
               return $name;
           else
               return $this->attributes['transit'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getAccessAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

       if($lang == 'en')
           return $this->attributes['access'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->access;
           if($name)
               return $name;
           else
               return $this->attributes['access'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getInteractionAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

       if($lang == 'en')
           return $this->attributes['interaction'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->interaction;
           if($name)
               return $name;
           else
               return $this->attributes['interaction'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getNotesAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

       if($lang == 'en')
           return $this->attributes['notes'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->notes;
           if($name)
               return $name;
           else
               return $this->attributes['notes'];
       }
   }

	/**
	 * @return mixed|string
	 */
	public function getNeighborhoodOverviewAttribute()
   {
       $default_lang = Language::where('default_language',1)->first()->value;

       $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

       if($lang == 'en')
           return $this->attributes['neighborhood_overview'];
       else {
           $name = @RoomsDescriptionLang::where('room_id', $this->attributes['room_id'])->where('lang_code', $lang)->first()->neighborhood_overview;
           if($name)
               return $name;
           else
               return $this->attributes['neighborhood_overview'];
       }
   }

}
