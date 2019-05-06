<?php
/**
 * DisputeDocuments Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    DisputeDocuments
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DisputeDocuments
 *
 * @property int $id
 * @property int $dispute_id
 * @property string $file
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property-read mixed $file_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeDocuments whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeDocuments whereDisputeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeDocuments whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeDocuments whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DisputeDocuments whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DisputeDocuments extends Model
{
	/**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dispute_documents';

    //public $timestamps = false;

	/**
	 * @return string
	 */
	public function getFileUrlAttribute()
    {
    	$photo_src=explode('.',$this->attributes['file']);
        if(count($photo_src)>1)
        {
            $name = $this->attributes['file'];
            return url('/').'/images/disputes/'.$this->attributes['dispute_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['crop']='fill';
            return $src=\Cloudder::show($this->attributes['file'],$options);
        }
    }
}

