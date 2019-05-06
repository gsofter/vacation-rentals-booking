<?php

/**
 * Help Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Help
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Help
 *
 * @property int $id
 * @property int $category_id
 * @property int $subcategory_id
 * @property string $question
 * @property string $answer
 * @property string $suggested
 * @property string $status
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read \App\Models\HelpCategory $category
 * @property-read mixed $category_name
 * @property-read mixed $subcategory_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\HelpSubCategory[] $subcategory
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help subcategory($id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereQuestion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereSuggested($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Help whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Help extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'help';

    public $appends = ['category_name', 'subcategory_name'];

    // Get all Active status records

	/**
	 * @return \App\Models\Help[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public static function active_all()
    {
        return Help::whereStatus('Active')->get();
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function category()
    {
      return $this->belongsTo('App\Models\HelpCategory','category_id','id');
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function subcategory()
    {
      return $this->hasMany('App\Models\HelpSubCategory','category_id','category_id');
    }

	/**
	 * @param $query
	 * @param $id
	 *
	 * @return mixed
	 */
	public function scopeSubcategory_($query, $id)
    {
      return $query->where('subcategory_id', $id);
    }

	/**
	 * @return mixed|string
	 */
	public function getCategoryNameAttribute()
    {
      return HelpCategory::find($this->attributes['category_id'])->name;
    }

	/**
	 * @return mixed|string
	 */
	public function getSubcategoryNameAttribute()
    {
      return @HelpSubCategory::find($this->attributes['subcategory_id'])->name;
    }
}
