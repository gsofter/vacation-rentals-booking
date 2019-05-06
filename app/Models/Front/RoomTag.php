<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use Log;

/**
 * App\Models\RoomTag
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $category
 * @property string $image
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $image_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Front\Rooms[] $rooms
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomTag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class RoomTag extends Model
{

    protected $guarded = [];
    public $appends = ['image_url'];

    // Join with rooms table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function rooms() {
    	return $this->belongsToMany(Rooms::class, 'room_tag', 'tag_id', 'room_id');
    }

	/**
	 * @param $query
	 *
	 * @return mixed
	 */
	public function scopeActive($query) {
    	return $query->whereStatus('Active');
    }

	/**
	 * @return string
	 */
    public function getImageUrlAttribute(){
        $photo_src=explode('.',$this->attributes['image']);
        if(count($photo_src) > 1)
        {
            $photo_details = pathinfo($this->attributes['image']); 
            $name = url('/images').@$this->attributes['image'];
            // return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=353;
            $options['height']=400;
            $options['crop']='fill';
            $options['flags']='lossy';
            $options['quality']='auto:low';
            $options['crop']='fill';
            // $path_parts = pathinfo($this->attributes['image']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show("/images/".$this->attributes['image'],$options);
        }
    }
	// public function getImageUrlAttribute()
    // {
    //     $photo_src=explode('.',$this->attributes['image']);
    //     if(count($photo_src)>1)
    //     {
    //         return $src = url('/').'/images/rooms/tags/'.$this->attributes['image'];
    //     }
    //     else
    //     {
    //         $options['secure']=TRUE;
    //         // $options['width']=1300;
    //         // $options['height']=600;
    //         $options['crop']    = 'fill';
    //         return $src=\Cloudder::show($this->attributes['image'],$options);
    //     }
    // }

}
