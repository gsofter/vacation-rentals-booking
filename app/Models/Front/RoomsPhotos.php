<?php

/**
 * Rooms Photos Model
 *
 * @package     Makent
 * @subpackage  Model
 * @category    Rooms Photos
 * @author      Trioangle Product Team
 * @version     1.5.4
 * @link        http://trioangle.com
 */

namespace App\Models\Front;
use App\Models\Front\Rooms;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\RoomsPhotos
 *
 * @property int $id
 * @property int $room_id
 * @property string $name
 * @property string $highlights
 * @property string|null $featured
 * @property int $order
 * @property-read mixed $banner_image_name
 * @property-read mixed $listing_image_name
 * @property-read mixed $manage_listing_photos_image_name
 * @property-read mixed $original_name
 * @property-read mixed $photos_count
 * @property-read mixed $slider_image_name
 * @property-read mixed $steps_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereHighlights($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\RoomsPhotos whereRoomId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Front\Rooms $room
 */
class RoomsPhotos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rooms_photos';

    public $timestamps = false;

    protected $appends = ['steps_count','original_name','photos_count'];

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function room() {
    	return $this->belongsTo( Rooms::class, 'room_id');
    }

    // Get steps_count using sum of rooms_steps_status

	/**
	 * @return int|mixed|string
	 */
	public function getStepsCountAttribute()
    {
        $result = RoomsStepsStatus::find($this->attributes['room_id']);

        if($result)
            return 8 - (@$result->basics + @$result->description + @$result->location + @$result->photos + @$result->pricing + @$result->calendar + @$result->plans + @$result->terms);
        else
            return 8;
    }

	/**
	 * @return mixed
	 */
	public function getOriginalNameAttribute(){
         return @$this->attributes['name'];
    }

	/**
	 * @return int
	 */
	public function getPhotosCountAttribute()
    {
        $photos = RoomsPhotos::where('room_id',$this->attributes['room_id'])->get();
        if(count($photos))
            return count($photos);
        else
            return 0;
    }

    // Get Name Attribute

	/**
	 * @return string
	 */
	public function getNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            // $name = @$photo_details['filename'].'_450x250.'.@$photo_details['extension'];
            $name = @$photo_details['filename'].'.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=450;
            $options['height']=250;
            $options['crop']='fill';
            $options['flags']='lossy';
            $options['quality']='auto:low';

            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }


    }
    // Get Slider Image Name Attribute

	/**
	 * @return string
	 */
	public function getSliderImageNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            $name = @$photo_details['filename'].'_1440x960.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=1440;
            $options['height']=960;
            $options['crop']='fill';
            $options['flags']='lossy';
            $options['quality']='auto:low';
            // $options['crop']='fill';
            // $options['crop']='fill';
             
            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }
        
    }
    // Get Banner Image Name Attribute

	/**
	 * @return string
	 */
	public function getBannerImageNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            $name = @$photo_details['filename'].'_1349x402.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=1349;
            $options['height']=402;
            $options['crop']='fill';
            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }
    }


    // Get Slider Image Name Attribute

	/**
	 * @return string
	 */
	public function getListingImageNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            $name = @$photo_details['filename'].'_100x100.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=100;
            $options['height']=100;
            $options['crop']='fill';
            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }
    }

    // Get Slider Image Name Attribute

	/**
	 * @return string
	 */
	public function getManageListingPhotosImageNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            $name = @$photo_details['filename'].'_450x250.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=200;
            $options['height']=200;
            $options['crop']='fill';
            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }
    }
    // Get Slider Image Name Attribute

	/**
	 * @return string
	 */
	public function getManageSearchListingPhotosImageNameAttribute(){
        $photo_src=explode('.',$this->attributes['name']);
        if($this->attributes['storage'] == 'local')
        {
            $photo_details = pathinfo($this->attributes['name']); 
            $name = @$photo_details['filename'].'_450x250.'.@$photo_details['extension'];
            return url('/').'/images/rooms/'.$this->attributes['room_id'].'/'.$name;
        }
        else
        {
            $options['secure']=TRUE;
            $options['width']=400;
            $options['height']=200;
            $options['crop']='fill';
            $path_parts = pathinfo($this->attributes['name']);
            // return $path_parts['filename'];
            return $src=\Cloudder::show('/images/rooms/'.$this->attributes['room_id'].'/'.$path_parts['filename'],$options);
        }
    }
}
