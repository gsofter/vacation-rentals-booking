<?php

/**
 * Help Category Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Help Category
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\HelpCategory
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property-read \App\Models\HelpSubCategory $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpCategory whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\HelpCategory whereStatus($value)
 * @mixin \Eloquent
 */
class HelpCategory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help_category';

    public $timestamps = false;

    // Get all Active status records

	/**
	 * @return \App\Models\HelpCategory[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
    	return HelpCategory::whereStatus('Active')->get();
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function subcategory()
    {
      return $this->belongsTo('App\Models\HelpSubCategory','category_id','id');
    }
}
