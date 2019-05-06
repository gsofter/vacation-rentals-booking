<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Model;
use DB;

/**
 * App\Models\Wishlists
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $privacy
 * @property string $pick
 * @property-read mixed $all_host_experience_count
 * @property-read mixed $all_rooms_count
 * @property-read mixed $host_experience_count
 * @property-read mixed $rooms_count
 * @property-read \App\Models\ProfilePicture $profile_picture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\SavedWishlists[] $saved_wishlists
 * @property-read \App\Models\Front\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlists whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlists whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlists wherePick($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlists wherePrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wishlists whereUserId($value)
 * @mixin \Eloquent
 */
class Wishlists extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wishlists';

    public $timestamps = false;

    protected $fillable = ['name'];

    public $appends = ['rooms_count', 'all_rooms_count','host_experience_count', 'all_host_experience_count'];

	/**
	 * @param $input
	 */
	public function setNameAttribute($input){
         $this->attributes['name'] = strip_tags($input);
    }

    // Join with saved_wishlists table

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function saved_wishlists()
    {
        return $this->hasMany('App\Models\SavedWishlists','wishlist_id','id');
    }

	/**
	 * @return int
	 */
	public function getRoomsCountAttribute()
    {
        return @DB::table('saved_wishlists')->where('list_type','Rooms')->where('wishlist_id', $this->attributes['id'])->where('user_id', $this->attributes['user_id'])->count();
    }

	/**
	 * @return int
	 */
	public function getAllRoomsCountAttribute()
    {
    	return @DB::table('saved_wishlists')->where('list_type','Rooms')->where('wishlist_id', $this->attributes['id'])->count();
    }

	/**
	 * @return int
	 */
	public function getHostExperienceCountAttribute()
    {
        return @DB::table('saved_wishlists')->where('list_type','Experiences')->where('wishlist_id', $this->attributes['id'])->where('user_id', $this->attributes['user_id'])->count();
    }

	/**
	 * @return int
	 */
	public function getAllHostExperienceCountAttribute()
    {
        return @DB::table('saved_wishlists')->where('list_type','Experiences')->where('wishlist_id', $this->attributes['id'])->count();
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
