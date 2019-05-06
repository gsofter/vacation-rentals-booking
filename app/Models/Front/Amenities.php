<?php

/**
 * Amenities Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Amenities
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Session;
use Request;
use Cloudder;
/**
 * App\Models\Amenities
 *
 * @property int $id
 * @property int $type_id
 * @property string $name
 * @property string $description
 * @property string $icon
 * @property string $status
 * @property-read \App\Models\Front\AmenitiesType $amenities_type
 * @property-read mixed $image_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities activeType()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Amenities whereTypeId($value)
 * @mixin \Eloquent
 */
class Amenities extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amenities';

    public $timestamps = false;

    public $appends = ['image_url'];
    const SESSION_LANG = 'EN';

	/**
	 * @return string
	 */
	public function getImageUrlAttribute()
    {
        $photo_src=explode('.',$this->attributes['icon']);
        
        // if(count($photo_src)>1)
        // {
        //     return $src = url('/').'/images/amenities/'.$this->attributes['icon'];
        // }
        // else
        // {
            $options['secure']=TRUE;
            $options['width']=20;
            $options['height']=20;
            $options['crop']    = 'fill';
            // return '';
            return $src=\Cloudder::show('/images/amenities/'.$photo_src[0],$options);
        // }
    }
    // Get all Active status records

	/**
	 * @return \App\Models\Amenities[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return Amenities::whereStatus('Active')->get();
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function amenities_type()
    {
        return $this->belongsTo('App\Models\Front\AmenitiesType', 'type_id', 'id');
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query)
    {
        $query = $query->whereStatus('Active');
        return $query;
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActiveType($query)
    {
        $query = $query->with(['amenities_type'])->whereHas('amenities_type', function($query){
            $query->where('status', 'Active');
        });

        return $query;
    }

    // Get Selected All Amenities Data

	/**
	 * @param $room_id
	 *
	 * @return array
	 */
	public static function selected($room_id)
    {

        $lang = Language::whereValue((Self::SESSION_LANG) ? Self::SESSION_LANG : @$default_lang)->first()->value;

    
      if($lang=="en"){


        $result = DB::select("select amenities.name as name,amenities.type_id,amenities.id as id,amenities.status, amenities.icon, rooms.id as status from amenities left join rooms on find_in_set(amenities.id, rooms.amenities) and rooms.id = $room_id left join amenities_type on amenities.type_id = amenities_type.id where  type_id !=4 and amenities.status='Active' and amenities_type.status = 'Active'");
      }
      else{

       
        $result = DB::select("select amenities.name as name,amenities.type_id,amenities.id as id,amenities.status, amenities.icon, rooms.id as status,(select amenities_lang.name from amenities_lang where amenities_lang.amenities_id = amenities.id and lang_code='$lang') as namelang from amenities left join rooms on find_in_set(amenities.id, rooms.amenities) and rooms.id = $room_id left join amenities_type on amenities.type_id = amenities_type.id where  type_id !=4 and amenities.status='Active' and amenities_type.status = 'Active'");
          
          


          }
        return $result;
    }

    // Get Selected Security Amenities Data

	/**
	 * @param $room_id
	 *
	 * @return array
	 */
	public static function selected_security($room_id)
    {
        // dd(Self::SESSION_LANG);
        $lang = Language::whereValue((Self::SESSION_LANG) ? Self::SESSION_LANG : @$default_lang)->first()->value;

        if($lang=="en"){
            $result = DB::select("select amenities.name as name,amenities.type_id,amenities.id as id,amenities.status, amenities.icon, rooms.id as status from amenities left join rooms on find_in_set(amenities.id, rooms.amenities) and rooms.id = $room_id left join amenities_type on amenities.type_id = amenities_type.id where type_id = 4 and amenities.status='Active' and amenities_type.status = 'Active'");
        }
        else{       
            $result = DB::select("select amenities.name as name,amenities.type_id,amenities.id as id,amenities.status, amenities.icon, rooms.id as status ,(select amenities_lang.name from amenities_lang where amenities_lang.amenities_id = amenities.id and lang_code='$lang') as namelang from amenities left join rooms on find_in_set(amenities.id, rooms.amenities) and rooms.id = $room_id left join amenities_type on amenities.type_id = amenities_type.id where type_id = 4 and amenities.status='Active' and amenities_type.status = 'Active'");
        }
        return $result;
    }

	/**
	 * @return mixed|string
	 */
	public function getNameAttribute()
    {

        if(Request::segment(1)=='admin_url')
        { 

            return $this->attributes['name'];

        }
        if(Self::SESSION_LANG) 
        {
            $lang = Self::SESSION_LANG;
        }
        else 
        {
            $default_lang = Language::where('default_language',1)->first()->value;
            $lang = $default_lang;            
        }

        if($lang == 'en')
        {
            return $this->attributes['name'];
        }
        else 
        {
            $name = @AmenitiesLang::where('amenities_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
            if($name) 
            {
                return $name;
            }
            else
            {
                return $this->attributes['name'];
            }
        }
    }

	/**
	 * @return mixed|string
	 */
	public function getDescriptionAttribute()
    {

    if(Request::segment(1)=='admin_url'){ 

   return $this->attributes['description'];

    }
        $default_lang = Language::where('default_language',1)->first()->value;

        $lang = Language::whereValue((Self::SESSION_LANG) ? Self::SESSION_LANG : $default_lang)->first()->value;

        if($lang == 'en')
            return $this->attributes['description'];
        else {
            $name = @AmenitiesLang::where('amenities_id', $this->attributes['id'])->where('lang_code', $lang)->first()->description;
            if($name)
                return $name;
            else
                return $this->attributes['description'];
        }
    }


}
