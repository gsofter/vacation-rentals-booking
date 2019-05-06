<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DB;
/**
 * App\Models\SavedWishlists
 *
 * @property int $id
 * @property int $user_id
 * @property int $room_id
 * @property string $list_type
 * @property int $wishlist_id
 * @property string $note
 * @property-read mixed $host_experience_count
 * @property-read mixed $photo_name
 * @property-read mixed $rooms_count
 * @property-read \App\Models\HostExperiences $host_experiences
 * @property-read \App\Models\ProfilePicture $profile_picture
 * @property-read \App\Models\Front\Rooms $rooms
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\RoomsPhotos[] $rooms_photos
 * @property-read \App\Models\RoomsPrice $rooms_price
 * @property-read \App\Models\Front\User $users
 * @property-read \App\Models\Wishlists $wishlists
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereListType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\SavedWishlists whereWishlistId($value)
 * @mixin \Eloquent
 */
class SavedWishlists extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'saved_wishlists';

    public $timestamps = false;
    protected $appends = ['photo_name','rooms_count','host_experience_count'];
    // Join with wishlists table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function wishlists()
    {
        return $this->belongsTo('App\Models\Wishlists','wishlist_id','id');
    }

	/**
	 * @return int
	 */
	public function getRoomsCountAttribute()
    {
        return @DB::table('saved_wishlists')->where('list_type','Rooms')->where('wishlist_id', $this->attributes['wishlist_id'])->count();
    }

	/**
	 * @return int
	 */
	public function getHostExperienceCountAttribute()
    {
        return @DB::table('saved_wishlists')->where('list_type','Experiences')->where('wishlist_id', $this->attributes['wishlist_id'])->count();
    }
    // Join with rooms table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms()
    {
        return $this->belongsTo('App\Models\Front\Rooms','room_id','id');
    }
    //Get rooms  photo_name URL

	/**
	 * @return mixed|string
	 */
	public function getPhotoNameAttribute()
    {
        if($this->attributes['list_type']=='Rooms')
        {
            $result = RoomsPhotos::where('room_id', $this->attributes['room_id'])->where('featured','Yes');
            if($result->count() == 0)
                return "room_default_no_photos.png";
            else
                return $result->first()->name;
        }
        else
        {
            $result = HostExperiencePhotos::where('host_experience_id', $this->attributes['room_id']);
            if($result->count() == 0)
                return url('/')."/images/room_default_no_photos.png";
            else
                return $result->first()->image_url;
        }
    }
    // Join with Host Experience table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function host_experiences()
    {
        return $this->belongsTo('App\Models\HostExperiences','room_id','id');
    }

    // Join with rooms_photos table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function rooms_photos()
    {
        return $this->hasMany('App\Models\RoomsPhotos','room_id','room_id');
    }

    // Join with rooms_price table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function rooms_price()
    {
        return $this->belongsTo('App\Models\RoomsPrice','room_id','room_id');
    }

    // Join with users table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function users()
    {
        return $this->belongsTo('App\Models\Front\User','user_id','id');
    }

    // Join with profile_picture table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function profile_picture()
    {
        return $this->belongsTo('App\Models\ProfilePicture','user_id','user_id');
    }
}
