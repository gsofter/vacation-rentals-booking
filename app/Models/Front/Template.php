<?php

namespace App\Models\Front;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Class Template
 *
 * @package App\Models
 * @property int $id
 * @property string $name
 * @property string $type
 * @property string|null $action
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Page[] $pages
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Template onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Template whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Template withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Template withoutTrashed()
 * @mixin \Eloquent
 */
class Template extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];


    public $fillable = [
        'name',
	    'type',
	    'action'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
	    'name'   => 'string',
	    'type'   => 'string',
	    'action' => 'string'
    ];

	/**
	 * Page relationship
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function pages() {
		return $this->hasMany( Page::class, 'template_id', 'id' );
	}


    
}
