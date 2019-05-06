<?php

/**
 * Bed Type Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Bed Type
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Session;
use Request;

/**
 * App\Models\BedType
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BedType whereStatus($value)
 * @mixin \Eloquent
 */
class BedType extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bed_type';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\BedType[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return BedType::whereStatus('Active')->get();
    }

	/**
	 * @return mixed|string
	 */
	public function getNameAttribute()
    {
        if(Request::segment(1)=='admin_url'){ 

        return $this->attributes['name'];

        }
        $default_lang = Language::where('default_language',1)->first()->value;

        $lang = Language::whereValue((Session::get('language')) ? Session::get('language') : $default_lang)->first()->value;

        if($lang == 'en')
            return $this->attributes['name'];
        else {
            $name = @BedTypeLang::where('bed_type_id', $this->attributes['id'])->where('lang_code', $lang)->first()->name;
            if($name)
                return $name;
            else
                return $this->attributes['name'];
        }
    }
}
