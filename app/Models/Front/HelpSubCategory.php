<?php

/**
 * Help Subcategory Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Help Subcategory
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HelpSubCategory
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property-read \App\Models\HelpCategory $category
 * @property-read mixed $category_name
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpSubCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpSubCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpSubCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpSubCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpSubCategory whereStatus($value)
 * @mixin \Eloquent
 */
class HelpSubCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help_subcategory';

    public $timestamps = false;

    public $appends = ['category_name'];

    // Get all Active status records

	/**
	 * @return \App\Models\HelpSubCategory[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return HelpSubCategory::whereStatus('Active')->get();
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category()
    {
      return $this->belongsTo('App\Models\HelpCategory','id','category_id');
    }

	/**
	 * @return mixed|string
	 */
	public function getCategoryNameAttribute()
    {
      return HelpCategory::find($this->attributes['category_id'])->name;
    }
}
