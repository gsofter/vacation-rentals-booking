<?php

/**
 * Room Type Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Room Type
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;
/**
 * App\Models\RoomType
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $is_shared
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomType whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomType whereIsShared($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomType whereStatus($value)
 * @mixin \Eloquent
 */
class RoomType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'room_type';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\RoomType[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return RoomType::whereStatus('Active')->get();
    }

    // Get all Active status records in lists type

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public static function dropdown()
    {
        //return RoomType::whereStatus('Active')->pluck('name','id');
        $data=RoomType::whereStatus('Active')->get();
        return $data->pluck('name','id');
    }

    // Get single field data by using id and field name

	/**
	 * @param $id
	 * @param $field
	 *
	 * @return mixed
	 */
	public static function single_field($id, $field)
    {
        return RoomType::whereId($id)->first()->$field;
    }

	/**
	 * @return mixed|string
	 */
	public function getNameAttribute()
    {    

        // if(Request::segment(1)=='admin_url')
        // { 

        //     return $this->attributes['name'];

        // }

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
        else 
        {
            $name = @RoomTypeLang::where('room_type_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
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
        // if(Request::segment(1)=='admin_url')
        // { 

        //     return $this->attributes['description'];

        // }
        
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
            return $this->attributes['description'];
        }
        else 
        {
            $name = @RoomTypeLang::where('room_type_id', $this->attributes['id'])->where('lang_code', $lang)->first()->description;
            if($name)
                return $name;
            else
                return $this->attributes['description'];
        }
    }

}
