<?php

/**
 * Property Type Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Property Type
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;

/**
 * App\Models\PropertyType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PropertyType whereStatus($value)
 * @mixin \Eloquent
 */
class PropertyType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'property_type';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\PropertyType[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return PropertyType::whereStatus('Active')->get();
    }

    // Get all Active status records in lists type

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public static function dropdown()
    {
       // return PropertyType::whereStatus('Active')->pluck('name','id');
        $data=PropertyType::whereStatus('Active')->get();
       return $data->pluck('name','id');
    }

	/**
	 * @return mixed|string
	 */
	// public function getNameAttribute()
    // {

    //     if(Request::segment(1)=='admin_url')
    //     { 

    //         return $this->attributes['name'];

    //     }

    //     if(Session::get('language')) {
    //         $lang = Session::get('language');  
    //     } 
    //     else 
    //     {
    //         $default_lang = Language::where('default_language',1)->first()->value;
    //         $lang = $default_lang;            
    //     }

    //     if($lang == 'en')
    //     {
    //         return $this->attributes['name'];
    //     }
    //     else 
    //     {
    //         $name = @PropertyTypeLang::where('property_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
    //         if($name)
    //             return $name;
    //         else
    //             return $this->attributes['name'];
    //     }
    // }

	// /**
	//  * @return mixed|string
	//  */
	// public function getDescriptionAttribute()
    // {
    //     if(Request::segment(1)=='admin_url'){ 

    //     return $this->attributes['description'];

    //     }
        
    //     $default_lang = Language::where('default_language',1)->first()->value;

    //     $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

    //     if($lang == 'en')
    //         return $this->attributes['description'];
    //     else {
    //         $name = @PropertyTypeLang::where('property_id', $this->attributes['id'])->where('lang_code', $lang)->first()->description;
    //         if($name)
    //             return $name;
    //         else
    //             return $this->attributes['description'];
    //     }
    // }
    
}
