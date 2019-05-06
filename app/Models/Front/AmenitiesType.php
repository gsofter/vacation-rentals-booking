<?php

/**
 * Amenities Type Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Amenities Type
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;
/**
 * App\Models\AmenitiesType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\AmenitiesType whereStatus($value)
 * @mixin \Eloquent
 */
class AmenitiesType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'amenities_type';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\AmenitiesType[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return AmenitiesType::whereStatus('Active')->get();
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
        
        if(Session::get('language')) 
        {
            $lang = Session::get('language');
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
        else {
            $name = @AmenitiesTypeLang::where('amenities_type_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
            if($name)
                return $name;
            else
                return $this->attributes['name'];
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

        $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

        if($lang == 'en')
            return $this->attributes['description'];
        else {
            $name = @AmenitiesTypeLang::where('amenities_type_id', $this->attributes['id'])->where('lang_code', $lang)->first()->description;
            if($name)
                return $name;
            else
                return $this->attributes['description'];
        }
    }
}
